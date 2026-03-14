<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PhotoService extends AbstractService
{
    protected string $cacheTag = 'photos';

    protected function getModelClass(): string
    {
        return Photo::class;
    }

    public function createPhoto($request, int $workId): array
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

        return [
            'success' => true,
            'message' => '照片已新增',
            'data' => $photo->fresh(),
        ];
    }

    public function deletePhoto(Photo $photo): array
    {
        if (Storage::disk('public')->exists($photo->path)) {
            Storage::disk('public')->delete($photo->path);
        }

        $photo->delete();
        $this->clearCache();

        return [
            'success' => true,
            'message' => '照片已刪除',
            'data' => null,
        ];
    }

    public function clearCache(?int $id = null): void
    {
        if ($id) {
            Cache::tags([$this->cacheTag])->forget($this->cacheKey("show_{$id}"));
        }

        $this->flushCache();
    }
}
