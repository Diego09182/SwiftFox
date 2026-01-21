<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{
    protected ActivityService $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    public function index()
    {
        $activities = $this->activityService->getActivities();

        return view('swiftfox.activity.index', compact('activities'));
    }

    public function store(StoreActivityRequest $request)
    {
        $this->activityService->createActivity(
            $request->validated(),
            $request
        );

        return response()->json([
            'success' => true,
            'message' => '活動創建成功',
        ]);
    }

    public function destroy(Activity $activity)
    {
        if (Gate::denies('delete-activity', $activity)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->activityService->deleteActivity($activity);

        return redirect()->route('activity.index')
            ->with('success', '活動已成功刪除！');
    }
}
