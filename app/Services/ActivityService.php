<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ActivityService extends AbstractService
{
    protected string $cacheTag = 'activities';

    protected function getModelClass(): string
    {
        return Activity::class;
    }

    public function getActivities(int $perPage = 6)
    {
        $page = request('page', 1);
        $key = $this->cacheKey("index_page_{$page}");

        return $this->rememberEmpty($key, 600, function () use ($perPage) {
            return Activity::latest()->paginate($perPage);
        });
    }

    public function createActivity(array $data, ?UploadedFile $image = null): Activity
    {
        if ($image) {
            $data['image'] = $image->store('activities', 'public');
        }

        $activity = Activity::create($data);

        $this->clearCache();

        return $activity->fresh();
    }

    public function deleteActivity(Activity $activity): void
    {
        if ($activity->image && Storage::disk('public')->exists($activity->image)) {
            Storage::disk('public')->delete($activity->image);
        }

        $activity->delete();

        $this->clearCache($activity->id);
    }

    public function clearCache(?int $id = null): void
    {
        if ($id) {
            $this->flushCache($this->cacheKey("show_{$id}"));
        }
        $this->flushCache();
    }
}
