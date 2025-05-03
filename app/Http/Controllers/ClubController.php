<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Services\ClubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClubController extends Controller
{
    protected $clubService;

    public function __construct(ClubService $clubService)
    {
        $this->clubService = $clubService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $clubs = $this->clubService->getClubsByPage($page);
        $user = Auth::user();

        return view('swiftfox.club.index', compact('clubs', 'user'));
    }

    public function store(Request $request)
    {
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

        $this->clubService->createClub($validatedData);

        return response()->json(['success' => true,'message' => '社團創建成功',]);
    }

    public function destroy($id)
    {
        $club = Club::findOrFail($id);

        if (Gate::denies('delete-club', $club)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->clubService->deleteClub($club);

        return redirect()->route('club.index')->with('success', '社團已成功刪除！');
    }
}
