<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Models\Post;
use App\Models\Report;
use App\Services\ReportService;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function store(StoreReportRequest $request, Post $post)
    {
        $data = $request->validated();

        $this->reportService->createReport($data, $post->id);

        return redirect()
            ->back()
            ->with('success', '檢舉已創建成功！');
    }

    public function destroy(Report $report)
    {
        $this->reportService->deleteReport($report);

        return redirect()
            ->route('management.index')
            ->with('success', '檢舉已成功刪除！');
    }
}
