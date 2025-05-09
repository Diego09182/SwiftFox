<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected $apiKey;
    protected $endpoint;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
    }

    public function generateSummary(string $content): ?string
    {
        $prompt = "請為以下貼文產生一段不超過100字的摘要（繁體中文）：\n\n" . $content;

        $response = Http::post($this->endpoint . '?key=' . $this->apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $json = $response->json();

            return $json['candidates'][0]['content']['parts'][0]['text'] ?? '[Gemini 回應格式異常]';
        }

        return null;
    }

}
