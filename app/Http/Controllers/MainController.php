<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bulletin;
use App\Models\Note;
use App\Models\Opinion;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use App\Models\Work;
use App\Models\File;
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

        $userCount = Cache::remember('user_count', 600, fn() => User::count());
        $postCount = Cache::remember('post_count', 600, fn() => Post::count());
        $articleCount = Cache::remember('article_count', 600, fn() => Article::count());
        $workCount = Cache::remember('work_count', 600, fn() => Work::count());
        $opinionCount = Cache::remember('opinion_count', 600, fn() => Opinion::count());
        $noteCount = Cache::remember('note_count', 600, fn() => Note::count());
        $videoCount = Cache::remember('video_count', 600, fn() => Video::count());
        $postTopUsers = Cache::remember('top_users_post', 600, function () {
            return Post::selectRaw('user_id, COUNT(*) as total')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user:id,name')
                ->take(5)
                ->get();
        });

        $articleTopUsers = Cache::remember('top_users_article', 600, function () {
            return Article::selectRaw('user_id, COUNT(*) as total')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user:id,name')
                ->take(5)
                ->get();
        });

        $workTopUsers = Cache::remember('top_users_work', 600, function () {
            return Work::selectRaw('user_id, COUNT(*) as total')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user:id,name')
                ->take(5)
                ->get();
        });

        $opinionTopUsers = Cache::remember('top_users_opinion', 600, function () {
            return Opinion::selectRaw('user_id, COUNT(*) as total')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user:id,name')
                ->take(5)
                ->get();
        });

        $videoTopUsers = Cache::remember('top_users_video', 600, function () {
            return Video::selectRaw('user_id, COUNT(*) as total')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user:id,name')
                ->take(5)
                ->get();
        });

        $fileTopUsers = Cache::remember('top_users_file', 600, function () {
            return File::selectRaw('user_id, COUNT(*) as total')
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user:id,name')
                ->take(5)
                ->get();
        });

        return view('swiftfox.main', compact(
            'user',
            'bulletin',
            'userCount',
            'postCount',
            'articleCount',
            'workCount',
            'opinionCount',
            'noteCount',
            'videoCount',
            'postTopUsers',
            'articleTopUsers',
            'workTopUsers',
            'opinionTopUsers',
            'videoTopUsers',
            'fileTopUsers'
        ));
    }

}
