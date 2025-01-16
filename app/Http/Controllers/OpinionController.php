<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use App\Services\OpinionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OpinionController extends Controller
{
    protected $opinionService;

    public function __construct(OpinionService $opinionService)
    {
        $this->opinionService = $opinionService;
    }

    public function agree($id)
    {
        $opinion = $this->opinionService->getOpinionById($id);
        $userId = Auth::id();

        try {
            $opinion = $this->opinionService->vote($userId, $opinion, 'agree');

            return response()->json([
                'totalVotes' => $opinion->count,
                'agreeVotes' => $opinion->agree,
                'disagreeVotes' => $opinion->disagree,
                'agreeRatio' => $this->calculatePercentage($opinion->agree, $opinion->count),
                'disagreeRatio' => $this->calculatePercentage($opinion->disagree, $opinion->count),
            ]);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function disagree($id)
    {
        $opinion = $this->opinionService->getOpinionById($id);
        $userId = Auth::id();

        try {
            $opinion = $this->opinionService->vote($userId, $opinion, 'disagree');

            return response()->json([
                'totalVotes' => $opinion->count,
                'agreeVotes' => $opinion->agree,
                'disagreeVotes' => $opinion->disagree,
                'agreeRatio' => $this->calculatePercentage($opinion->agree, $opinion->count),
                'disagreeRatio' => $this->calculatePercentage($opinion->disagree, $opinion->count),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function calculatePercentage($votes, $totalVotes)
    {
        return $totalVotes > 0 ? ($votes / $totalVotes) * 100 : 0;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $opinions = $this->opinionService->getOpinionsByPage($page);

        $user = Auth::user();

        return view('swiftfox.opinion.index', compact('opinions', 'user'));
    }

    public function create()
    {
        return view('swiftfox.opinion.create');
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

        $this->opinionService->createOpinion($validatedData);

        return redirect()->route('opinion.index')->with('success', '投票已創建成功！');
    }

    public function show($id)
    {
        $opinion = $this->opinionService->getOpinionById($id);

        $agreeRatio = $opinion->count > 0 ? ($opinion->agree / $opinion->count) * 100 : 0;
        $disagreeRatio = $opinion->count > 0 ? ($opinion->disagree / $opinion->count) * 100 : 0;

        return view('swiftfox.opinion.show', compact('opinion', 'agreeRatio', 'disagreeRatio'));
    }

    public function destroy($id)
    {
        $opinion = Opinion::findOrFail($id);

        if (Gate::denies('delete-opinion', $opinion)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->opinionService->deleteOpinion($opinion);

        return redirect()->route('opinion.index')->with('success', '投票已成功刪除！');
    }
}
