<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function register(RegisterRequest $request)
    {
        $user = $this->authService->registerUser($request->validated(), $request);

        if ($user) {
            Auth::login($user);

            return redirect()->route('main')->with('success', '註冊成功！');
        }

        return back()->with('error', '註冊失敗，請稍後再試');
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->loginUser($request->validated());

        if ($result['success']) {
            return redirect()->route('main')->with('success', $result['message']);
        }

        return redirect()->route('welcome')->with('error', $result['message']);
    }

    public function logout()
    {
        $result = $this->authService->logoutUser();

        if ($result['success']) {
            return redirect()->route('welcome')->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
