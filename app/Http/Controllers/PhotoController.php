<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Work;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    protected $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

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
        // 獲取作品和其所有相片
        $work = Work::with('photos')->findOrFail($workId);

        // 當前登入的用戶
        $user = Auth::user();

        // 找到指定的相片
        $photo = Photo::findOrFail($photoId);

        // 生成相片 URL
        $photoUrl = Storage::url($photo->path);

        // 獲取所有與該作品關聯的相片
        $photos = $work->photos;

        return view('swiftfox.photo.show', [
            'work' => $work,
            'user' => $user,
            'photo' => $photo,
            'photoUrl' => $photoUrl,
            'photos' => $photos,
        ]);
    }

    // 儲存相片
    public function store(Request $request, $workId)
    {
        try {
            // 檢查相片數量限制
            $this->photoService->checkPhotoLimit($workId);
        } catch (\Exception $e) {
            return redirect()->route('work.show', ['work' => $workId])->with('error', $e->getMessage());
        }

        // 儲存相片
        $photo = $this->photoService->storePhoto($request, $workId);

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

        // 更新相片信息
        $this->photoService->updatePhoto($request, $photo);

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

        // 刪除相片
        $this->photoService->deletePhoto($photo);

        return redirect()->route('work.show', ['work' => $workId])->with('success', '相片已刪除！');
    }
}
