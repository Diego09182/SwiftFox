<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Activity;

class ActivityController extends Controller
{
    // 顯示所有活動列表
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $cacheKey = 'activities_page_' . $page;

        $activities = Cache::tags(['activities'])->remember($cacheKey, 600, function() {
            return Activity::orderBy('id', 'desc')->paginate(6);
        });
        
        $user = Auth::user();

        return view('swiftfox.activity.index', ['activities' => $activities, 'user' => $user]);
    }

    // 儲存新活動
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
            'date.required' => '日期為必填項目',
            'location.required' => '地點為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',
        ]);

        $validatedData['content'] = nl2br($validatedData['content']);
        
        $activity = Activity::create($validatedData);

        // 儲存活動後清除相關快取
        $this->clearCache();

        return response()->json(['success' => true, 'message' => '活動創建成功']);
    }

    // 刪除活動
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        
        $user = Auth::user();

        if ($activity->user_id != $user->id && $user->administration != 5) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $activity->delete();

        // 刪除活動後清除相關快取
        $this->clearCache();

        return redirect()->route('activity.index')->with('success', '活動已成功刪除！');
    }

    // 清除活動相關的快取
    private function clearCache()
    {
        Cache::tags(['activities'])->flush();
    }
}