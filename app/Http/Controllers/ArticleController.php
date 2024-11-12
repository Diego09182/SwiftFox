<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    // 搜索文章
    public function search(Request $request)
    {
        $search = $request->input('search');
        $cacheKey = 'search_articles_' . md5($search);

        $articles = Cache::tags(['articles'])->remember($cacheKey, 600, function () use ($search) {
            return empty($search)
                ? Article::latest()->paginate(6)
                : Article::where('title', 'LIKE', "%$search%")->paginate(6);
        });

        return view('swiftfox.article.search', compact('articles', 'search'));
    }

    // 顯示所有文章列表
    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $cacheKey = 'articles_page_' . $page;

        $articles = Cache::tags(['articles'])->remember($cacheKey, 600, function () {
            return Article::orderBy('id', 'desc')->paginate(6);
        });

        $user = Auth::user();

        return view('swiftfox.article.index', compact('articles', 'user'));
    }

    // 儲存新文章
    public function store(Request $request)
    {
        // 檢查文章數量限制
        try {
            $this->articleService->checkArticleLimit();
        } catch (\Exception $e) {
            return redirect()->route('article.index')->with('error', $e->getMessage());
        }

        // 驗證並儲存新文章
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:30',
            'content' => 'required|min:50|max:1000',
            'tag' => 'required|in:大學面試,競賽經驗,學習歷程,活動分享',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過30個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要50個字',
            'content.max' => '內容不能超過1000個字',
            'tag.required' => '標籤為必填項目',
            'tag.in' => '標籤必須符合選項',
        ]);

        $validatedData['content'] = nl2br($validatedData['content']);
        $validatedData['user_id'] = auth()->id();

        Article::create($validatedData);

        $this->clearCache();

        return redirect()->route('article.index')->with('success', '文章已創建成功！');
    }

    // 顯示特定文章詳情
    public function show($id)
    {
        $cacheKey = 'article_' . $id;

        $article = Cache::tags(['articles'])->remember($cacheKey, 600, function () use ($id) {
            return Article::findOrFail($id);
        });

        $user = Auth::user();

        return view('swiftfox.article.show', compact('article', 'user'));
    }

    public function create()
    {
        return view('swiftfox.article.create');
    }

    // 刪除文章
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if (Gate::denies('delete-article', $article)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $article->delete();

        $this->clearCache();

        return redirect()->route('article.index')->with('success', '文章已成功刪除！');
    }

    // 清除所有相關快取
    private function clearCache()
    {
        Cache::tags(['articles'])->flush();
    }
}
