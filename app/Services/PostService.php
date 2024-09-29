<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function checkPostLimit()
    {
        $postCount = Post::count();
        $maxPostCount = 500;

        if ($postCount >= $maxPostCount) {
            throw new \Exception('貼文數量已達到系統限制');
        }
    }
}
