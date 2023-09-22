<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class ArticleController extends Controller
{
    // 顯示所有文章列表
    public function index()
    {
        // 獲取所有文章，每頁3筆資料，按貼文 ID 降冪排序
        $articles = Article::orderBy('id', 'desc')->paginate(3);

        // 獲取使用者訊息
        $user = Auth::user();

        // 返回文章列表，並將分頁結果傳遞到視圖
        return view('swiftfox.article.index', ['articles' => $articles, 'user' => $user]);
    }

    public function create()
    {
        // 獲取使用者訊息
        $user = Auth::user();
        
        // 返回文章列表，並將分頁結果傳遞到視圖
        return view('swiftfox.article.create', ['user' => $user]);
    }

    // 儲存新文章
    public function store(Request $request)
    {
        // 驗證並儲存新文章
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:10',
            'content' => 'required|min:2|max:400',
            'tag' => 'required|in:大學面試,競賽經驗,學習歷程,活動分享',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過10個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過400個字',
            'tag.required' => '標籤為必填項目',
            'tag.in' => '標籤必須符合選項',
        ]);

        $article = new Article($validatedData);
        $article->user_id = auth()->user()->id;
        $article->save();

        // 重定向到文章列表，並顯示成功消息
        return redirect('/swiftfox/article')->with('success', '文章已創建成功！');
    }

    // 顯示特定文章詳情
    public function show($id)
    {
        // 查找特定文章
        $article = Article::findOrFail($id);

        // 獲取使用者訊息
        $user = Auth::user();

        // 返回文章詳情，包括相關評論
        return view('swiftfox.article.show', ['article' => $article, 'user' => $user]);
    }

    // 刪除文章
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        // 重定向到文章列表，並顯示成功消息
        return redirect('/swiftfox/articles')->with('success', '文章已成功刪除！');
    }
}
