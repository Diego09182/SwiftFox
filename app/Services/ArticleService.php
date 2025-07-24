<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ArticleService
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function searchArticles(?string $search = null)
    {
        $cacheKey = 'search_articles_'.md5($search);

        return Cache::tags(['articles'])->remember($cacheKey, 600, function () use ($search) {
            return empty($search)
                    ? Article::latest()->paginate(6)
                    : Article::where('title', 'LIKE', "%$search%")->paginate(6);
        });
    }

    public function getArticlesByPage(int $page)
    {
        $cacheKey = 'articles_page_'.$page;

        return Cache::tags(['articles'])->remember($cacheKey, 600, function () {
            return Article::orderBy('id', 'desc')->paginate(8);
        });
    }

    public function getArticleById(int $id)
    {
        $cacheKey = 'article_'.$id;

        return Cache::tags(['articles'])->remember($cacheKey, 600, function () use ($id) {
            return Article::findOrFail($id);
        });
    }

    public function createArticle(array $data)
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = Auth::id();

        $cleanContent = mb_substr(strip_tags($data['content']), 0, 1000);

        try {
            $summary = $this->gemini->generateSummary($cleanContent);
        } catch (\Throwable $e) {
            logger()->error('生成文章摘要失敗：'.$e->getMessage());
            $summary = null;
        }

        $data['summary'] = $summary ?? '（自動摘要生成失敗）';

        $article = Article::create($data);

        $this->clearCache();

        return $article;
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();

        $this->clearCache();
    }

    public function clearCache()
    {
        Cache::tags(['articles'])->flush();
    }
}
