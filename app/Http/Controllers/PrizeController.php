<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrizeRequest;
use App\Http\Requests\UpdatePrizeRequest;
use App\Models\Prize;
use App\Services\PrizeService;

class PrizeController extends Controller
{
    protected PrizeService $prizeService;

    public function __construct(PrizeService $prizeService)
    {
        $this->prizeService = $prizeService;
    }

    public function index()
    {
        $prizes = Prize::orderBy('created_at', 'desc')->paginate(8);

        return view('swiftfox.prize.index', compact('prizes'));
    }

    public function store(StorePrizeRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image');

        $this->prizeService->createPrize($data);

        return redirect()
            ->route('prize.index')
            ->with('success', '獎品新增成功！');
    }

    public function update(UpdatePrizeRequest $request, Prize $prize)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image');

        $this->prizeService->updatePrize($prize, $data);

        return redirect()
            ->route('prize.index')
            ->with('success', '獎品更新成功！');
    }

    public function destroy(Prize $prize)
    {
        $this->prizeService->deletePrize($prize);

        return redirect()
            ->route('prize.index')
            ->with('success', '獎品已刪除。');
    }
}
