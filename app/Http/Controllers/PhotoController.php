<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class PhotoController extends Controller
{
    // 發布相片頁面
    public function create($workId)
    {
        $work = Work::with('photos')->findOrFail($workId);
        $user = Auth::user();

        return view('swiftfox.photo.create', [
            'work' => $work,
            'user' => $user,
        ]);
    }

    // 顯示單個作品
    public function show($workId, $photoId)
    {
        $work = Work::with('photos')->findOrFail($workId);
        $user = Auth::user();
        $photo = Photo::findOrFail($photoId);

        // 使用 Storage facade 獲取圖片的 URL
        $photoUrl = Storage::url($photo->path);

        return view('swiftfox.photo.show', [
            'work' => $work,
            'user' => $user,
            'photo' => $photo,
            'photoUrl' => $photoUrl,
        ]);
    }

    // 儲存相片
    public function store(Request $request, $workId)
    {
        // 檢查上傳相片數量和其他驗證規則
        $request->validate([
            'name' => 'required|string',
            'content' => 'nullable|string',
            'file' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048',
                function ($attribute, $value, $fail) use ($workId) {
                    // 檢查已上傳的相片數量是否超過 6 張
                    $photoCount = Photo::where('work_id', $workId)->count();
                    if ($photoCount >= 6) {
                        $fail('最多只能上傳 6 張相片。');
                    }
                },
            ],
        ], [
            'name.required' => '名稱是必填項目',
            'file.required' => '檔案是必填項目',
            'file.image' => '上傳的文件必須是圖片',
            'file.mimes' => '檔案格式必須是 jpeg、png、jpg 或 gif',
            'file.max' => '檔案大小不能超過 2048KB',
        ]);

        // 儲存上傳的檔案
        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $path = $uploadedFile->storeAs('photos', $filename, 'public');

        // 創建新相片記錄
        $photo = new Photo([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'work_id' => $workId,
            'user_id' => Auth::id(),
            'filename' => $filename,
            'path' => $path,
        ]);

        $photo->save();

        // 清除與該作品相關的快取
        Cache::tags(['work_' . $workId])->flush();

        return redirect()->route('work.show', ['work' => $workId])->with('success', '相片已添加！');
    }

    // 更新相片
    public function update(Request $request, $workId, $photoId)
    {
        // 查找特定相片
        $photo = Photo::findOrFail($photoId);

        if (Gate::denies('update-photo', $photo)) {
            return redirect()->back()->with('error', '沒有權限更新此相片！');
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'content' => 'nullable|string',
        ]);

        // 更新相片信息
        $photo->name = $validatedData['name'];
        $photo->content = $validatedData['content'] ?? $photo->content;
        $photo->save();

        // 清除作品集的快取
        Cache::tags(['work_' . $workId])->flush();

        return redirect()->route('work.show', ['work' => $workId])->with('success', '相片訊息已更新！');
    }

    // 刪除相片
    public function destroy($workId, $photoId)
    {
        // 查找特定相片
        $photo = Photo::findOrFail($photoId);

        if (Gate::denies('delete-photo', $photo)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        // 刪除相片檔案
        Storage::delete('public/photos/' . $photo->filename);

        // 刪除相片記錄
        $photo->delete();

        // 清除作品集的快取
        Cache::tags(['work_' . $workId])->flush();

        return redirect()->route('work.show', ['work' => $workId])->with('success', '相片已刪除！');
    }
}
