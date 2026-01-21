<?php

namespace App\Services;

use App\Models\Club;
use Illuminate\Support\Facades\Cache;

class ClubService
{
    protected string $cacheTag = 'clubs';

    public function getClubs()
    {
        $page = request('page', 1);

        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("index_page_{$page}"), 600, fn () => Club::latest()->paginate(6));
    }

    public function createClub(array $data)
    {
        $club = Club::create($data);
        $this->clearCache();

        return $club->fresh();
    }

    public function deleteClub(Club $club): void
    {
        $club->delete();
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
