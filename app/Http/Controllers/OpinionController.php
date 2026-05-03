<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOpinionRequest;
use App\Models\Opinion;
use App\Notifications\ResourceNotification;
use App\Services\OpinionService;
use Illuminate\Support\Facades\Auth;

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

        try {
            $opinion = $this->opinionService->vote($opinion, 'agree');

            return response()->json([
                'totalVotes' => $opinion->count,
                'agreeVotes' => $opinion->agree,
                'disagreeVotes' => $opinion->disagree,
                'agreeRatio' => $this->calculatePercentage($opinion->agree, $opinion->count),
                'disagreeRatio' => $this->calculatePercentage($opinion->disagree, $opinion->count),
            ]);
        } catch (\DomainException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 409);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function disagree($id)
    {
        $opinion = $this->opinionService->getOpinionById($id);

        try {
            $opinion = $this->opinionService->vote($opinion, 'disagree');

            return response()->json([
                'totalVotes' => $opinion->count,
                'agreeVotes' => $opinion->agree,
                'disagreeVotes' => $opinion->disagree,
                'agreeRatio' => $this->calculatePercentage($opinion->agree, $opinion->count),
                'disagreeRatio' => $this->calculatePercentage($opinion->disagree, $opinion->count),
            ]);
        } catch (\DomainException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 409);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    private function calculatePercentage($votes, $totalVotes)
    {
        return $totalVotes > 0 ? ($votes / $totalVotes) * 100 : 0;
    }

    public function index()
    {
        $opinions = $this->opinionService->getOpinions();

        return view('swiftfox.opinion.index', compact('opinions'));
    }

    public function create()
    {
        return view('swiftfox.opinion.create');
    }

    public function store(StoreOpinionRequest $request)
    {
        $validatedData = $request->validated();

        $this->opinionService->createOpinion($validatedData);

        Auth::user()->increment('points', 10);

        return redirect()
            ->route('opinion.index')
            ->with('success', '投票已創建成功！');
    }

    public function show($id)
    {
        $opinion = $this->opinionService->getOpinionById($id);

        $agreeRatio = $opinion->count > 0 ? ($opinion->agree / $opinion->count) * 100 : 0;
        $disagreeRatio = $opinion->count > 0 ? ($opinion->disagree / $opinion->count) * 100 : 0;

        return view('swiftfox.opinion.show', compact('opinion', 'agreeRatio', 'disagreeRatio'));
    }

    public function destroy(Opinion $opinion)
    {
        $this->authorize('delete', $opinion);

        $user = $opinion->user;

        $currentUser = Auth::user();

        if ($currentUser->administration == 5) {
            $user->notify(new ResourceNotification(
                resourceType: 'opinion',
                resourceId: $opinion->id,
                title: '議題已刪除',
                reason: '違反社群規範'
            ));
        }

        $this->opinionService->deleteOpinion($opinion);

        return redirect()->route('opinion.index')->with('success', '投票已成功刪除！');
    }
}
