<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleService extends AbstractService
{
    protected string $cacheTag = 'articles';

    protected function getModelClass(): string
    {
        return Article::class;
    }

    public function getArticles(int $perPage = 8)
    {
        $page = request('page', 1);
        $key = $this->cacheKey("index_page_{$page}");

        return $this->rememberEmpty($key, 600, fn () => Article::orderByDesc('id')->paginate($perPage));
    }

    public function searchArticles(?string $search = null, int $perPage = 6)
    {
        $page = request('page', 1);
        $key = $this->cacheKey('search_'.md5((string) $search)."_page_{$page}");

        return $this->rememberEmpty($key, 600, fn () => $this->buildSearchQuery($search)->paginate($perPage));
    }

    public function getArticleById(int $id)
    {
        $key = $this->cacheKey("show_{$id}");

        return $this->rememberEmpty($key, 600, fn () => Article::findOrFail($id));
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
        $this->clearCache($article->id);
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

    public function clearCache(?int $id = null): void
    {
        if ($id) {
            $this->flushCache($this->cacheKey("show_{$id}"));
        }
        $this->flushCache();
    }
}
