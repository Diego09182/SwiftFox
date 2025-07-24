<?php

namespace App\Http\Controllers;

use App\Models\Prize;
use App\Models\PrizeRedemption;
use App\Services\PrizeRedemptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrizeRedemptionController extends Controller
{
    protected PrizeRedemptionService $prizeRedemptionservice;

    public function __construct(PrizeRedemptionService $prizeRedemptionservice)
    {
        $this->prizeRedemptionservice = $prizeRedemptionservice;
    }

    public function redeem(Request $request, Prize $prize)
    {
        $user = Auth::user();

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
            'note' => 'nullable|string|max:500',
        ], [
            'quantity.required' => '請輸入兌換數量。',
            'quantity.integer' => '兌換數量必須是整數。',
            'quantity.min' => '兌換數量至少為 :min。',
            'shipping_address.required' => '請輸入收件地址。',
            'shipping_address.string' => '收件地址格式錯誤。',
            'shipping_address.max' => '收件地址不能超過 :max 個字。',
            'note.string' => '備註內容格式錯誤。',
            'note.max' => '備註內容不能超過 :max 個字。',
        ]);

        $quantity = $request->input('quantity');
        $totalPoints = $prize->price * $quantity;

        if ($prize->quantity < $quantity) {
            return back()->withInput()->with('error', '兌換數量超過可用庫存。');
        }

        if ($prize->price <= 0) {
            return back()->withInput()->with('error', '此獎品的價格無效。');
        }

        if ($totalPoints > $user->points) {
            return back()->withInput()->with('error', '您的積分不足以兌換此獎品。');
        }

        if ($prize->quantity <= 0) {
            return back()->withInput()->with('error', '此獎品已經被兌換完畢。');
        }

        $result = $this->prizeRedemptionservice->redeem($user, $prize, $request);

        if ($result !== true) {
            return back()->withInput()->with('error', $result);
        }

        return redirect()->route('prize.index')->with('success', '兌換成功，我們將儘速處理您的訂單！');
    }

    public function approve($id)
    {
        $redemption = PrizeRedemption::findOrFail($id);

        if ($redemption->status !== 'pending') {
            return back()->with('error', '只能審核待處理的兌換紀錄。');
        }

        $this->prizeRedemptionservice->updateStatus($redemption, 'approved');

        return back()->with('success', '兌換已通過審核。');
    }

    public function updateStatus(Request $request, PrizeRedemption $redemption)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,approved,shipped,canceled',
        ], [
            'status.required' => '請選擇兌換狀態。',
            'status.in' => '狀態必須為待處理、已審核、已出貨或已取消之一。',
        ]);

        $result = $this->prizeRedemptionservice->updateStatus($redemption, $validated['status']);

        $statusText = [
            'pending' => '待處理',
            'approved' => '已審核',
            'shipped' => '已出貨',
            'canceled' => '已取消',
        ][$validated['status']] ?? $validated['status'];

        if ($result === 'no-change') {
            return back()->with('info', "兌換狀態未變更，維持為「{$statusText}」。");
        }

        return back()->with('success', "兌換狀態已更新為「{$statusText}」。");
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:50',
            'note' => 'nullable|string|max:500',
            'shipping_address' => 'required|string|max:255',
        ], [
            'status.required' => '請選擇兌換狀態。',
            'status.max' => '狀態長度不能超過 :max 個字。',
            'note.max' => '備註內容不能超過 :max 個字。',
            'shipping_address.required' => '請輸入收件地址。',
            'shipping_address.max' => '收件地址不能超過 :max 個字。',
        ]);

        $redemption = PrizeRedemption::findOrFail($id);
        $this->prizeRedemptionservice->updateRedemptionInfo($redemption, $validated);

        return redirect()->route('redemptions.index')->with('success', '兌換資料已更新。');
    }

    public function destroy($id)
    {
        $redemption = PrizeRedemption::findOrFail($id);
        $this->prizeRedemptionservice->deleteRedemption($redemption);

        return back()->with('success', '兌換紀錄已刪除。');
    }
}
