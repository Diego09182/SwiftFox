<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'   => 'required|min:2|max:20',
            'content' => 'required|min:2|max:50',
        ], [
            'title.required'   => '標題為必填項目',
            'title.min'        => '標題至少需要2個字',
            'title.max'        => '標題不能超過20個字',
            'content.required' => '內容為必填項目',
            'content.min'      => '內容至少需要2個字',
            'content.max'      => '內容不能超過50個字',
        ]);

        $comment = $this->commentService->storeComment($post, $validated);

        Auth::user()->increment('points', 3);

        return redirect()
                ->route('forum.show', ['post' => $post->id])
                ->with('success', '評論成功');
    }

    public function destroy(Post $post, Comment $comment)
    {
        $result = $this->commentService->deleteComment($comment);

        if (!$result['success']) {
            return redirect()
                ->route('forum.show', ['post' => $post->id])
                ->with('error', $result['message']);
        }

        return redirect()
                ->route('forum.show', ['post' => $post->id])
                ->with('success', '評論已刪除');
    }
}
