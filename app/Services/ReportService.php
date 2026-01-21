<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ReportService
{
    protected string $cacheTag = 'reports';

    public function createReport(array $data, int $postId)
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = Auth::id();
        $data['post_id'] = $postId;

        $report = Report::create($data);

        return $this->success($report->fresh());
    }

    public function deleteReport(Report $report)
    {
        $user = Auth::user();
        if ($report->user_id !== $user->id && $user->administration != 5) {
            return $this->fail('您沒有權限刪除此資源');
        }

        $report->delete();

        return $this->success();
    }

    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    protected function clearCache(): void
    {
        Cache::tags([$this->cacheTag])->flush();
    }

    protected function success($data = null, ?string $message = null): array
    {
        return ['success' => true, 'message' => $message, 'data' => $data];
    }

    protected function fail(string $message): array
    {
        return ['success' => false, 'message' => $message, 'data' => null];
    }
}
