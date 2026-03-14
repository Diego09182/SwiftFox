<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\Post;
use App\Models\User;
use App\Notifications\ResourceNotification;
use DomainException;
use Illuminate\Support\Facades\Gate;

class PostService extends AbstractService
{
    protected string $cacheTag = 'posts';

    protected function getModelClass(): string
    {
        return Post::class;
    }

    public function getPostsByPage(int $page = 1, int $perPage = 9)
    {
        $key = $this->cacheKey("index_page_{$page}_{$perPage}");

        return $this->rememberEmpty($key, 600, fn () => Post::latest()->paginate($perPage));
    }

    public function getWeeklyTopPosts(int $limit = 3)
    {
        $key = $this->cacheKey("weekly_top_{$limit}");

        return $this->rememberEmpty($key, 600, fn () => Post::orderByDesc('like')->take($limit)->get());
    }

    public function getPostsByFilter(?string $filter, int $page = 1, int $perPage = 9)
    {
        if (! $filter) {
            return $this->getPostsByPage($page, $perPage);
        }
        $key = $this->cacheKey("filter_{$filter}_page_{$page}_{$perPage}");

        return $this->rememberEmpty($key, 600, fn () => Post::where('category', $filter)->latest()->paginate($perPage));
    }

    public function getRelatedPosts(Post $post, int $limit = 5)
    {
        $key = $this->cacheKey("related_{$post->id}_{$limit}");

        return $this->rememberEmpty($key, 600, fn () => Post::where('category', $post->category)->where('id', '<>', $post->id)->latest()->take($limit)->get());
    }

    public function searchPosts(?string $keyword, int $page = 1, int $perPage = 9)
    {
        if (! $keyword) {
            return $this->getPostsByPage($page, $perPage);
        }
        $key = $this->cacheKey('search_'.md5($keyword)."_page_{$page}_{$perPage}");

        return $this->rememberEmpty($key, 600, fn () => Post::where('title', 'like', "%{$keyword}%")->orWhere('content', 'like', "%{$keyword}%")->latest()->paginate($perPage));
    }

    public function getPostById(int $id): Post
    {
        $key = $this->cacheKey("show_{$id}");

        return $this->rememberEmpty($key, 600, fn () => Post::with('comments')->findOrFail($id));
    }

    public function viewPost(int $id): Post
    {
        $post = $this->getPostById($id);
        $post->increment('view');
        $this->clearCache($post->id);

        return $post->fresh();
    }

    public function createPost(array $data, User $user): Post
    {
        $data['user_id'] = $user->id;
        $data['content'] = nl2br($data['content'] ?? '');
        $post = Post::create($data);
        $user->increment('points', 10);
        $this->clearCache();

        return $post->fresh();
    }

    public function deletePost(Post $post, User $actor): void
    {
        if (Gate::denies('delete-post', $post)) {
            throw new DomainException('您沒有權限刪除此資源');
        }
        if ($actor->administration === 5) {
            $post->user->notify(new ResourceNotification(resourceType: 'post', resourceId: $post->id, title: '貼文已刪除', reason: '違反社群規範'));
        }
        $post->delete();
        $this->clearCache($post->id);
    }

    public function like(Post $post, User $user): Post
    {
        if ($this->hasEvaluated($post, $user)) {
            throw new DomainException('已經評價過了');
        }
        $post->increment('like');
        Evaluation::create(['post_id' => $post->id, 'user_id' => $user->id, 'evaluation' => 1]);
        $this->clearCache($post->id);

        return $post->fresh();
    }

    public function dislike(Post $post, User $user): Post
    {
        if ($this->hasEvaluated($post, $user)) {
            throw new DomainException('已經評價過了');
        }
        $post->increment('dislike');
        Evaluation::create(['post_id' => $post->id, 'user_id' => $user->id, 'evaluation' => -1]);
        $this->clearCache($post->id);

        return $post->fresh();
    }

    protected function hasEvaluated(Post $post, User $user): bool
    {
        return Evaluation::where('post_id', $post->id)->where('user_id', $user->id)->exists();
    }

    public function clearCache(?int $postId = null): void
    {
        if ($postId) {
            $this->flushCache($this->cacheKey("show_{$postId}"));
            $this->flushCache($this->cacheKey("related_{$postId}_5"));
        }
        $this->flushCache();
    }
}
