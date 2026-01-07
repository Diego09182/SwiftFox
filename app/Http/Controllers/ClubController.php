<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Services\ClubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClubController extends Controller
{
    public function __construct(
        protected ClubService $clubService
    ) {}

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $clubs = $this->clubService->getClubsByPage($page);

        return view('swiftfox.club.index', compact('clubs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'         => 'required|min:2|max:10',
            'tag'           => 'required',
            'content'       => 'required|min:2|max:50',
            'teacher'       => 'nullable',
            'director'      => 'required',
            'vice_director' => 'nullable',
            'file'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'title.required'     => '標題為必填項目',
            'title.min'          => '標題至少需要2個字',
            'title.max'          => '標題不能超過10個字',
            'content.required'   => '內容為必填項目',
            'content.min'        => '內容至少需要2個字',
            'content.max'        => '內容不能超過50個字',
            'tag.required'       => '標籤為必填項目',
            'director.required'  => '社長為必填項目',
            'file.image'         => '檔案必須是圖片格式',
            'file.mimes'         => '只接受 jpeg, png, jpg, 格式圖片',
            'file.max'           => '圖片大小不能超過2MB',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validatedData['filename'] = $file->getClientOriginalName();
            $validatedData['path'] = $file->store('club', 'public');
        }

        $club = $this->clubService->createClub($validatedData);

        return response()->json([
            'success' => true,
            'message' => '社團創建成功',
            'data'    => $club,
        ]);
    }

    public function destroy(Club $club)
    {
        if (Gate::denies('delete-club', $club)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->clubService->deleteClub($club);

        return redirect()
            ->route('club.index')
            ->with('success', '社團已成功刪除！');
    }
}
