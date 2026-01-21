<?php

namespace App\Services;

use App\Models\File;
use App\Models\FileEvaluation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileService
{
    protected string $cacheTag = 'files';

    public function getFiles()
    {
        $page = request('page', 1);

        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("index_page_{$page}"), 600, fn () => File::latest()->paginate(8));
    }

    public function getFileById(int $id)
    {
        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("show_{$id}"), 600, fn () => File::findOrFail($id));
    }

    public function createFile(array $data, UploadedFile $uploadedFile)
    {
        $this->handleUpload($data, $uploadedFile);

        $file = File::create($data);
        $this->rewardUserPoints();
        $this->clearCache();

        return $file->fresh();
    }

    public function deleteFile(File $file): void
    {
        $this->deletePhysicalFile($file);
        $file->delete();
        $this->clearCache();
    }

    public function likeFile(File $file)
    {
        return $this->evaluateFile($file, 1, 'like');
    }

    public function dislikeFile(File $file)
    {
        return $this->evaluateFile($file, -1, 'dislike');
    }

    protected function evaluateFile(File $file, int $value, string $column)
    {
        $user = Auth::user();

        return DB::transaction(function () use ($file, $user, $value, $column) {
            $exists = FileEvaluation::where('file_id', $file->id)
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->exists();

            if ($exists) {
                return $this->fail('已經評價過了');
            }

            FileEvaluation::create([
                'file_id' => $file->id,
                'user_id' => $user->id,
                'evaluation' => $value,
            ]);

            $file->increment($column);
            $this->clearCache();

            return $this->success($file->fresh(), $value === 1 ? '已喜歡' : '已不喜歡');
        });
    }

    protected function handleUpload(array &$data, UploadedFile $uploadedFile): void
    {
        $filename = now()->timestamp.'_'.uniqid('', true).'.'.$uploadedFile->getClientOriginalExtension();
        $filename = str_replace(' ', '_', $filename);
        $data['filename'] = $filename;
        $data['path'] = $uploadedFile->storeAs('files', $filename, 'public');
    }

    protected function deletePhysicalFile(File $file): void
    {
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }
    }

    protected function rewardUserPoints(): void
    {
        Auth::user()->increment('points', 10);
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
