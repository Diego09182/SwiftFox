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
    protected string $dashboardCacheKey = 'dashboard_stats';

    protected int $dashboardCacheTTL = 600;

    /**
     * 使用者註冊
     */
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

    /**
     * 使用者登入
     */
    public function loginUser(array $credentials): array
    {
        if (! Auth::attempt($credentials)) {
            return $this->loginFailed('登入失敗，請檢查帳號與密碼');
        }

        /** @var User $user */
        $user = Auth::user();

        if ((int) $user->status === 0) {
            Auth::logout();

            return $this->loginFailed('登入失敗，帳號被停用');
        }

        $this->storeDashboardStatsInSession();
        $this->increaseLoginTimes($user);

        return $this->loginSuccess();
    }

    /**
     * 使用者登出
     */
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

    /**
     * 儲存後台統計資訊到 Session
     */
    protected function storeDashboardStatsInSession(): void
    {
        $stats = Cache::tags(['dashboard'])->remember(
            $this->dashboardCacheKey,
            $this->dashboardCacheTTL,
            fn () => $this->buildDashboardStats()
        );

        session($stats);
    }

    /**
     * 組裝後台統計資料
     */
    protected function buildDashboardStats(): array
    {
        return [
            'userCount' => User::count(),
            'postCount' => Post::count(),
            'articleCount' => Article::count(),
            'workCount' => Work::count(),
            'opinionCount' => Opinion::count(),
            'noteCount' => Note::count(),
        ];
    }

    /**
     * 增加登入次數
     */
    protected function increaseLoginTimes(User $user): void
    {
        $user->increment('times');
    }
}
