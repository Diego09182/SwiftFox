<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    protected string $cacheTag = 'photos';

    public function createPhoto($request, int $workId)
    {
        $uploadedFile = $request->file('file');
        $filename = uniqid().'_'.time().'.'.$uploadedFile->getClientOriginalExtension();
        $path = $uploadedFile->storeAs('images', $filename, 'public');

        $photo = Photo::create([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'work_id' => $workId,
            'user_id' => Auth::id(),
            'filename' => $filename,
            'path' => $path,
        ]);

        $this->clearCache();

        return $this->success($photo->fresh(), '照片已新增');
    }

    public function deletePhoto(Photo $photo)
    {
        if (Storage::disk('public')->exists($photo->path)) {
            Storage::disk('public')->delete($photo->path);
        }

        $photo->delete();
        $this->clearCache();

        return $this->success(null, '照片已刪除');
    }

    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    protected function clearCache(): void
    {
        Cache::tags([$this->cacheTag])->flush();
    }

    protected function success($data = null, ?string $message = null): array
    {
        return ['success' => true, 'message' => $message, 'data' => $data];
    }

    protected function fail(string $message): array
    {
        return ['success' => false, 'message' => $message, 'data' => null];
    }
}
