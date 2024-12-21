<?php

namespace App\Services;

use App\Models\Opinion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class OpinionService
{
    public function getOpinionsByPage(int $page)
    {
        $cacheKey = 'opinions_index_page_' . $page;

        return Cache::tags(['opinions'])->remember($cacheKey, 600, function () {
            return Opinion::orderBy('id', 'desc')->paginate(3);
        });
    }

    public function createOpinion(array $data)
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = Auth::id();

        $opinion = Opinion::create($data);

        $this->clearCache();

        return $opinion;
    }

    public function deleteOpinion(Opinion $opinion)
    {
        $opinion->delete();

        $this->clearCache($opinion);
    }

    private function clearCache(Opinion $opinion = null)
    {
        Cache::tags(['opinions'])->flush();

        if ($opinion) {
            Cache::forget('opinion_' . $opinion->id);
        }
    }
}
