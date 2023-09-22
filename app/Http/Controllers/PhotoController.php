<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\Photo;

class PhotoController extends Controller
{

    public function show($work, $photo)
    {
        // 查找特定作品，同時預先載入關聯資料（使用 with 方法）
        $work = Work::with('photos')->findOrFail($work);

        // 獲取使用者訊息
        $user = Auth::user();

        // 查找特定相片
        $photo = Photo::findOrFail($photo);

        // 获取特定作品的所有相片
        $photos = $work->photos;

        // 返回作品详情，包括相关评论、特定的相片和所有相片
        return view('swiftfox.photo.show', ['work' => $work, 'user' => $user, 'photo' => $photo, 'photos' => $photos]);
    }

    public function store(Request $request, $work)
    {
        // 驗證請求數據，包括文件
        $request->validate([
            'name' => 'required|string',
            'content' => 'nullable|string',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 根據需要調整文件驗證規則
        ]);

        // 儲存上傳的文件
        $uploadedFile = $request->file('file');
        $filename = time() . '_' . $uploadedFile->getClientOriginalName();
        $path = $uploadedFile->storeAs('photos', $filename, 'public');

        // 創建新的相片記錄
        $photo = new Photo([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'work_id' => $work,
            'user_id' => Auth::id(),
            'filename' => $filename,
            'path' => $path,
        ]);

        $photo->save();

        // 重定向到 work.show 路由並帶有成功消息
        return redirect()->route('work.show', ['work' => $work])->with('success', '相片已添加！');
    }

    public function edit($work, $photo)
    {
        // 查找特定相片
        $photo = Photo::findOrFail($photo);

        // 检查相片是否属于当前用户
        if ($photo->user_id != Auth::id()) {
            return redirect()->back()->with('error', '你沒有權限編輯此相片！');
        }

        // 返回编辑相片的视图，包括相片信息
        return view('photo.edit', ['photo' => $photo]);
    }

    public function update(Request $request, $work, $photo)
    {
        // 查找特定相片
        $photo = Photo::findOrFail($photo);

        // 检查相片是否属于当前用户
        if ($photo->user_id != Auth::id()) {
            return redirect()->back()->with('error', '您没有权限编辑此相片！');
        }

        // 验证请求数据
        $request->validate([
            'name' => 'required|string',
            'filename' => 'required|string',
            'content' => 'nullable|string',
            'path' => 'required|string',
        ]);

        // 更新相片信息
        $photo->name = $request->input('name');
        $photo->filename = $request->input('filename');
        $photo->content = $request->input('content');
        $photo->path = $request->input('path');

        $photo->save();

        // 重定向到作品详情页，并显示成功消息
        return redirect()->route('work.show', ['work' => $work])->with('success', '相片信息已更新！');
    }

    public function destroy($work, $photo)
    {
        // 查找特定相片
        $photo = Photo::findOrFail($photo);

        // 檢查相片是否屬於當前用戶或用戶具有管理權限
        if ($photo->user_id != Auth::id() && Auth::user()->administration != 5) {
            return redirect()->back()->with('error', '您沒有權限刪除此相片！');
        }

        // 獲取相片的存儲路徑
        $photoPath = storage_path('app/public/photos/' . $photo->filename);

        // 檢查文件是否存在，然後刪除它
        if (file_exists($photoPath)) {
            unlink($photoPath);
        }

        // 刪除相片記錄
        $photo->delete();

        // 重定向到作品詳情頁，並顯示成功消息
        return redirect()->route('work.show', ['work' => $work])->with('success', '相片已刪除！');
    }
    
}
