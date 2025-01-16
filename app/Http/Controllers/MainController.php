<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bulletin;
use App\Models\Note;
use App\Models\Opinion;
use App\Models\Post;
use App\Models\User;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $bulletin = Cache::remember('latest_bulletin', 600, function () {
            return Bulletin::orderBy('id', 'desc')->first();
        });

        $userCount = Cache::remember('user_count', 600, function () {
            return User::count();
        });

        $postCount = Cache::remember('post_count', 600, function () {
            return Post::count();
        });

        $articleCount = Cache::remember('article_count', 600, function () {
            return Article::count();
        });

        $workCount = Cache::remember('work_count', 600, function () {
            return Work::count();
        });

        $opinionCount = Cache::remember('opinion_count', 600, function () {
            return Opinion::count();
        });

        $noteCount = Cache::remember('note_count', 600, function () {
            return Note::count();
        });

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
