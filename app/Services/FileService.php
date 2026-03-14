<?php

namespace App\Services;

use App\Models\File;
use App\Models\FileEvaluation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileService extends AbstractService
{
    protected string $cacheTag = 'files';

    protected function getModelClass(): string
    {
        return File::class;
    }

    public function getFiles(int $perPage = 8)
    {
        $page = request('page', 1);
        $key = $this->cacheKey("index_page_{$page}");

        return $this->rememberEmpty($key, 600, fn () => File::latest()->paginate($perPage));
    }

    public function getFileById(int $id): File
    {
        $key = $this->cacheKey("show_{$id}");

        return $this->rememberEmpty($key, 600, fn () => File::findOrFail($id));
    }

    public function createFile(array $data, UploadedFile $uploadedFile): File
    {
        $user = Auth::user();
        $filename = str_replace(' ', '_', now()->timestamp.'_'.uniqid('', true).'.'.$uploadedFile->getClientOriginalExtension());
        $path = $uploadedFile->storeAs('files', $filename, 'public');

        $data['filename'] = $filename;
        $data['path'] = $path;
        $data['user_id'] = $user->id;
        $data['content'] = $data['content'] ?? null;

        $file = File::create($data);
        $user->increment('points', 10);
        $this->clearCache();

        return $file->fresh();
    }

    public function deleteFile(File $file): void
    {
        if ($file->path && Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }
        $file->delete();
        $this->clearCache($file->id);
    }

    public function likeFile(File $file): array
    {
        return $this->evaluateFile($file, 1, 'like');
    }

    public function dislikeFile(File $file): array
    {
        return $this->evaluateFile($file, -1, 'dislike');
    }

    protected function evaluateFile(File $file, int $value, string $column): array
    {
        $user = Auth::user();
        if (! $user) {
            return ['success' => false, 'message' => '使用者未登入', 'data' => null];
        }

        return DB::transaction(fn () => $this->doEvaluation($file, $user, $value, $column));
    }

    protected function doEvaluation(File $file, $user, int $value, string $column): array
    {
        $exists = FileEvaluation::where('file_id', $file->id)
            ->where('user_id', $user->id)
            ->lockForUpdate()
            ->exists();

        if ($exists) {
            return ['success' => false, 'message' => '已經評價過了', 'data' => null];
        }

        FileEvaluation::create([
            'file_id' => $file->id,
            'user_id' => $user->id,
            'evaluation' => $value,
        ]);

        $file->increment($column);
        $this->clearCache($file->id);

        return ['success' => true, 'message' => $value === 1 ? '已喜歡' : '已不喜歡', 'data' => $file->fresh()];
    }

    public function clearCache(?int $id = null): void
    {
        if ($id) {
            $this->flushCache($this->cacheKey("show_{$id}"));
        }
        $this->flushCache();
    }
}
