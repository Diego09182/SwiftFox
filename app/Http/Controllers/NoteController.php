<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Note;

class NoteController extends Controller
{
    public function index()
    {
        // 獲取當前登入的使用者
        $user = Auth::user();

        // 計算使用者的貼文和日記總數
        $totalPosts = $user->posts->count();
        $totalNotes = $user->notes->count();

        // 獲取所有日記，每頁4筆資料，按日記 ID 降冪排序
        $notes = Note::orderBy('id', 'desc')->paginate(4);

        // 返回視圖，並將使用者資訊、貼文總數和日記總數傳遞到視圖
        return view('swiftfox.home.index', [
            'user' => $user,
            'totalPosts' => $totalPosts,
            'totalNotes' => $totalNotes,
            'notes' => $notes,
        ]);
    }

    public function store(Request $request)
    {
        // 驗證並儲存新投票
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:10',
            'content' => 'required|min:2|max:50',
            'tag' => 'max:4',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過10個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字', 
            'tag.max' => '標題不能超過4個字',
        ]);

        // 使用 nl2br 函數換行轉換 content
        $note = new Note($validatedData);
        $note->content = nl2br($validatedData['content']);
        $note->user_id = auth()->user()->id;
        $note->save();

        // 重定向到日記列表，並顯示成功消息
        return redirect('/swiftfox/home')->with('success', '日記已創建成功！');
    }

    // 顯示日記
    public function show($id)
    {
        // 查找特定日記
        $note = Note::findOrFail($id);

        // 獲取使用者訊息
        $user = Auth::user();

        // 返回日記詳情，包括相關評論
        return view('swiftfox.home.show', ['note' => $note, 'user' => $user]);
    }

    // 刪除日記
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        // 重定向到日記列表，並顯示成功消息
        return redirect('/swiftfox/home')->with('success', '日記已成功刪除！');
    }
}
