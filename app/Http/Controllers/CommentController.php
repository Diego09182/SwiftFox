<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    public function store(StoreCommentRequest $request, Post $post)
    {
        $this->commentService->storeComment($post, $request->validated());

        Auth::user()->increment('points', 3);

        return redirect()
            ->route('forum.show', ['post' => $post->id])
            ->with('success', '評論成功');
    }

    public function destroy(Post $post, Comment $comment)
    {
        $result = $this->commentService->deleteComment($comment);

        if (! $result['success']) {
            return redirect()
                ->route('forum.show', ['post' => $post->id])
                ->with('error', $result['message']);
        }

        return redirect()
            ->route('forum.show', ['post' => $post->id])
            ->with('success', '評論已刪除');
    }
}
