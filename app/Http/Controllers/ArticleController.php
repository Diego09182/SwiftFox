<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Notifications\ResourceNotification;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleService $articleService
    ) {}

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $articles = $this->articleService->getArticlesByPage($page);

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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'   => 'required|min:2|max:40',
            'content' => 'required|min:50|max:2000',
            'tag'     => 'required|in:大學面試,競賽經驗,學習歷程,活動分享',
        ], [
            'title.required'   => '標題為必填項目',
            'title.min'        => '標題至少需要2個字',
            'title.max'        => '標題不能超過40個字',
            'content.required' => '內容為必填項目',
            'content.min'      => '內容至少需要50個字',
            'content.max'      => '內容不能超過2000個字',
            'tag.required'     => '標籤為必填項目',
            'tag.in'           => '標籤必須符合選項',
        ]);

        $this->articleService->createArticle($validatedData);

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
        if (Gate::denies('delete-article', $article)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

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
