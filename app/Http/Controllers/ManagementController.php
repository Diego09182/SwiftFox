<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bulletin;
use App\Models\Club;
use App\Models\Opinion;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
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

        $users = User::paginate(8);
        $posts = Post::orderBy('id', 'desc')->paginate(9);
        $articles = Article::orderBy('id', 'desc')->paginate(6);
        $opinions = Opinion::orderBy('id', 'desc')->paginate(3);
        $reports = Report::orderBy('id', 'desc')->paginate(4);
        $clubs = Club::orderBy('id', 'desc')->paginate(9);
        $works = Work::orderBy('id', 'desc')->paginate(6);
        $bulletin = Bulletin::orderBy('id', 'desc')->first();

        return view('swiftfox.management.index', compact(
            'users', 'posts', 'articles', 'opinions', 'reports', 'clubs', 'works', 'bulletin'
        ));
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

        $posts = Post::orderBy('id', 'desc')->paginate(9);

        return view('swiftfox.management.posts', compact('posts'));
    }

    public function articles()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $articles = Article::orderBy('id', 'desc')->paginate(6);

        return view('swiftfox.management.articles', compact('articles'));
    }

    public function opinions()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $opinions = Opinion::orderBy('id', 'desc')->paginate(3);

        return view('swiftfox.management.opinions', compact('opinions'));
    }

    public function works()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $works = Work::orderBy('id', 'desc')->paginate(6);

        return view('swiftfox.management.works', compact('works'));
    }

    public function clubs()
    {
        if ($this->checkAdmin()) {
            return $this->checkAdmin();
        }

        $clubs = Club::orderBy('id', 'desc')->paginate(6);

        return view('swiftfox.management.clubs', compact('clubs'));
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
