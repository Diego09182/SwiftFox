<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:2|max:50',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過20個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',
        ]);

        $comment = new Comment($validatedData);
        $comment->content = nl2br($validatedData['content']);
        $comment->post_id = $post->id;
        $comment->user_id = auth()->user()->id;
        $comment->save();

        return redirect()->route('forum.show', compact('post'))->with('success', '評論成功');
    }

    public function destroy($post, $comment)
    {
        $comment = Comment::where('post_id', $post)->findOrFail($comment);

        if (Gate::denies('delete-comment', $comment)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $comment->delete();

        return redirect()->route('forum.show', compact('post'))->with('success', '評論已刪除');
    }
}
