<?php

namespace App\Services;

use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class WorkService extends AbstractService
{
    protected string $cacheTag = 'works';

    protected function getModelClass(): string
    {
        return Work::class;
    }

    public function getWorks(int $page = 1, int $perPage = 6)
    {
        $key = $this->cacheKey("index_page_{$page}_{$perPage}");

        return $this->rememberEmpty($key, 600, fn () => Work::latest()->paginate($perPage));
    }

    public function getWorkById(int $id): Work
    {
        $key = $this->cacheKey("show_{$id}");

        return $this->rememberEmpty($key, 600, fn () => Work::with('photos')->findOrFail($id));
    }

    public function createWork(array $data): Work
    {
        $data['user_id'] = Auth::id();
        $work = Work::create($data);

        $this->clearCache();

        return $work->fresh();
    }

    public function deleteWork(Work $work): void
    {
        $work->delete();
        $this->clearCache($work->id);
    }

    public function clearCache(?int $workId = null): void
    {
        if ($workId) {
            $this->flushCache($this->cacheKey("show_{$workId}"));
        }

        $this->flushCache();
    }
}
