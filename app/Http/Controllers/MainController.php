<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Post;
use App\Models\Article;
use App\Models\Work;
use App\Models\Opinion;
use App\Models\Note;
use App\Models\Bulletin;

class MainController extends Controller
{
    public function index()
    {
        // 獲取當前登入的使用者
        $user = Auth::user();

        // 使用快取獲取最新公告
        $bulletin = Cache::remember('latest_bulletin', 600, function() {
            return Bulletin::orderBy('id', 'desc')->first();
        });

        // 使用快取獲取各個資源的數量
        $userCount = Cache::remember('user_count', 600, function() {
            return User::count();
        });

        $postCount = Cache::remember('post_count', 600, function() {
            return Post::count();
        });

        $articleCount = Cache::remember('article_count', 600, function() {
            return Article::count();
        });

        $workCount = Cache::remember('work_count', 600, function() {
            return Work::count();
        });

        $opinionCount = Cache::remember('opinion_count', 600, function() {
            return Opinion::count();
        });

        $noteCount = Cache::remember('note_count', 600, function() {
            return Note::count();
        });

        // 返回視圖，並將使用者資訊、最新的公告資料以及其他資源數量傳遞到視圖
        return view('swiftfox.main', compact(
            'user',
            'bulletin',
            'userCount',
            'postCount',
            'articleCount',
            'workCount',
            'opinionCount',
            'noteCount'
        ));        
    }
}
