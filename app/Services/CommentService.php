<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class CommentService
{
    public function storeComment(Post $post, array $data): Comment
    {
        $comment = new Comment([
            'title' => $data['title'],
            'content' => nl2br($data['content']),
        ]);
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->save();

        return $comment;
    }

    public function deleteComment(int $postId, int $commentId): void
    {
        $comment = Comment::where('post_id', $postId)->findOrFail($commentId);

        if (Gate::denies('delete-comment', $comment)) {
            throw ValidationException::withMessages([
                'authorization' => '您沒有權限刪除此資源',
            ]);
        }

        $comment->delete();
    }
}
