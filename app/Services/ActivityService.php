<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Facades\Cache;

class ActivityService
{
    public function getActivitiesByPage(int $page)
    {
        $cacheKey = 'activities_page_'.$page;

        return Cache::tags(['activities'])->remember($cacheKey, 600, function () {
            return Activity::orderBy('id', 'desc')->paginate(6);
        });
    }

    public function createActivity(array $data)
    {
        $data['content'] = nl2br($data['content']);

        $activity = Activity::create($data);

        $this->clearCache();

        return $activity;
    }

    public function deleteActivity(Activity $activity)
    {
        $activity->delete();

        $this->clearCache();
    }

    public function clearCache()
    {
        Cache::tags(['activities'])->flush();
    }
}
