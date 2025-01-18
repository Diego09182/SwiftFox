<?php

namespace App\Services;

use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class VideoService
{
    public function getVideosByPage($page)
    {
        return Cache::tags(['videos'])->remember("videos_index_page_{$page}", 600, function () {
            return Video::orderBy('id', 'desc')->paginate(6);
        });
    }

    public function getVideoById($id)
    {
        return Cache::tags(['videos'])->remember("video_{$id}", 600, function () use ($id) {
            return Video::findOrFail($id);
        });
    }

    public function createVideo($request)
    {
        $uploadedFile = $request->file('video');
        $filename = time().'_'.mt_rand().'.'.$uploadedFile->getClientOriginalExtension();
        $path = $uploadedFile->storeAs('videos', $filename, 'public');

        return [
            'filename' => $filename,
            'path' => $path,
        ];
    }

    public function deleteVideo($video)
    {
        Storage::delete('public/videos/'.$video->filename);
        $video->delete();
    }

    public function clearCache($videoId = null)
    {
        Cache::tags(['videos'])->flush();

        if ($videoId) {
            Cache::tags(['videos'])->forget("video_{$videoId}");
        }
    }
}
