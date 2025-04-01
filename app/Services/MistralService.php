<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MistralService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = '4Sl5IScpBGRoBSVyjhY0vRQAfwmuHGJO';
        $this->baseUrl = 'https://api.mistral.ai/v1';
    }

    /**
     * 使用 Mistral AI 進行聊天請求
     *
     * @param string $message 文章內容或要分析的文本
     * @param string $model 使用的模型名稱（預設為'mistral-small-latest'）
     * @return string|null 返回 AI 生成的回應，若失敗則返回 null
     */
    public function chat(string $message, string $model = 'mistral-small-latest'): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/chat/completions", [
                'model' => $model,
                'messages' => [['role' => 'user', 'content' => $message]],
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? null;
            } else {
                Log::error('Mistral API Error: ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
                Log::error('Mistral API Request failed: ' . $e->getMessage());
                return null;
        }
    }
}
