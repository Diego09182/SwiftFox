<?php

namespace App\Services;

use App\Models\Video;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class VideoService
{
    protected string $cacheTag = 'videos';

    public function getVideos()
    {
        $page = request('page', 1);

        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("index_page_{$page}"), 600, fn () => Video::latest()->paginate(6));
    }

    public function getVideoById(int $id)
    {
        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("show_{$id}"), 600, fn () => Video::findOrFail($id));
    }

    public function createVideoFile($uploadedFile)
    {
        $filename = time().'_'.uniqid().'.'.$uploadedFile->getClientOriginalExtension();
        $path = $uploadedFile->storeAs('videos', $filename, 'public');

        return ['filename' => $filename, 'path' => $path];
    }

    public function storeVideoData(array $data)
    {
        $video = Video::create($data);
        $this->clearCache();

        return $video->fresh();
    }

    public function deleteVideo(Video $video): void
    {
        if ($video->filename && Storage::disk('public')->exists('videos/'.$video->filename)) {
            Storage::disk('public')->delete('videos/'.$video->filename);
        }
        $video->delete();
        $this->clearCache();
    }

    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    protected function clearCache(?int $id = null): void
    {
        Cache::tags([$this->cacheTag])->flush();
        if ($id) {
            Cache::tags([$this->cacheTag])->forget($this->cacheKey("show_{$id}"));
        }
    }
}
