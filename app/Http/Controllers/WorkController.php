<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Services\WorkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $works = $this->workService->getWorksByPage($page);

        return view('swiftfox.work.index', compact('works', 'user'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:10',
        ], [
            'name.required' => '作品名稱為必填項目',
            'name.min' => '作品名稱至少需要2個字',
            'name.max' => '作品名稱不能超過20個字',
        ]);

        $this->workService->createWork($validatedData);

        $user = Auth::user();

        $user->increment('points', 10);

        return redirect()->route('work.index')->with('success', '作品已創建成功！');
    }

    public function create()
    {
        return view('swiftfox.work.create');
    }

    public function show($id)
    {
        $user = Auth::user();

        $work = $this->workService->getWorkById($id);

        $photos = $work->photos;

        foreach ($photos as $photo) {
            $photo->url = Storage::url('public/photos/'.$photo->filename);
        }

        return view('swiftfox.work.show', compact('work', 'user', 'photos'));
    }

    public function destroy($id)
    {
        $work = Work::findOrFail($id);

        if (Gate::denies('delete-work', $work)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->workService->deleteWork($id);

        return redirect()->route('work.index')->with('success', '作品集已成功刪除！');
    }
}
