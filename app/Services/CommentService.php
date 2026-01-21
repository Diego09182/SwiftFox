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
        $comment = $this->buildComment($post, $data);

        $comment->save();

        return $comment->fresh();
    }

    public function deleteComment(Comment $comment): array
    {
        if (! $this->canDeleteComment($comment)) {
            return $this->deleteFailed();
        }

        $comment->delete();

        return $this->deleteSuccess();
    }

    protected function buildComment(Post $post, array $data): Comment
    {
        return new Comment([
            'title' => $data['title'],
            'content' => nl2br($data['content']),
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);
    }

    protected function canDeleteComment(Comment $comment): bool
    {
        return Gate::allows('delete-comment', $comment);
    }

    protected function deleteSuccess(): array
    {
        return [
            'success' => true,
        ];
    }

    protected function deleteFailed(): array
    {
        return [
            'success' => false,
            'message' => '您沒有權限刪除此評論',
        ];
    }
}
