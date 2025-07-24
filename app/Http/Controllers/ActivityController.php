<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $activities = $this->activityService->getActivitiesByPage($page);

        return view('swiftfox.activity.index', compact('activities'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:2|max:50',
            'location' => 'required',
            'date' => 'required',
            'url' => 'nullable|url',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過20個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',
            'date.required' => '日期為必填項目',
            'location.required' => '地點為必填項目',
        ]);

        $this->activityService->createActivity($validatedData);

        return response()->json(['success' => true, 'message' => '活動創建成功']);
    }

    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);

        if (Gate::denies('delete-activity', $activity)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->activityService->deleteActivity($activity);

        return redirect()->route('activity.index')->with('success', '活動已成功刪除！');
    }
}
