<?php

namespace App\Services;

use App\Models\Evaluation;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostService
{
    public function getWeeklyTopPosts(int $limit = 10)
    {
        $cacheKey = 'weekly_top_posts_'.$limit;

        return Cache::tags(['posts', 'top', 'weekly'])->remember($cacheKey, 600, function () use ($limit) {
            return Post::withCount('comments')
                        ->where('created_at', '>=', now()->subDays(7))
                        ->orderByRaw('(view * 2) + (`like` * 3) DESC')
                        ->limit($limit)
                        ->get();
        });
    }

    public function getPostsByPage(int $page)
    {
        $cacheKey = 'posts_page_'.$page;

        return Cache::tags(['posts'])->remember($cacheKey, 600, function () {
            return Post::latest()->paginate(9);
        });
    }

    public function getPostsByFilter(string $filter, int $page)
    {
        $cacheKey = 'posts_filter_'.$filter.'_page_'.$page;

        return Cache::tags(['posts', 'filter_'.$filter])->remember($cacheKey, 600, function () use ($filter) {
            return match ($filter) {
                '觀看次數' => Post::orderBy('view', 'desc')->paginate(9),
                '喜歡次數' => Post::orderBy('like', 'desc')->paginate(9),
                default => Post::orderBy('id', 'desc')->paginate(9),
            };
        });
    }

    public function searchPosts(string $search, int $page)
    {
        $cacheKey = 'posts_search_'.md5($search).'_page_'.$page;

        return Cache::tags(['posts', 'search'])->remember($cacheKey, 600, function () use ($search) {
            if (empty($search)) {
                return Post::latest()->paginate(9);
            }

            return Post::where('title', 'LIKE', "%$search%")
                        ->orWhere('content', 'LIKE', "%$search%")
                        ->orWhere('tag', 'LIKE', "%$search%")
                        ->paginate(9);
        });
    }

    public function getPostById(int $id)
    {
        return Post::with('comments')->findOrFail($id);
    }

    public function createPost(array $data)
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = Auth::id();

        $post = Post::create($data);

        $this->clearCache();

        return $post;
    }

    public function deletePost(Post $post)
    {
        $this->clearCache();
        $post->delete();
    }

    public function likePost(Post $post)
    {
        $this->evaluatePost($post, 1);
        $post->increment('like');
        $this->clearPostCache($post->id);

        return $post;
    }

    public function dislikePost(Post $post)
    {
        $this->evaluatePost($post, -1);
        $post->increment('dislike');
        $this->clearPostCache($post->id);

        return $post;
    }

    private function evaluatePost(Post $post, int $evaluationValue)
    {
        $user = Auth::user();

        $evaluation = Evaluation::where('post_id', $post->id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($evaluation) {
            throw new \Exception('已經評價過了');
        }

        Evaluation::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'evaluation' => $evaluationValue,
        ]);
    }

    public function incrementPostView(Post $post)
    {
        $post->increment('view');
        $this->clearPostCache($post->id);
    }

    private function clearCache()
    {
        Cache::tags(['posts'])->flush();
    }

    private function clearPostCache($id)
    {
        Cache::tags(['posts'])->forget("post_{$id}");
    }
}
