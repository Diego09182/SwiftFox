<?php

namespace App\Http\Controllers;

use App\Http\Requests\RedeemPrizeRequest;
use App\Http\Requests\UpdatePrizeRedemptionRequest;
use App\Http\Requests\UpdatePrizeRedemptionStatusRequest;
use App\Models\Prize;
use App\Models\PrizeRedemption;
use App\Services\PrizeRedemptionService;
use App\Services\RedeemResult;
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
        $quantity = $request->input('quantity', 1);
        $data = $request->validated();

        /** @var RedeemResult $result */
        $result = $this->service->redeem($user, $prize, $quantity, $data);

        if (! $result->success) {
            $message = match ($result->reason) {
                'INSUFFICIENT_STOCK' => '獎品庫存不足。',
                'INSUFFICIENT_POINTS' => '點數不足，無法兌換此獎品。',
                default => '兌換失敗，請稍後再試。',
            };

            return back()->withInput()->with('error', $message);
        }

        return redirect()->route('prize.index')
            ->with('success', '兌換成功，我們將儘速處理您的訂單！');
    }

    public function approve(PrizeRedemption $redemption)
    {
        $this->authorize('approve', $redemption);

        $success = $this->service->approveRedemption($redemption);

        if (! $success) {
            return back()->with('error', '只能審核待處理的兌換紀錄。');
        }

        return back()->with('success', '兌換已通過審核。');
    }

    public function updateStatus(UpdatePrizeRedemptionStatusRequest $request, PrizeRedemption $redemption)
    {
        $this->authorize('update', $redemption);

        $status = $request->input('status');
        $success = $this->service->updateStatus($redemption, $status);

        if (! $success) {
            return back()->with('info', '狀態未變更。');
        }

        return back()->with('success', "兌換狀態已更新為「{$status}」。");
    }

    public function update(UpdatePrizeRedemptionRequest $request, PrizeRedemption $redemption)
    {
        $this->authorize('update', $redemption);

        $this->service->updateRedemptionInfo($redemption, $request->validated());

        return redirect()->route('redemptions.index')
            ->with('success', '兌換資料已更新。');
    }

    public function destroy(PrizeRedemption $redemption)
    {
        $this->authorize('delete', $redemption);

        $this->service->deleteRedemption($redemption);

        return back()->with('success', '兌換紀錄已刪除。');
    }
}
