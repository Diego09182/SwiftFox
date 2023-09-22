<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Opinion;
use App\Models\Record;
class OpinionController extends Controller
{

    public function agree(Opinion $opinion)
    {
        $user = auth()->user();
        
        // 檢查用戶是否已對該投票進行評價，如果已評價則不再允許評價
        $record = Record::where('opinion_id', $opinion->id)
            ->where('user_id', $user->id)
            ->first();

        if ($record) {
            return back()->with('success', '您已經投票過了。');
        }

        // 創建一條同意的評價記錄
        Record::create([
            'opinion_id' => $opinion->id,
            'user_id' => $user->id,
        ]);

        $opinion->increment('count');
        // 增加投票的同意數
        $opinion->increment('agree');

        return back()->with('success', '您已成功贊成該投票。');
    }

    public function disagree(Opinion $opinion)
    {
        $user = auth()->user();

        // 檢查用戶是否已對該投票進行評價，如果已評價則不再允許評價
        $record = Record::where('opinion_id', $opinion->id)
            ->where('user_id', $user->id)
            ->first();

        if ($record) {
            return back()->with('success', '您已經投票過了。');
        }

        // 創建一條不同意的投票記錄
        Record::create([
            'opinion_id' => $opinion->id,
            'user_id' => $user->id,
        ]);

        $opinion->increment('count');
        // 增加投票的不同意數
        $opinion->increment('disagree');

        return back()->with('success', '您已成功反對該事項。');
    }

    // 顯示所有投票列表
    public function index()
    {
        // 獲取所有投票，每頁 3 筆資料，按貼文 ID 降冪排序
        $opinions = Opinion::orderBy('id', 'desc')->paginate(3);

        // 獲取使用者訊息
        $user = Auth::user();

        // 返回文章列表，並將分頁結果傳遞到視圖
        return view('swiftfox.opinion.index', ['opinions' => $opinions, 'user' => $user]);
    }
    
    // 儲存新投票
    public function store(Request $request)
    {
        // 驗證並儲存新投票
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

        // 使用 nl2br 函數換行轉換 content
        $opinion = new Opinion($validatedData);
        $opinion->content = nl2br($validatedData['content']);
        $opinion->user_id = auth()->user()->id;
        $opinion->save();

        // 重定向到投票列表，並顯示成功消息
        return redirect('/swiftfox/opinions')->with('success', '投票已創建成功！');
    }

    // 顯示特定投票詳情
    public function show($id)
    {
        // 查找特定投票
        $opinion = Opinion::findOrFail($id);

        // 獲取使用者訊息
        $user = Auth::user();

        // 計算同意比率和不同意比率
        $totalVotes = $opinion->count;
        $agreeRatio = $totalVotes > 0 ? ($opinion->agree / $totalVotes) * 100 : 0;
        $disagreeRatio = $totalVotes > 0 ? ($opinion->disagree / $totalVotes) * 100 : 0;

        // 返回投票詳情，包括相關評論以及同意和不同意比率
        return view('swiftfox.opinion.show', ['opinion' => $opinion, 'user' => $user, 'agreeRatio' => $agreeRatio, 'disagreeRatio' => $disagreeRatio]);
    }

    // 刪除投票
    public function destroy($id)
    {
        $opinion = Opinion::findOrFail($id);
        $opinion->delete();

        // 重定向到投票列表，並顯示成功消息
        return redirect('/swiftfox/opinions')->with('success', '投票已成功刪除！');
    }
}
