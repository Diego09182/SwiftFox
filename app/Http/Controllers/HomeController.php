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
    protected int $perPage = 8;

    protected function getUserResources(string $modelClass)
    {
        return $modelClass::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);
    }

    public function posts()
    {
        $posts = $this->getUserResources(Post::class);

        return view('swiftfox.home.posts', compact('posts'));
    }

    public function articles()
    {
        $articles = $this->getUserResources(Article::class);

        return view('swiftfox.home.articles', compact('articles'));
    }

    public function opinions()
    {
        $opinions = $this->getUserResources(Opinion::class);

        return view('swiftfox.home.opinions', compact('opinions'));
    }

    public function works()
    {
        $works = $this->getUserResources(Work::class);

        return view('swiftfox.home.works', compact('works'));
    }

    public function videos()
    {
        $videos = $this->getUserResources(Video::class);

        return view('swiftfox.home.videos', compact('videos'));
    }

    public function files()
    {
        $files = $this->getUserResources(File::class);

        return view('swiftfox.home.files', compact('files'));
    }
}
