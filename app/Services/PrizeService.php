<?php

namespace App\Services;

use App\Models\Prize;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PrizeService extends AbstractService
{
    protected string $cacheTag = 'prizes';

    protected function getModelClass(): string
    {
        return Prize::class;
    }

    public function createPrize(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $data['image']->store('prizes', 'public');
        }

        $prize = Prize::create($data);
        $this->clearCache();

        return $prize->fresh();
    }

    public function updatePrize(Prize $prize, array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($prize->image && Storage::disk('public')->exists($prize->image)) {
                Storage::disk('public')->delete($prize->image);
            }
            $data['image'] = $data['image']->store('prizes', 'public');
        }

        $prize->update($data);
        $this->clearCache();

        return $prize->fresh();
    }

    public function deletePrize(Prize $prize): void
    {
        if ($prize->image && Storage::disk('public')->exists($prize->image)) {
            Storage::disk('public')->delete($prize->image);
        }

        $prize->delete();
        $this->clearCache();
    }

    public function clearCache(?int $id = null): void
    {
        if ($id) {
            Cache::tags([$this->cacheTag])->forget($this->cacheKey("show_{$id}"));
        }

        $this->flushCache();
    }
}
