<?php

namespace App\Observers;

use App\Models\Post;
use App\Services\TextRazorService;

class PostObserver
{
    protected $textRazorService;

    public function __construct(TextRazorService $textRazorService)
    {
        $this->textRazorService = $textRazorService;
    }

    public function creating(Post $post)
    {
        $this->analyzePost($post);
    }

    private function analyzePost(Post $post)
    {
        $analysis = $this->textRazorService->analyzeText($post->content);

        if ($analysis && isset($analysis['response'])) {
            $keywords = collect($analysis['response']['entities'] ?? [])
                ->pluck('entityId')
                ->unique()
                ->take(5)
                ->implode(',');

            $sentiment = 'neutral';
            if (isset($analysis['response']['sentences'][0]['sentiment'])) {
                $score = $analysis['response']['sentences'][0]['sentiment'];
                $sentiment = $score > 0 ? 'positive' : ($score < 0 ? 'negative' : 'neutral');
            }

            $post->keywords = $keywords;
            $post->sentiment = $sentiment;
        }
    }
}
