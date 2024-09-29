<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    // 儲存新評論
    public function store(Request $request, Post $post)
    {   
        // 驗證並儲存新評論
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:2|max:40',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過20個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過40個字',
        ]);

        $comment = new Comment($validatedData);
        $comment->content = nl2br($validatedData['content']);
        $comment->post_id = $post->id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        // 重定向回文章詳情頁面，並顯示成功消息
        return redirect()->route('forum.show', ['post' => $post->id])->with('success', '評論成功');
    }

    // 刪除評論
    public function destroy($post, $comment)
    {
        // 找到對應的評論
        $comment = Comment::where('post_id', $post)->findOrFail($comment);

        if ($comment->user_id != Auth::id() && Auth::user()->administration != 5) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }
        
        // 刪除評論
        $comment->delete();

        // 重定向到貼文詳情頁面，並顯示成功消息
        return redirect()->route('forum.show', ['post' => $post])->with('success', '評論已刪除');
    }

}
