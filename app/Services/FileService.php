<?php

namespace App\Services;

use App\Models\File;
use App\Models\FileEvaluation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function likeFile(File $file)
    {
        $this->evaluateFile($file, 1);
        $file->increment('like');

        return $file;
    }

    public function dislikeFile(File $file)
    {
        $this->evaluateFile($file, -1);
        $file->increment('dislike');

        return $file;
    }

    private function evaluateFile(File $file, int $evaluationValue)
    {
        $user = Auth::user();

        $evaluation = FileEvaluation::where('file_id', $file->id)
            ->where('user_id', $user->id)
            ->first();

        if ($evaluation) {
            throw new \Exception('已經評價過了');
        }

        FileEvaluation::create([
            'file_id' => $file->id,
            'user_id' => $user->id,
            'evaluation' => $evaluationValue,
        ]);
    }

    public function getFilesByPage(int $page)
    {
        return File::paginate($page);
    }

    public function createFile(array $data)
    {
        return File::create($data);
    }

    public function getFileById(int $id)
    {
        return File::findOrFail($id);
    }

    public function deleteFile(File $file)
    {
        Storage::delete('public/files/'.$file->filename);
        $file->delete();
    }
}
