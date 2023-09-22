<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\Photo;

class WorkController extends Controller
{
    // 顯示所有作品集列表
    public function index()
    {
        // 獲取所有作品集，每頁3筆資料，按貼文 ID 降冪排序
        $works = Work::orderBy('id', 'desc')->paginate(6);

        // 獲取使用者訊息
        $user = Auth::user();

        // 返回作品集列表，並將分頁結果傳遞到視圖
        return view('swiftfox.work.index', ['works' => $works, 'user' => $user]);
    }
    
    // 儲存新作品集
    public function store(Request $request)
    {
        // 驗證並儲存新作品集
        $validatedData = $request->validate([
            'name' => 'required|min:2|max:10',
        ], [
            'name.required' => '作品名稱為必填項目',
            'name.min' => '作品名稱至少需要2個字',
            'name.max' => '作品名稱不能超過10個字',
        ]);

        // 使用 nl2br 函數換行轉換 content
        $work = new Work($validatedData);
        $work->user_id = auth()->user()->id;
        $work->save();

        // 重定向到作品集列表，並顯示成功消息
        return redirect('/swiftfox/works')->with('success', '作品已創建成功！');
    }

    // 顯示特定作品集詳情
    public function show($id)
    {
        // 查找特定作品集
        $work = Work::findOrFail($id);

        // 使用關聯方法獲取與作品集關聯的相片
        $photos = $work->photos;

        // 獲取使用者訊息
        $user = Auth::user();

        // 返回作品集詳情，包括相關評論以及同意和不同意比率
        return view('swiftfox.work.show', ['work' => $work, 'user' => $user, 'photos' => $photos]);
    }

    // 刪除作品集
    public function destroy($id)
    {
        $work = Work::findOrFail($id);
        $work->delete();

        // 重定向到作品集列表，並顯示成功消息
        return redirect('/swiftfox/work')->with('success', '作品已成功刪除！');
    }
}
