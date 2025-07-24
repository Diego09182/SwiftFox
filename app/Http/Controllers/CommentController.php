<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
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

        $this->commentService->storeComment($post, $validated);

        $user = Auth::user();

        $user->increment('points', 10);

        return redirect()->route('forum.show', compact('post'))->with('success', '評論成功');
    }

    public function destroy($postId, $commentId)
    {
        return redirect()->route('forum.show', ['post' => $postId])->with('success', '評論已刪除');
    }
}
