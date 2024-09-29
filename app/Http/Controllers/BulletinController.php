<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bulletin;
use App\Events\BulletinPublished;

class BulletinController extends Controller
{
    public function store(Request $request)
    {
        // 檢查用戶權限
        if (Auth::user()->administration != 5) {
            return response()->json([
                'success' => false,
                'message' => '您沒有權限'
            ], 403);
        }

        // 驗證數據
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:10',
            'content' => 'required|min:2|max:50',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過10個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',
        ]);

        // 儲存公告
        $bulletin = new Bulletin($validatedData);
        $bulletin->content = nl2br($validatedData['content']);
        $bulletin->save();

        // 發送公告事件
        event(new BulletinPublished($validatedData['title'], $bulletin->content));

        // 返回成功消息
        return response()->json([
            'success' => true,
            'message' => '公告儲存成功',
        ]);
    }
}
