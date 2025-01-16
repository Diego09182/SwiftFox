<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'account' => 'required|string|min:5|max:8|unique:users',
            'password' => 'required|string|min:8|max:15',
            'name' => 'required|string|max:8',
            'email' => 'required|email|unique:users',
            'cellphone' => 'required|unique:users|digits:10',
            'birthday' => 'required|date_format:Y-m-d',
        ], [
            'account.required' => '請填寫帳號',
            'account.string' => '帳號必須是字串',
            'account.min' => '帳號長度不能少於5個字',
            'account.max' => '帳號長度不能超過8個字',
            'account.unique' => '該帳號已經被使用',
            'password.required' => '請填寫密碼',
            'password.string' => '密碼必須是字串',
            'password.min' => '密碼長度不能少於8個字',
            'password.max' => '密碼長度不能超過15個字',
            'name.required' => '請填寫姓名',
            'name.max' => '姓名長度不能超過8個字',
            'email.required' => '請填寫信箱',
            'email.email' => '請填寫有效的信箱地址',
            'email.unique' => '該信箱已經被使用',
            'cellphone.required' => '請填寫手機號碼',
            'cellphone.digits' => '手機號碼必須是10位數字',
            'cellphone.unique' => '該手機號碼已經被使用',
            'birthday.required' => '請填寫生日',
        ]);

        $user = $this->authService->registerUser($validatedData, $request);

        if ($user) {
            Auth::login($user);

            return redirect()->route('main')->with('success', '註冊成功！');
        } else {
            return back()->with('error', '註冊失敗，請稍後再試');
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('account', 'password');

        $result = $this->authService->loginUser($credentials);

        if ($result['success']) {
            return redirect()->route('main')->with('success', $result['message']);
        } else {
            return redirect()->route('welcome')->with('error', $result['message']);
        }
    }

    public function logout()
    {
        $result = $this->authService->logoutUser();

        if ($result['success']) {
            return redirect()->route('welcome')->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
}
