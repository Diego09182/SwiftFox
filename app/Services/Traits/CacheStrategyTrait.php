<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheStrategyTrait
{
    /**
     * 快取資料，如果結果為空，存入 '__empty__' 避免 DB 重複查詢
     * 隨機 TTL 避免快取雪崩
     * 支援 Redis lock 防止快取擊穿
     */
    protected function rememberEmpty(string $key, int $ttl, callable $callback)
    {
        $ttl += rand(0, 60); // 隨機化 TTL 避免同時過期

        $lockKey = "lock:{$key}";

        return Cache::tags([$this->cacheTag])->remember($key, $ttl, function () use ($callback, $lockKey) {
            $lock = Cache::lock($lockKey, 10); // 鎖最多 10 秒

            try {
                $lock->block(3); // 等待鎖 3 秒
                $result = $callback();

                return $result ?: '__empty__';
            } finally {
                optional($lock)->release();
            }
        });
    }

    /**
     * 從快取取得資料，若為空結果，回傳 null
     */
    protected function getFromCache(string $key)
    {
        $value = Cache::tags([$this->cacheTag])->get($key);
        if ($value === '__empty__') {
            return null;
        }

        return $value;
    }

    /**
     * 清除快取
     * 可指定 key 或清除整個 tag
     */
    protected function flushCache(?string $key = null)
    {
        if ($key) {
            Cache::tags([$this->cacheTag])->forget($key);
        } else {
            Cache::tags([$this->cacheTag])->flush();
        }
    }
}
