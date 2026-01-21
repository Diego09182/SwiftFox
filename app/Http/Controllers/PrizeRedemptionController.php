<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedeemPrizeRequest;
use App\Http\Requests\UpdatePrizeRedemptionRequest;
use App\Http\Requests\UpdatePrizeRedemptionStatusRequest;
use App\Models\Prize;
use App\Models\PrizeRedemption;
use App\Services\PrizeRedemptionService;
use Illuminate\Support\Facades\Auth;

class PrizeRedemptionController extends Controller
{
    protected PrizeRedemptionService $service;

    public function __construct(PrizeRedemptionService $service)
    {
        $this->service = $service;
    }

    public function redeem(RedeemPrizeRequest $request, Prize $prize)
    {
        $user = Auth::user();
        $result = $this->service->redeem($user, $prize, $request->validated());

        if ($result !== true) {
            return back()->withInput()->with('error', $result);
        }

        return redirect()->route('prize.index')->with('success', '兌換成功，我們將儘速處理您的訂單！');
    }

    public function approve(PrizeRedemption $redemption)
    {
        $result = $this->service->approveRedemption($redemption);
        if ($result !== true) {
            return back()->with('error', $result);
        }

        return back()->with('success', '兌換已通過審核。');
    }

    public function updateStatus(UpdatePrizeRedemptionStatusRequest $request, PrizeRedemption $redemption)
    {
        $status = $request->input('status');
        $result = $this->service->updateStatus($redemption, $status);

        if ($result === 'no-change') {
            return back()->with('info', "兌換狀態未變更，維持為「{$status}」。");
        }

        return back()->with('success', "兌換狀態已更新為「{$status}」。");
    }

    public function update(UpdatePrizeRedemptionRequest $request, PrizeRedemption $redemption)
    {
        $this->service->updateRedemptionInfo($redemption, $request->validated());

        return redirect()->route('redemptions.index')->with('success', '兌換資料已更新。');
    }

    public function destroy(PrizeRedemption $redemption)
    {
        $this->service->deleteRedemption($redemption);

        return back()->with('success', '兌換紀錄已刪除。');
    }
}
