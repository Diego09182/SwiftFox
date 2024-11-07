<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class ClubController extends Controller
{
    // 顯示所有社團列表
    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $cacheKey = 'club_index_page_' . $page;

        $clubs = Cache::tags(['clubs'])->remember($cacheKey, 600, function () {
            return Club::orderBy('id', 'desc')->paginate(9);
        });

        $user = Auth::user();

        return view('swiftfox.club.index', compact('clubs', 'user'));
    }

    public function store(Request $request)
    {
        // 驗證並儲存新社團
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:10',
            'tag' => 'required',
            'content' => 'required|min:2|max:50',
            'teacher' => 'nullable',
            'director' => 'required',
            'vice_director' => 'nullable',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過10個字',
            'content.required' => '內容為必填項目',
            'tag.required' => '標籤為必填項目',
            'director.required' => '社長為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',
        ]);

        // 儲存社團
        $club = new Club($validatedData);
        $club->content = nl2br($validatedData['content']);
        $club->save();

        // 清除相關快取
        $this->clearCache();

        // 返回 JSON 格式的成功消息
        return response()->json([
            'success' => true,
            'message' => '社團創建成功',
        ]);
    }

    // 刪除社團
    public function destroy($id)
    {
        $club = Club::findOrFail($id);

        $user = Auth::user();

        if (Gate::denies('delete-club', $club)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $club->delete();

        $this->clearCache();

        return redirect()->route('club.index')->with('success', '社團已成功刪除！');
    }

    // 清除所有相關的快取
    private function clearCache()
    {
        Cache::tags(['clubs'])->flush();
    }
}
