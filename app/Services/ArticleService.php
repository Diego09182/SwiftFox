<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ArticleService
{
    public function searchArticles(?string $search = null)
    {
        $cacheKey = 'search_articles_' . md5($search);

        return Cache::tags(['articles'])->remember($cacheKey, 600, function () use ($search) {
            if (empty($search)) {
                return Article::latest()->paginate(6);
            }

            return Article::where('title', 'LIKE', "%$search%")->paginate(6);
        });
    }

    public function getArticlesByPage(int $page)
    {
        $cacheKey = 'articles_page_' . $page;

        return Cache::tags(['articles'])->remember($cacheKey, 600, function () {
            return Article::orderBy('id', 'desc')->paginate(8);
        });
    }

    public function getArticleById(int $id)
    {
        $cacheKey = 'article_' . $id;

        return Cache::tags(['articles'])->remember($cacheKey, 600, function () use ($id) {
            return Article::find($id); // 不使用 findOrFail，避免 Exception
        });
    }

    public function createArticle(array $data)
    {
        $data['user_id'] = Auth::id();
        $data['summary'] = mb_substr(strip_tags($data['content']), 0, 30) . '...';

        $article = Article::create($data);

        $this->clearCache();

        return $article->fresh();
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();
        $this->clearCache();
    }

    private function clearCache()
    {
        Cache::tags(['articles'])->flush();
    }
}
