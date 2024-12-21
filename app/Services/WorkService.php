<?php

namespace App\Services;

use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class WorkService
{
    // 檢查用戶的作品數量是否達到限制
    public function checkWorkLimit()
    {
        // 假設每個用戶最多創建 10 個作品
        $workCount = Work::where('user_id', Auth::id())->count();

        if ($workCount >= 10) {
            throw new \Exception('您已達到作品數量限制');
        }
    }

    // 用來處理作品創建的邏輯
    public function createWork($validatedData)
    {
        $work = new Work($validatedData);
        $work->user_id = Auth::id();
        $work->save();

        return $work;
    }

    // 取得所有作品，並處理分頁
    public function getAllWorks($page = 1)
    {
        return Work::orderBy('id', 'desc')->paginate(6);
    }

    // 取得單一作品和相關的照片
    public function getWorkById($id)
    {
        return Work::with('photos')->findOrFail($id);
    }

    // 刪除作品
    public function deleteWork($id)
    {
        $work = Work::findOrFail($id);
        $work->delete();
    }
}
