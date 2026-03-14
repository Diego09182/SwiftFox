<?php

namespace App\Services;

use App\Models\Video;
use DomainException;
use Illuminate\Support\Facades\Storage;

class VideoService extends AbstractService
{
    protected string $cacheTag = 'videos';

    protected function getModelClass(): string
    {
        return Video::class;
    }

    public function getVideos(int $page = 1, int $perPage = 9)
    {
        $key = $this->cacheKey("index_page_{$page}_{$perPage}");

        return $this->rememberEmpty($key, 600, fn () => Video::latest()->paginate($perPage));
    }

    public function getVideoById(int $id): Video
    {
        $key = $this->cacheKey("show_{$id}");

        return $this->rememberEmpty($key, 600, fn () => Video::findOrFail($id));
    }

    public function createVideo($file): array
    {
        if (! $file) {
            throw new DomainException('未提供影片檔案');
        }

        $filename = time().'_'.$file->getClientOriginalName();
        $path = $file->storeAs('videos', $filename, 'public');

        return compact('filename', 'path');
    }

    public function storeVideoData(array $data): Video
    {
        if (! isset($data['user_id'])) {
            throw new DomainException('缺少使用者 ID');
        }

        $data['content'] = nl2br($data['content'] ?? '');
        $video = Video::create($data);

        $this->clearCache();

        return $video->fresh();
    }

    public function deleteVideo(Video $video): void
    {
        if ($video->path && Storage::disk('public')->exists($video->path)) {
            Storage::disk('public')->delete($video->path);
        }

        $video->delete();

        $this->clearCache($video->id);
    }

    public function clearCache(?int $videoId = null): void
    {
        if ($videoId) {
            $this->flushCache($this->cacheKey("show_{$videoId}"));
        }

        $this->flushCache();
    }
}
