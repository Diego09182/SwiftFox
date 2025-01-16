<?php

namespace App\Services;

use App\Models\File;

class FileService
{
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
        return $file->delete();
    }
}
