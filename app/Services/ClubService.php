<?php

namespace App\Services;

use App\Models\Club;

class ClubService extends AbstractService
{
    protected string $cacheTag = 'clubs';

    protected function getModelClass(): string
    {
        return Club::class;
    }

    public function getClubs(int $perPage = 6)
    {
        $page = request('page', 1);
        $key = $this->cacheKey("index_page_{$page}");

        return $this->rememberEmpty($key, 600, fn () => Club::latest()->paginate($perPage));
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
        $this->clearCache($club->id);
    }

    public function clearCache(?int $id = null): void
    {
        if ($id) {
            $this->flushCache($this->cacheKey("show_{$id}"));
        }
        $this->flushCache();
    }
}
