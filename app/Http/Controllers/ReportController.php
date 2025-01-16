<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function store(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:10',
            'content' => 'required|min:2|max:50',
            'tag' => 'required|in:違法行為,仇恨內容,垃圾內容,未授權的產品及服務',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過10個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',
            'tag.required' => '標籤為必填項目',
            'tag.in' => '標籤必須符合選項',
        ]);

        $this->reportService->createReport($validatedData, $post->id);

        return redirect()->back()->with('success', '檢舉已創建成功！');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        try {
            $this->reportService->deleteReport($report);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('management.index')->with('success', '檢舉已成功刪除！');
    }
}
