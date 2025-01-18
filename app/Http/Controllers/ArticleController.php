<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $articles = $this->articleService->searchArticles($search);

        return view('swiftfox.article.search', compact('articles', 'search'));
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $articles = $this->articleService->getArticlesByPage($page);
        $user = Auth::user();

        return view('swiftfox.article.index', compact('articles', 'user'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:50|max:2000',
            'tag' => 'required|in:大學面試,競賽經驗,學習歷程,活動分享',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過20個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要50個字',
            'content.max' => '內容不能超過2000個字',
            'tag.required' => '標籤為必填項目',
            'tag.in' => '標籤必須符合選項',
        ]);

        $this->articleService->createArticle($validatedData);

        return redirect()->route('article.index')->with('success', '文章已創建成功！');
    }

    public function show($id)
    {
        $article = $this->articleService->getArticleById($id);
        $user = Auth::user();

        return view('swiftfox.article.show', compact('article', 'user'));
    }

    public function create()
    {
        return view('swiftfox.article.create');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if (Gate::denies('delete-article', $article)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->articleService->deleteArticle($article);

        return redirect()->route('article.index')->with('success', '文章已成功刪除！');
    }
}
