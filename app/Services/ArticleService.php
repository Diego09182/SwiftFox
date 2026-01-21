<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ArticleService
{
    protected string $cacheTag = 'articles';

    public function searchArticles(?string $search = null, int $perPage = 6)
    {
        $cacheKey = $this->cacheKey('search_'.md5((string) $search));

        return Cache::tags([$this->cacheTag])->remember($cacheKey, 600, function () use ($search, $perPage) {
            return $this->buildSearchQuery($search)->paginate($perPage);
        });
    }

    public function getArticles(int $perPage = 8)
    {
        $page = request('page', 1);
        $cacheKey = $this->cacheKey("index_page_{$page}");

        return Cache::tags([$this->cacheTag])->remember($cacheKey, 600, function () use ($perPage) {
            return Article::orderByDesc('id')->paginate($perPage);
        });
    }

    public function getArticleById(int $id)
    {
        $cacheKey = $this->cacheKey("show_{$id}");

        return Cache::tags([$this->cacheTag])->remember($cacheKey, 600, function () use ($id) {
            return Article::findOrFail($id);
        });
    }

    public function createArticle(array $data): Article
    {
        $data['user_id'] = Auth::id();
        $data['summary'] = $this->makeSummary($data['content'] ?? '');

        $article = Article::create($data);

        $this->clearCache();

        return $article->fresh();
    }

    public function deleteArticle(Article $article): void
    {
        $article->delete();
        $this->clearCache();
    }

    protected function buildSearchQuery(?string $search)
    {
        if (empty($search)) {
            return Article::latest();
        }

        return Article::where('title', 'LIKE', '%'.$search.'%');
    }

    protected function makeSummary(string $content, int $length = 30): string
    {
        return mb_substr(strip_tags($content), 0, $length).'...';
    }

    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    protected function clearCache(): void
    {
        Cache::tags([$this->cacheTag])->flush();
    }
}
