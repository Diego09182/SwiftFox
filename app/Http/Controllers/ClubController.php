<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClubRequest;
use App\Models\Club;
use App\Services\ClubService;

class ClubController extends Controller
{
    public function __construct(
        protected ClubService $clubService
    ) {}

    public function index()
    {
        $clubs = $this->clubService->getClubs();

        return view('swiftfox.club.index', compact('clubs'));
    }

    public function store(StoreClubRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $validatedData['filename'] = $file->getClientOriginalName();
            $validatedData['path'] = $file->store('club', 'public');
        }

        $club = $this->clubService->createClub($validatedData);

        return response()->json([
            'success' => true,
            'message' => '社團創建成功',
            'data' => $club,
        ]);
    }

    public function destroy(Club $club)
    {
        $this->authorize('delete', $club);

        $this->clubService->deleteClub($club);

        return redirect()
            ->route('club.index')
            ->with('success', '社團已成功刪除！');
    }
}
