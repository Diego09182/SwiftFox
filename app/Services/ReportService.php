<?php

namespace App\Services;

use App\Models\Report;

class ReportService
{
    public function checkReportLimit()
    {
        $reportCount = Report::count();
        $maxReportCount = 500;

        if ($reportCount >= $maxReportCount) {
            throw new \Exception('檢舉數量已達到系統限制');
        }
    }
}
