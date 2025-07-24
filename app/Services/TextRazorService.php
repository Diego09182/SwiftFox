<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TextRazorService
{
    protected $apiKey;

    protected $endpoint = 'https://api.textrazor.com';

    public function __construct()
    {
        $this->apiKey = env('TEXTRAZOR_API_KEY');
    }

    public function analyzeText(string $text, array $extractors = ['entities', 'topics'])
    {
        $response = Http::withHeaders([
            'x-textrazor-key' => $this->apiKey,
        ])->asForm()->post($this->endpoint, [
            'text' => $text,
            'extractors' => implode(',', $extractors),
        ]);

        return $response->successful() ? $response->json() : null;
    }
}
