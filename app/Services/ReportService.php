<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportService
{
    public function createReport(array $data, $postId)
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = Auth::id();
        $data['post_id'] = $postId;

        return Report::create($data);
    }

    public function deleteReport(Report $report)
    {
        if ($report->user_id != Auth::id() && Auth::user()->administration != 5) {
            throw new \Exception('您沒有權限刪除此資源');
        }

        $report->delete();
    }
}
