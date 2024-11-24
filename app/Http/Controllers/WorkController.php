<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Services\WorkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
    protected $workService;

    public function __construct(WorkService $workService)
    {
        $this->workService = $workService;
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->input('page', 1);

        $works = Cache::tags(['works'])->remember("works_index_page_{$page}", 600, function () {
            return Work::orderBy('id', 'desc')->paginate(6);
        });

        return view('swiftfox.work.index', ['works' => $works, 'user' => $user]);
    }

    public function store(Request $request)
    {
        try {
            $this->workService->checkWorkLimit();
        } catch (\Exception $e) {
            return redirect()->route('work.index')->with('error', $e->getMessage());
        }

        $validatedData = $request->validate([
            'name' => 'required|min:2|max:10',
        ], [
            'name.required' => '作品名稱為必填項目',
            'name.min' => '作品名稱至少需要2個字',
            'name.max' => '作品名稱不能超過10個字',
        ]);

        $work = new Work($validatedData);
        $work->user_id = auth()->user()->id;
        $work->save();

        $this->clearCache();

        return redirect()->route('work.index')->with('success', '作品已創建成功！');
    }

    public function create()
    {
        return view('swiftfox.work.create');
    }

    public function show($id)
    {
        $user = Auth::user();

        $work = Cache::tags(['works'])->remember("work_show_{$id}", 600, function () use ($id) {
            return Work::with('photos')->findOrFail($id);
        });

        $photos = $work->photos;

        foreach ($photos as $photo) {
            $photo->url = Storage::url('public/photos/'.$photo->filename);
        }

        return view('swiftfox.work.show', ['work' => $work, 'user' => $user, 'photos' => $photos]);
    }

    public function destroy($id)
    {
        $work = Work::findOrFail($id);

        if (Gate::denies('delete-work', $work)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $work->delete();

        $this->clearCache($id);

        return redirect()->route('work.index')->with('success', '作品集已成功刪除！');
    }

    private function clearCache($workId = null)
    {
        Cache::tags(['works'])->flush();

        if ($workId) {
            Cache::tags(['works'])->forget("work_show_{$workId}");
        }
    }
}
