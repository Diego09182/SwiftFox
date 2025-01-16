<?php

namespace App\Http\Controllers;

use App\Events\BulletinPublished;
use App\Models\Bulletin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulletinController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->administration != 5) {
            return response()->json([
                'success' => false,
                'message' => '您沒有權限',
            ], 403);
        }

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

        $bulletin = new Bulletin($validatedData);
        $bulletin->content = nl2br($validatedData['content']);
        $bulletin->save();

        event(new BulletinPublished($validatedData['title'], $bulletin->content));

        return response()->json([
            'success' => true,
            'message' => '公告儲存成功',
        ]);
    }
}
