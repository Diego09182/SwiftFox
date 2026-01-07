<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentService
{
    public function storeComment(Post $post, array $data)
    {
        $comment = new Comment([
            'title'   => $data['title'],
            'content' => nl2br($data['content']),
        ]);

        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();

        $comment->save();

        return $comment->fresh();
    }

    public function deleteComment(Comment $comment): array
    {
        if (!Gate::allows('delete-comment', $comment)) {
            return ['success' => false, 'message' => '您沒有權限刪除此評論'];
        }

        $comment->delete();

        return ['success' => true];
    }
}
