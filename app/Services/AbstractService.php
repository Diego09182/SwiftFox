<?php

namespace App\Services;

use App\Services\Traits\CacheStrategyTrait;

abstract class AbstractService
{
    use CacheStrategyTrait;

    /**
     * 子類可覆寫自己的快取標籤
     */
    protected string $cacheTag = '';

    /**
     * 子類指定對應的 Model
     */
    abstract protected function getModelClass(): string;

    /**
     * 生成快取 key
     */
    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    /**
     * 清除快取
     * 子類自行決定如何清除
     */
    abstract public function clearCache(?int $id = null): void;
}
