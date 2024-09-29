<?php

namespace App\Services;

use App\Models\Article;

class ArticleService
{
    public function checkArticleLimit()
    {
        $articleCount = Article::count();
        $maxArticleCount = 500;

        if ($articleCount >= $maxArticleCount) {
            throw new \Exception('文章數量已達到系統限制');
        }
    }
}
