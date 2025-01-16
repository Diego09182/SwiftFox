<?php

namespace App\Services;

use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    public function checkPhotoLimit($workId)
    {
        $photoCount = Photo::where('work_id', $workId)->count();
        if ($photoCount >= 6) {
            throw new \Exception('最多只能上傳 6 張相片。');
        }
    }

    public function storePhoto($request, $workId)
    {
        $uploadedFile = $request->file('file');
        $filename = time().'_'.$uploadedFile->getClientOriginalName();
        $path = $uploadedFile->storeAs('photos', $filename, 'public');

        $photo = new Photo([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'work_id' => $workId,
            'user_id' => Auth::id(),
            'filename' => $filename,
            'path' => $path,
        ]);

        $photo->save();

        return $photo;
    }

    public function deletePhoto($photo)
    {
        Storage::delete('public/photos/'.$photo->filename);

        $photo->delete();
    }
}
