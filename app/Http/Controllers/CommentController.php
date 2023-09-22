<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {   
        // 驗證並儲存新評論
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:10',
            'content' => 'required|min:2|max:30',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過10個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過30個字',
        ]);

        $comment = new Comment($validatedData);
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $post->id; 

        $comment->save();

        // 重定向回文章詳情頁面，並顯示成功消息
        return redirect()->route('forum.show', ['post' => $post->id])->with('success', '評論成功');
    }

    // 刪除文章
    public function destroy($post, $comment)
    {
        // 找到對應的評論
        $comment = Comment::where('post_id', $post)->findOrFail($comment);
        
        // 刪除評論
        $comment->delete();

        // 重定向到貼文詳情頁面，並顯示成功消息
        return redirect()->route('forum.show', ['post' => $post])->with('success', '評論已刪除');
    }

}
