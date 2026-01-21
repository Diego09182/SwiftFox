<?php

namespace App\Services;

use App\Models\Prize;
use App\Models\PrizeRedemption;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PrizeRedemptionService
{
    protected string $cacheTag = 'prize_redemptions';

    public function redeem(User $user, Prize $prize, array $data): array
    {
        $quantity = (int) ($data['quantity'] ?? 1);
        $totalPoints = $prize->price * $quantity;

        if ($quantity > $prize->quantity) {
            return $this->fail('獎品庫存不足。');
        }
        if ($user->points < $totalPoints) {
            return $this->fail('您的點數不足，無法兌換此獎品。');
        }

        DB::transaction(function () use ($user, $prize, $quantity, $totalPoints, $data) {
            $user->decrement('points', $totalPoints);
            $prize->decrement('quantity', $quantity);

            PrizeRedemption::create([
                'user_id' => $user->id,
                'prize_id' => $prize->id,
                'quantity' => $quantity,
                'status' => 'pending',
                'shipping_address' => $data['shipping_address'] ?? '',
                'note' => $data['note'] ?? null,
            ]);
        });

        return $this->success(null, '兌換成功，我們將儘速處理您的訂單！');
    }

    public function updateStatus(PrizeRedemption $redemption, string $status): array
    {
        if ($redemption->status === $status) {
            return $this->fail('狀態未變更');
        }

        $redemption->update(['status' => $status]);

        return $this->success(null, "兌換狀態已更新為「{$status}」。");
    }

    public function updateRedemptionInfo(PrizeRedemption $redemption, array $data): void
    {
        $redemption->update([
            'status' => $data['status'],
            'note' => $data['note'] ?? null,
            'shipping_address' => $data['shipping_address'] ?? '',
        ]);
    }

    public function deleteRedemption(PrizeRedemption $redemption): void
    {
        $redemption->delete();
    }

    public function approveRedemption(PrizeRedemption $redemption): array
    {
        if ($redemption->status !== 'pending') {
            return $this->fail('只能審核待處理的兌換紀錄。');
        }

        $redemption->update(['status' => 'approved']);

        return $this->success(null, '兌換已通過審核。');
    }

    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    protected function clearCache(): void
    {
        Cache::tags([$this->cacheTag])->flush();
    }

    protected function success($data = null, ?string $message = null): array
    {
        return ['success' => true, 'message' => $message, 'data' => $data];
    }

    protected function fail(string $message): array
    {
        return ['success' => false, 'message' => $message, 'data' => null];
    }
}
