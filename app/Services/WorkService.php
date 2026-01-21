<?php

namespace App\Services;

use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class WorkService
{
    protected string $cacheTag = 'works';

    public function getWorks()
    {
        $page = request('page', 1);

        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("index_page_{$page}"), 600, fn () => Work::latest()->paginate(6));
    }

    public function getWorkById(int $id)
    {
        return Work::with('photos')->findOrFail($id);
    }

    public function createWork(array $data)
    {
        $data['user_id'] = Auth::id();
        $work = Work::create($data);
        $this->clearCache();

        return $work->fresh();
    }

    public function deleteWork(Work $work): void
    {
        $work->delete();
        $this->clearCache();
    }

    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    protected function clearCache(): void
    {
        Cache::tags([$this->cacheTag])->flush();
    }
}
