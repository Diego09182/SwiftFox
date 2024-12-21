<?php

namespace App\Services;

use App\Models\Photo;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    // 檢查是否達到作品中相片的上傳限制
    public function checkPhotoLimit($workId)
    {
        $photoCount = Photo::where('work_id', $workId)->count();
        if ($photoCount >= 6) {
            throw new \Exception('最多只能上傳 6 張相片。');
        }
    }

    // 儲存上傳的相片
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

    // 更新相片資料
    public function updatePhoto($request, $photo)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'content' => 'nullable|string',
        ]);

        $photo->name = $validatedData['name'];
        $photo->content = $validatedData['content'] ?? $photo->content;
        $photo->save();

        return $photo;
    }

    // 刪除相片
    public function deletePhoto($photo)
    {
        // 刪除圖片檔案
        Storage::delete('public/photos/'.$photo->filename);

        // 刪除相片記錄
        $photo->delete();
    }
}
