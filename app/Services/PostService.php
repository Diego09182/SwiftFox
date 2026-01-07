<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use App\Models\Evaluation;
use App\Notifications\ResourceNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class PostService
{
    /* ===================== 查詢 ===================== */

    public function getPostsByPage(int $page)
    {
        return Cache::tags(['posts'])->remember(
            "posts_page_{$page}",
            600,
            fn () => Post::latest()->paginate(9, ['*'], 'page', $page)
        );
    }

    public function getWeeklyTopPosts(int $limit = 10)
    {
        return Cache::tags(['posts', 'weekly'])->remember(
            "weekly_top_{$limit}",
            600,
            fn () => Post::where('created_at', '>=', now()->subDays(7))
                ->orderByRaw('(view * 2) + (`like` * 3) DESC')
                ->limit($limit)
                ->get()
        );
    }

    public function getPostsByFilter(string $filter, int $page)
    {
        return Cache::tags(['posts'])->remember(
            "posts_filter_{$filter}_{$page}",
            600,
            function () use ($filter, $page) {
                return match ($filter) {
                    '觀看次數' => Post::orderBy('view', 'desc')->paginate(9, ['*'], 'page', $page),
                    '喜歡次數' => Post::orderBy('like', 'desc')->paginate(9, ['*'], 'page', $page),
                    default    => Post::latest()->paginate(9, ['*'], 'page', $page),
                };
            }
        );
    }

    public function searchPosts(?string $search, int $page)
    {
        if (empty($search)) {
            return $this->getPostsByPage($page);
        }

        return Cache::tags(['posts'])->remember(
            "posts_search_" . md5($search) . "_{$page}",
            600,
            fn () => Post::where('title', 'like', "%{$search}%")
                ->orWhere('content', 'like', "%{$search}%")
                ->orWhere('tag', 'like', "%{$search}%")
                ->paginate(9, ['*'], 'page', $page)
        );
    }

    public function getRelatedPosts(Post $post, int $limit = 3)
    {
        return Post::where('id', '!=', $post->id)
            ->where('tag', $post->tag)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /* ===================== 行為（不丟 Exception） ===================== */

    public function viewPost(int $id): ?Post
    {
        $post = Cache::tags(['posts'])->remember(
            "post_{$id}",
            600,
            fn () => Post::with('comments')->find($id)
        );

        if (!$post) {
            return null;
        }

        $post->increment('view');
        $this->clearPostCache($id);

        return $post->fresh();
    }

    public function createPost(array $data, User $user): array
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = $user->id;

        $post = Post::create($data);

        $user->increment('points', 10);
        $this->clearAllCache();

        return $this->success($post);
    }

    public function like(Post $post, User $user): array
    {
        if ($this->hasEvaluated($post, $user)) {
            return $this->fail('已經評價過了');
        }

        $post->increment('like');
        $this->recordEvaluation($post, $user, 1);
        $this->clearPostCache($post->id);

        return $this->success($post->fresh());
    }

    public function dislike(Post $post, User $user): array
    {
        if ($this->hasEvaluated($post, $user)) {
            return $this->fail('已經評價過了');
        }

        $post->increment('dislike');
        $this->recordEvaluation($post, $user, -1);
        $this->clearPostCache($post->id);

        return $this->success($post->fresh());
    }

    public function deletePost(Post $post, User $actor): array
    {
        if (Gate::denies('delete-post', $post)) {
            return $this->fail('您沒有權限刪除此資源');
        }

        if ($actor->administration === 5) {
            $post->user->notify(new ResourceNotification(
                resourceType: 'post',
                resourceId: $post->id,
                title: '貼文已刪除',
                reason: '違反社群規範'
            ));
        }

        $post->delete();
        $this->clearAllCache();

        return $this->success();
    }

    /* ===================== 內部方法 ===================== */

    private function hasEvaluated(Post $post, User $user): bool
    {
        return Evaluation::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    private function recordEvaluation(Post $post, User $user, int $value): void
    {
        Evaluation::create([
            'post_id'    => $post->id,
            'user_id'    => $user->id,
            'evaluation' => $value,
        ]);
    }

    private function clearAllCache(): void
    {
        Cache::tags(['posts'])->flush();
    }

    private function clearPostCache(int $id): void
    {
        Cache::tags(['posts'])->forget("post_{$id}");
    }

    private function success($data = null): array
    {
        return [
            'success' => true,
            'message' => null,
            'data'    => $data,
        ];
    }

    private function fail(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
            'data'    => null,
        ];
    }
}
