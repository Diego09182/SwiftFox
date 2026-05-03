<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheStrategyTrait
{
    protected const CACHE_EMPTY = '__cache_empty__';

    /**
     * 取得快取資料，若不存在則建立
     * 防止：
     * - Cache Penetration
     * - Cache Stampede
     * - Cache Avalanche
     */
    protected function rememberEmpty(string $key, int $ttl, callable $callback)
    {
        $ttl += random_int(0, 60);

        $taggedCache = Cache::tags([$this->cacheTag]);

        // 先讀 cache
        $value = $taggedCache->get($key);

        if ($value !== null) {
            return $value === self::CACHE_EMPTY ? null : $value;
        }

        $lock = Cache::lock("lock:{$key}", 10);

        try {
            $lock->block(3);

            // double check
            $value = $taggedCache->get($key);

            if ($value !== null) {
                return $value === self::CACHE_EMPTY ? null : $value;
            }

            $result = $callback();

            $taggedCache->put(
                $key,
                $result ?: self::CACHE_EMPTY,
                $ttl
            );

            return $result;

        } finally {
            optional($lock)->release();
        }
    }

    /**
     * 直接取得 cache
     */
    protected function getFromCache(string $key)
    {
        $value = Cache::tags([$this->cacheTag])->get($key);

        if ($value === self::CACHE_EMPTY) {
            return null;
        }

        return $value;
    }

    /**
     * 清除 cache
     */
    protected function flushCache(?string $key = null): void
    {
        $cache = Cache::tags([$this->cacheTag]);

        if ($key) {
            $cache->forget($key);
            return;
        }

        $cache->flush();
    }
}
