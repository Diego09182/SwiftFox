<?php

namespace App\Services;

use App\Models\File;
use App\Models\FileEvaluation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function likeFile(File $file): array
    {
        $result = $this->evaluateFile($file, 1);

        if (!$result['success']) {
            return $result;
        }

        $file->increment('like');

        return [
            'success' => true,
            'message' => '已喜歡',
            'data'    => $file->fresh(),
        ];
    }

    public function dislikeFile(File $file): array
    {
        $result = $this->evaluateFile($file, -1);

        if (!$result['success']) {
            return $result;
        }

        $file->increment('dislike');

        return [
            'success' => true,
            'message' => '已不喜歡',
            'data'    => $file->fresh(),
        ];
    }

    private function evaluateFile(File $file, int $evaluationValue): array
    {
        $user = Auth::user();

        $evaluation = FileEvaluation::where('file_id', $file->id)
            ->where('user_id', $user->id)
            ->first();

        if ($evaluation) {
            return ['success' => false, 'message' => '已經評價過了'];
        }

        FileEvaluation::create([
            'file_id'    => $file->id,
            'user_id'    => $user->id,
            'evaluation' => $evaluationValue,
        ]);

        return ['success' => true];
    }

    public function getFilesByPage(int $perPage = 8)
    {
        return File::paginate($perPage);
    }

    public function createFile(array $data)
    {
        return File::create($data);
    }

    public function getFileById(int $id)
    {
        return File::find($id);
    }

    public function deleteFile(File $file)
    {
        Storage::delete('public/files/' . $file->filename);
        $file->delete();
    }
}
