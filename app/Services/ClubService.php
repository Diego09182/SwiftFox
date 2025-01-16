<?php

namespace App\Services;

use App\Models\Club;
use Illuminate\Support\Facades\Cache;

class ClubService
{
    public function getClubsByPage(int $page)
    {
        $cacheKey = 'club_index_page_'.$page;

        return Cache::tags(['clubs'])->remember($cacheKey, 600, function () {
            return Club::orderBy('id', 'desc')->paginate(9);
        });
    }

    public function createClub(array $data)
    {
        $data['content'] = nl2br($data['content']);
        $club = Club::create($data);

        $this->clearCache();

        return $club;
    }

    public function deleteClub(Club $club)
    {
        $club->delete();

        $this->clearCache();
    }

    public function clearCache()
    {
        Cache::tags(['clubs'])->flush();
    }
}
