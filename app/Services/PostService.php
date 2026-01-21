<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\Post;
use App\Models\User;
use App\Notifications\ResourceNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class PostService
{
    protected string $cacheTag = 'posts';

    public function getPosts()
    {
        $page = request('page', 1);

        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("index_page_{$page}"), 600, fn () => Post::latest()->paginate(9));
    }

    public function getPostById(int $id)
    {
        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("show_{$id}"), 600, fn () => Post::with('comments')->findOrFail($id));
    }

    public function viewPost(Post $post)
    {
        $post->increment('view');
        $this->clearCache($post->id);

        return $post->fresh();
    }

    public function createPost(array $data, User $user)
    {
        $data['user_id'] = $user->id;
        $data['content'] = nl2br($data['content'] ?? '');
        $post = Post::create($data);
        $user->increment('points', 10);
        $this->clearCache();

        return $this->success($post);
    }

    public function deletePost(Post $post, User $actor)
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
        $this->clearCache();

        return $this->success();
    }

    public function like(Post $post, User $user)
    {
        if ($this->hasEvaluated($post, $user)) {
            return $this->fail('已經評價過了');
        }

        $post->increment('like');
        Evaluation::create(['post_id' => $post->id, 'user_id' => $user->id, 'evaluation' => 1]);
        $this->clearCache($post->id);

        return $this->success($post->fresh(), '已喜歡');
    }

    public function dislike(Post $post, User $user)
    {
        if ($this->hasEvaluated($post, $user)) {
            return $this->fail('已經評價過了');
        }

        $post->increment('dislike');
        Evaluation::create(['post_id' => $post->id, 'user_id' => $user->id, 'evaluation' => -1]);
        $this->clearCache($post->id);

        return $this->success($post->fresh(), '已不喜歡');
    }

    protected function hasEvaluated(Post $post, User $user): bool
    {
        return Evaluation::where('post_id', $post->id)->where('user_id', $user->id)->exists();
    }

    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    protected function clearCache(?int $postId = null): void
    {
        Cache::tags([$this->cacheTag])->flush();
        if ($postId) {
            Cache::tags([$this->cacheTag])->forget($this->cacheKey("show_{$postId}"));
        }
    }

    protected function success($data = null, ?string $message = null): array
    {
        return ['success' => true, 'message' => $message, 'data' => $data];
    }

    protected function fail(string $message): array
    {
        return ['success' => false, 'message' => $message, 'data' => null];
    }
}
