<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Evaluation;
class PostController extends Controller
{
    
    public function like(Post $post)
    {
        $user = auth()->user();

        // 檢查用戶是否已對該貼文進行評價，如果已評價則不再允許評價
        $evaluation = Evaluation::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($evaluation) {
            return back()->with('success', '您已經對該貼文進行了評價。');
        }

        // 創建一條喜歡的評價記錄
        Evaluation::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'evaluation' => 1, // 1 表示喜歡
        ]);

        // 增加帖子的喜歡數量
        $post->increment('like');

        return back()->with('success', '您已成功喜歡該貼文。');
    }

    public function dislike(Post $post)
    {
        $user = auth()->user();

        // 檢查用戶是否已對該貼文進行評價，如果已評價則不再允許評價
        $evaluation = Evaluation::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($evaluation) {
            return back()->with('success', '您已經對該貼文進行了評價。');
        }

        // 創建一條不喜歡的評價記錄
        Evaluation::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'evaluation' => -1, // -1 表示不喜歡
        ]);

        // 增加帖子的不喜歡數量
        $post->increment('dislike');

        return back()->with('success', '您已成功不喜歡該貼文。');
    }

    // 顯示所有文章列表
    public function index()
    {
        // 獲取所有文章，每頁 9 筆資料，按貼文 ID 降冪排序
        $posts = Post::orderBy('id', 'desc')->paginate(9);

        // 獲取使用者訊息
        $user = Auth::user();

        // 返回文章列表，並將分頁結果傳遞到視圖
        return view('swiftfox.forum.index', ['posts' => $posts, 'user' => $user]);
    }

    // 儲存新貼文
    public function store(Request $request)
    {
        // 驗證並儲存新貼文
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:10',
            'content' => 'required|min:2|max:50', 
            'tag' => 'required|in:學科問題,社團問題,自主學習,大學面試,活動宣傳',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過10個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字', 
            'tag.required' => '標籤為必填項目',
            'tag.in' => '標籤必須符合選項',
        ]);

        // 使用 nl2br 函數換行轉換 content
        $post = new Post($validatedData);
        $post->content = nl2br($validatedData['content']);
        $post->user_id = auth()->user()->id;
        $post->save();

        // 重定向到貼文列表，並顯示成功消息
        return redirect('/swiftfox/forum')->with('success', '貼文已創建成功！');
    }


    // 顯示特定貼文詳情
    public function show($id)
    {
        // 查找特定貼文，同時預先載入關聯資料（使用 with 方法）
        $post = Post::with('comments')->findOrFail($id);

        // 獲取使用者訊息
        $user = Auth::user();

        // 取出相關評論
        $comments = $post->comments()->paginate(8);
        
        // 返回貼文詳情，包括相關評論
        return view('swiftfox.forum.show', ['post' => $post, 'user' => $user, 'comments' => $comments]);
    }

    // 刪除貼文
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        // 重定向到貼文列表，並顯示成功消息
        return redirect('/swiftfox/forum')->with('success', '貼文已成功刪除！');
    }
}
