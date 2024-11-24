<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Services\OpinionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class OpinionController extends Controller
{
    protected $opinionService;

    public function __construct(OpinionService $opinionService)
    {
        $this->opinionService = $opinionService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $cacheKey = 'opinions_index_page_'.$page;

        $opinions = Cache::tags(['opinions'])->remember($cacheKey, 600, function () {
            return Opinion::orderBy('id', 'desc')->paginate(3);
        });

        $user = Auth::user();

        return view('swiftfox.opinion.index', compact('opinions', 'user'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:2|max:50',
            'finished_time' => 'required|after:now',
        ], [
            'title.required' => '標題為必填項目',
            'content.required' => '內容為必填項目',
            'finished_time.required' => '投票結束時間為必填項目',
            'finished_time.after' => '投票結束時間必須大於當前時間',
        ]);

        $opinion = new Opinion($validatedData);
        $opinion->content = nl2br($validatedData['content']);
        $opinion->user_id = auth()->user()->id;
        $opinion->save();

        $this->clearCache();

        return redirect()->route('opinion.index')->with('success', '投票已創建成功！');
    }

    public function destroy($id)
    {
        $opinion = Opinion::findOrFail($id);
        $user = Auth::user();

        if (Gate::denies('delete-opinion', $opinion)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $opinion->delete();

        $this->clearCache($opinion);

        return redirect()->route('opinion.index')->with('success', '投票已成功刪除！');
    }

    private function clearCache($opinion = null)
    {
        Cache::tags(['opinions'])->flush();

        if ($opinion) {
            Cache::forget('opinion_'.$opinion->id);
        }
    }
}
