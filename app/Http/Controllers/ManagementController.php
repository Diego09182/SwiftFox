<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Club;
use App\Models\File;
use App\Models\Opinion;
use App\Models\Post;
use App\Models\Prize;
use App\Models\PrizeRedemption;
use App\Models\Report;
use App\Models\User;
use App\Models\Video;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementController extends Controller
{
    private function checkAdmin()
    {
        $user = Auth::user();

        if ($user->administration != 5) {
            Auth::logout();

            return redirect()->route('welcome')->with('error', '權限不足，無法進入後台');
        }
    }

    public function index()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        return view('swiftfox.management.index');
    }

    public function user()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $users = User::paginate(8);

        return view('swiftfox.management.users', compact('users'));
    }

    public function reports()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $reports = Report::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.reports', compact('reports'));
    }

    public function posts()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $posts = Post::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.posts', compact('posts'));
    }

    public function articles()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $articles = Article::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.articles', compact('articles'));
    }

    public function opinions()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $opinions = Opinion::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.opinions', compact('opinions'));
    }

    public function works()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $works = Work::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.works', compact('works'));
    }

    public function clubs()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $clubs = Club::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.clubs', compact('clubs'));
    }

    public function videos()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $videos = Video::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.videos', compact('videos'));
    }

    public function files()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $files = File::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.files', compact('files'));
    }

    public function prizeRedemptions()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $redemptions = PrizeRedemption::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.prizeRedemptions', compact('redemptions'));
    }

    public function prizes()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $prizes = Prize::orderBy('id', 'desc')->paginate(8);

        return view('swiftfox.management.prizes', compact('prizes'));
    }

    public function update(Request $request, User $user)
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $validatedData = $request->validate([
            'administration' => 'required|integer|min:1|max:5',
            'status' => 'required|integer|in:0,1',
        ]);

        $user->update($validatedData);

        return redirect()->route('management.index')->with('success', '使用者權限和停用狀態已成功更新');
    }
}
