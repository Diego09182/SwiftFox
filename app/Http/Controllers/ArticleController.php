<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Notifications\ResourceNotification;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleService $articleService
    ) {}

    public function index()
    {
        $articles = $this->articleService->getArticles();

        return view('swiftfox.article.index', compact('articles'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $articles = $this->articleService->searchArticles($search);

        return view('swiftfox.article.search', compact('articles', 'search'));
    }

    public function create()
    {
        return view('swiftfox.article.create');
    }

    public function store(StoreArticleRequest $request)
    {
        $this->articleService->createArticle($request->validated());

        Auth::user()->increment('points', 10);

        return redirect()
            ->route('article.index')
            ->with('success', '文章已創建成功！');
    }

    public function show(int $id)
    {
        $article = $this->articleService->getArticleById($id);

        return view('swiftfox.article.show', compact('article'));
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $currentUser = Auth::user();
        $author = $article->user;

        if ($currentUser->administration === 5) {
            $author->notify(new ResourceNotification(
                resourceType: 'article',
                resourceId: $article->id,
                title: '文章已刪除',
                reason: '違反社群規範'
            ));
        }

        $this->articleService->deleteArticle($article);

        return redirect()
            ->route('article.index')
            ->with('success', '文章已成功刪除！');
    }
}
