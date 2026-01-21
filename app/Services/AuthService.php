<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Note;
use App\Models\Opinion;
use App\Models\Post;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser(array $validatedData, Request $request): User
    {
        return User::create([
            'account' => $validatedData['account'],
            'password' => Hash::make($validatedData['password']),
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'cellphone' => $validatedData['cellphone'],
            'birthday' => $validatedData['birthday'],
            'ip_address' => $request->ip(),
        ]);
    }

    public function loginUser(array $credentials): array
    {
        if (! Auth::attempt($credentials)) {
            return $this->loginFailed('登入失敗，請檢查帳號與密碼');
        }

        $user = Auth::user();

        if ((int) $user->status === 0) {
            Auth::logout();

            return $this->loginFailed('登入失敗，帳號被停用');
        }

        $this->storeDashboardStatsInSession();

        $this->increaseLoginTimes($user);

        return $this->loginSuccess();
    }

    public function logoutUser(): array
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return [
            'success' => true,
            'message' => '登出成功',
        ];
    }

    protected function loginSuccess(): array
    {
        return [
            'success' => true,
            'message' => '登入成功',
        ];
    }

    protected function loginFailed(string $message): array
    {
        return [
            'success' => false,
            'message' => $message,
        ];
    }

    protected function storeDashboardStatsInSession(): void
    {
        $stats = Cache::remember('dashboard_stats', 600, function () {
            return [
                'userCount' => User::count(),
                'postCount' => Post::count(),
                'articleCount' => Article::count(),
                'workCount' => Work::count(),
                'opinionCount' => Opinion::count(),
                'noteCount' => Note::count(),
            ];
        });

        session($stats);
    }

    protected function increaseLoginTimes(User $user): void
    {
        $user->increment('times');
    }
}
