<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Work;
use App\Services\WorkService;

class WorkController extends Controller
{
    protected $workService;

    public function __construct(WorkService $workService)
    {
        $this->workService = $workService;
    }

    // 發布作品集頁面
    public function create()
    {
        return view('swiftfox.work.create');
    }

    // 顯示所有作品集列表
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->input('page', 1);

        // 使用快取來儲存作品集列表
        $works = Cache::tags(['works'])->remember("works_index_page_{$page}", 600, function() {
            return Work::orderBy('id', 'desc')->paginate(6);
        });

        return view('swiftfox.work.index', ['works' => $works, 'user' => $user]);
    }

    // 儲存新作品集
    public function store(Request $request)
    {
        // 檢查作品集數量限制
        try {
            $this->workService->checkWorkLimit();
        } catch (\Exception $e) {
            return redirect()->route('work.index')->with('error', $e->getMessage());
        }

        // 驗證並儲存新作品集
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:10',
        ], [
            'name.required' => '作品名稱為必填項目',
            'name.min' => '作品名稱至少需要2個字',
            'name.max' => '作品名稱不能超過10個字',
        ]);

        // 創建並儲存新作品集
        $work = new Work($validatedData);
        $work->user_id = auth()->user()->id;
        $work->save();

        // 清除作品集列表快取
        $this->clearCache();

        // 重定向到作品集列表，並顯示成功消息
        return redirect()->route('work.index')->with('success', '作品已創建成功！');
    }

    // 顯示特定作品集詳情
    public function show($id)
    {
        $user = Auth::user();

        // 使用快取來儲存特定作品集的詳細信息
        $work = Cache::tags(['works'])->remember("work_show_{$id}", 600, function() use ($id) {
            return Work::with('photos')->findOrFail($id);
        });

        $photos = $work->photos;

        // 使用 Storage facade 獲取圖片的 URL
        foreach ($photos as $photo) {
            $photo->url = Storage::url('public/photos/' . $photo->filename);
        }

        return view('swiftfox.work.show', ['work' => $work, 'user' => $user, 'photos' => $photos]);
    }

    // 刪除作品集
    public function destroy($id)
    {
        $work = Work::findOrFail($id);

        if ($work->user_id != Auth::id() && Auth::user()->administration != 5) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $work->delete();

        // 清除作品集列表和詳細信息快取
        $this->clearCache($id);

        // 重定向到作品集列表，並顯示成功消息
        return redirect()->route('work.index')->with('success', '作品集已成功刪除！');
    }

    // 清除所有快取
    private function clearCache($workId = null)
    {
        // 清除所有作品集相關的快取
        Cache::tags(['works'])->flush();

        // 如果作品集被刪除，僅清除對應作品集的詳細頁面快取
        if ($workId) {
            Cache::tags(['works'])->forget("work_show_{$workId}");
        }
    }
}