<?php

namespace App\Services;

use App\Models\Prize;
use App\Models\PrizeRedemption;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PrizeRedemptionService extends AbstractService
{
    protected string $cacheTag = 'prize_redemptions';

    protected function getModelClass(): string
    {
        return PrizeRedemption::class;
    }

    /**
     * 執行兌換
     */
    public function redeem(User $user, Prize $prize, int $quantity = 1, array $data = []): RedeemResult
    {
        return DB::transaction(function () use ($user, $prize, $quantity, $data) {

            // 正確併發鎖
            $prize = Prize::whereKey($prize->id)
                ->lockForUpdate()
                ->first();

            $totalPoints = $prize->price * $quantity;

            // 檢查庫存
            if ($quantity > $prize->quantity) {
                return new RedeemResult(false, 'INSUFFICIENT_STOCK');
            }

            // 檢查使用者點數
            if ($user->points < $totalPoints) {
                return new RedeemResult(false, 'INSUFFICIENT_POINTS');
            }

            // 執行兌換
            $user->decrement('points', $totalPoints);
            $prize->decrement('quantity', $quantity);

            $redemption = PrizeRedemption::create([
                'user_id' => $user->id,
                'prize_id' => $prize->id,
                'quantity' => $quantity,
                'status' => PrizeRedemptionStatus::PENDING,
                'shipping_address' => $data['shipping_address'] ?? '',
                'note' => $data['note'] ?? null,
            ]);

            $this->flushCache();

            return new RedeemResult(true, null, $redemption);
        });
    }

    /**
     * 更新兌換狀態
     */
    public function updateStatus(PrizeRedemption $redemption, string $status): bool
    {
        if ($redemption->status === $status) {
            return false;
        }

        $redemption->update(['status' => $status]);
        $this->flushCache($redemption->id);

        return true;
    }

    /**
     * 更新兌換資訊
     */
    public function updateRedemptionInfo(PrizeRedemption $redemption, array $data): void
    {
        $redemption->update([
            'status' => $data['status'],
            'note' => $data['note'] ?? null,
            'shipping_address' => $data['shipping_address'] ?? '',
        ]);

        $this->flushCache($redemption->id);
    }

    /**
     * 刪除兌換紀錄
     */
    public function deleteRedemption(PrizeRedemption $redemption): void
    {
        $redemption->delete();
        $this->flushCache($redemption->id);
    }

    /**
     * 審核兌換
     */
    public function approveRedemption(PrizeRedemption $redemption): bool
    {
        if (! PrizeRedemptionStatus::canApprove($redemption->status)) {
            return false;
        }

        $redemption->update(['status' => PrizeRedemptionStatus::APPROVED]);
        $this->flushCache($redemption->id);

        return true;
    }

    /**
     * 清除快取
     */
    public function clearCache(?int $id = null): void
    {
        if ($id) {
            $this->flushCache($this->cacheKey("show_{$id}"));
        }

        $this->flushCache();
    }
}

/**
 * 域物件：兌換結果
 */
class RedeemResult
{
    public function __construct(
        public bool $success,
        public ?string $reason = null,
        public ?PrizeRedemption $redemption = null
    ) {}
}

/**
 * 兌換狀態常數
 */
class PrizeRedemptionStatus
{
    public const PENDING = 'pending';

    public const APPROVED = 'approved';

    public static function canApprove(string $status): bool
    {
        return $status === self::PENDING;
    }
}
