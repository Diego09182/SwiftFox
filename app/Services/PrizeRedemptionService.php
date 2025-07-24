<?php

namespace App\Services;

use App\Models\Prize;
use App\Models\PrizeRedemption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PrizeRedemptionService
{
    public function redeem(User $user, Prize $prize, Request $request): bool|string
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
            'note' => 'nullable|string|max:500',
        ], [
            'quantity.required' => '請輸入兌換數量。',
            'quantity.integer' => '兌換數量需為整數。',
            'quantity.min' => '兌換數量至少為 1。',
            'shipping_address.required' => '請輸入收件地址。',
            'shipping_address.max' => '收件地址長度不可超過 255 字。',
            'note.max' => '備註長度不可超過 500 字。',
        ]);

        if ($validator->fails()) {
            return $validator->errors()->first();
        }

        $quantity = (int) $request->input('quantity');
        $shippingAddress = $request->input('shipping_address');
        $note = $request->input('note');
        $totalPoints = $prize->price * $quantity;

        if ($prize->quantity < $quantity) {
            return '獎品庫存不足，請重新確認數量。';
        }

        if ($user->points < $totalPoints) {
            return '您的點數不足，無法兌換此獎品。';
        }

        DB::transaction(function () use ($user, $prize, $quantity, $totalPoints, $shippingAddress, $note) {
            $user->decrement('points', $totalPoints);

            $prize->decrement('quantity', $quantity);

            PrizeRedemption::create([
                'user_id' => $user->id,
                'prize_id' => $prize->id,
                'quantity' => $quantity,
                'status' => 'pending',
                'shipping_address' => $shippingAddress,
                'note' => $note,
            ]);
        });

        return true;
    }

    public function updateStatus(PrizeRedemption $redemption, string $status): string
    {
        if ($redemption->status === $status) {
            return 'no-change';
        }

        $redemption->update(['status' => $status]);

        return 'updated';
    }

    public function updateRedemptionInfo(PrizeRedemption $redemption, array $data): void
    {
        $redemption->update([
            'status' => $data['status'],
            'note' => $data['note'] ?? null,
            'shipping_address' => $data['shipping_address'],
        ]);
    }

    public function deleteRedemption(PrizeRedemption $redemption): void
    {
        $redemption->delete();
    }
}
