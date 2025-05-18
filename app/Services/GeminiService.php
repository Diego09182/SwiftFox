<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $endpoint;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
    }

    public function generateSummary(string $content): ?string
    {
        $prompt = "請為以下貼文產生不超過50字的摘要（繁體中文）：\n\n" . $content;

        $response = $this->sendRequest($prompt);

        if ($response) {
            return $response['text'] ?? '[回應格式錯誤]';
        }

        return null;
    }

    public function checkViolation(string $content): array
    {
        $prompt = "
            請依據以下社群規範判斷貼文是否違規，請嚴格只回傳 JSON 格式，且不要附加其他文字或說明(理由不能超過20字)：
            {
                \"violated\": true|false,
                \"reasons\": [\"違規原因1\", \"違規原因2\"]
            }

            社群規則：
            1. 禁止侵犯他人著作權
            2. 禁止任何違法行為（詐騙、販毒、恐嚇、言語暴力、毀謗等）
            3. 禁止仇恨、歧視、騷擾、暴力威脅
            4. 禁止垃圾訊息或惡意連結
            5. 禁止廣告產品或服務宣傳
            6. 禁止散佈不實訊息
            7. 禁止冒充他人或散佈個資
            8. 禁止濫用平台功能（如機器人、自動貼文）

            貼文內容：
            $content
        ";

        $response = $this->sendRequest($prompt);

        if ($response) {
            $raw = trim($response['text'] ?? '');

            $raw = preg_replace('/^```json\s*/', '', $raw);
            $raw = preg_replace('/\s*```$/', '', $raw);

            $result = json_decode($raw, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($result)) {
                return $result;
            }

        }

        return [
            'violated' => false,
            'reasons' => ['[API呼叫或格式錯誤]'],
        ];
    }

    protected function sendRequest(string $prompt): ?array
    {
        $response = Http::post("{$this->endpoint}?key={$this->apiKey}", [
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
            return $json['candidates'][0]['content']['parts'][0] ?? null;
        }

        return null;
    }
}
