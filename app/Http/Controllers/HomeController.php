<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\File;
use App\Models\Opinion;
use App\Models\Post;
use App\Models\Video;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function posts()
    {
        $posts = Post::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('swiftfox.home.posts', compact('posts'));
    }

    public function articles()
    {
        $articles = Article::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('swiftfox.home.articles', compact('articles'));
    }

    public function opinions()
    {
        $opinions = Opinion::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('swiftfox.home.opinions', compact('opinions'));
    }

    public function works()
    {
        $works = Work::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('swiftfox.home.works', compact('works'));
    }

    public function videos()
    {
        $videos = Video::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('swiftfox.home.videos', compact('videos'));
    }

    public function files()
    {
        $files = File::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('swiftfox.home.files', compact('files'));
    }
}
