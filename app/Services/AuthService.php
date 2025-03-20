<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Note;
use App\Models\Opinion;
use App\Models\Post;
use App\Models\User;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser(array $validatedData, $request)
    {
        $user = User::create([
            'account' => $validatedData['account'],
            'password' => Hash::make($validatedData['password']),
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'cellphone' => $validatedData['cellphone'],
            'birthday' => $validatedData['birthday'],
            'ip_address' => $request->ip(),
        ]);

        return $user;
    }

    public function loginUser(array $credentials)
    {
        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->status == 0) {
                Auth::logout();
                return ['success' => false, 'message' => '登入失敗，帳號被停用'];
            }

            $userCount = User::count();
            $postCount = Post::count();
            $articleCount = Article::count();
            $workCount = Work::count();
            $opinionCount = Opinion::count();
            $noteCount = Note::count();

            session([
                'userCount' => $userCount,
                'postCount' => $postCount,
                'articleCount' => $articleCount,
                'workCount' => $workCount,
                'opinionCount' => $opinionCount,
                'noteCount' => $noteCount,
            ]);

            $user->increment('times');

            return ['success' => true, 'message' => '登入成功'];
        } else {
            return ['success' => false, 'message' => '登入失敗，請檢查帳號與密碼'];
        }
    }

    public function logoutUser()
    {
        Auth::logout();

        return ['success' => true, 'message' => '登出成功'];
    }
}
