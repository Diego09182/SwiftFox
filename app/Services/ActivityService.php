<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ActivityService
{
    protected string $cacheTag = 'activities';

    public function getActivities(int $perPage = 6)
    {
        $page = request('page', 1);
        $cacheKey = $this->cacheKey("index_page_{$page}");

        return Cache::tags([$this->cacheTag])->remember($cacheKey, 600, function () use ($perPage) {
            return Activity::latest()->paginate($perPage);
        });
    }

    public function getActivityById(int $id): Activity
    {
        $cacheKey = $this->cacheKey("show_{$id}");

        return Cache::tags([$this->cacheTag])->remember($cacheKey, 600, function () use ($id) {
            return Activity::findOrFail($id);
        });
    }

    public function createActivity(array $data, ?UploadedFile $file = null): Activity
    {
        if ($file) {
            $this->handleUpload($data, $file);
        }

        $activity = Activity::create($data);

        $this->clearCache();

        return $activity->fresh();
    }

    public function deleteActivity(Activity $activity): void
    {
        $this->deleteFileIfExists($activity);
        $activity->delete();

        $this->clearCache();
    }

    protected function handleUpload(array &$data, UploadedFile $file): void
    {
        $filename = now()->timestamp.'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('activity', $filename, 'public');

        $data['filename'] = $filename;
        $data['path'] = $path;
    }

    protected function deleteFileIfExists(Activity $activity): void
    {
        if ($activity->path && Storage::disk('public')->exists($activity->path)) {
            Storage::disk('public')->delete($activity->path);
        }
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
