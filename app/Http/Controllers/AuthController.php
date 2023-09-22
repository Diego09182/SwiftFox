<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // 處理註冊請求
    public function register(Request $request)
    {
        // 驗證使用者輸入
        $validatedData = $request->validate([
            'account' => 'required|string|min:5|max:8|unique:users',
            'password' => 'required|string|min:8|max:15',
            'name' => 'required|string|min:1|max:8',
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
            'name.min' => '帳號長度不能少於1個字',
            'name.max' => '帳號長度不能超過8個字',
            'email.required' => '請填寫郵箱',
            'email.email' => '請填寫有效的郵箱地址',
            'email.unique' => '該郵箱已經被使用',
            'cellphone.required' => '請填寫手機號碼',
            'cellphone.digits' => '手機號碼必須是10位數字',
            'cellphone.unique' => '該手機號碼已經被使用',
            'birthday.required' => '請填寫生日',
        ]);
        
        // 建立使用者並將密碼哈希化
        $user = User::create([
            'account' => $validatedData['account'],
            'password' => Hash::make($validatedData['password']),
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'cellphone' => $validatedData['cellphone'],
            'birthday' => $validatedData['birthday'],
            'ip_address' => $request->ip(),
        ]);

        // 登入使用者
        Auth::login($user);

        // 註冊成功後的重新導向
        return redirect('/swiftfox/main')->with('success', '註冊成功！');
    }

    // 處理登入請求
    public function login(Request $request)
    {
        // 驗證使用者提供的憑證
        $credentials = $request->only('account', 'password');

        if (Auth::attempt($credentials)) {
            // 登入成功
            return redirect('/swiftfox/main')->with('success', '登入成功');
        } else {
            // 登入失敗
            return back()->with('error', '登入失敗，請檢查帳號與密碼');
        }
    }

    // 處理登出請求
    public function logout()
    {
        Auth::logout();
        return redirect('/swiftfox/welcome')->with('success', '登出成功');
    }
}
