<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // 獲取使用者訊息
        $user = Auth::user();

        // 返回文章列表，並將分頁結果傳遞到視圖
        return view('swiftfox.profile.index', ['user' => $user]);
    }

    public function update(Request $request)
    {
        // 驗證表單數據
        $validatedData = $request->validate([
            'new_password' => 'nullable|string|min:8|max:15|confirmed|different:password',
            'name' => 'required|string|min:1|max:8',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'cellphone' => 'required|digits:10|unique:users,cellphone,'.Auth::user()->id,
            'birthday' => 'required|date_format:Y-m-d',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'info' => 'nullable|string',
            'interest' => 'nullable|string',
            'club' => 'nullable|string',
            'url' => 'nullable|string',
        ], [
            'new_password.string' => '新密碼必須是字串',
            'new_password.min' => '新密碼長度不能少於8個字',
            'new_password.max' => '新密碼長度不能超過15個字',
            'new_password.confirmed' => '新密碼和確認密碼不匹配',
            'new_password.different' => '新密碼不能與舊密碼相同',
            'name.required' => '請填寫姓名',
            'name.string' => '姓名必須是字串',
            'name.min' => '姓名長度不能少於1個字',
            'name.max' => '姓名長度不能超過8個字',
            'email.required' => '請填寫郵箱',
            'email.email' => '請填寫有效的郵箱地址',
            'email.unique' => '該郵箱已經被使用',
            'cellphone.required' => '請填寫手機號碼',
            'cellphone.digits' => '手機號碼必須是10位數字',
            'cellphone.unique' => '該手機號碼已經被使用',
            'birthday.required' => '請填寫生日',
            'birthday.date_format' => '生日必須符合格式',
            'avatar.image' => '上傳的檔案必須是圖片',
            'avatar.mimes' => '上傳的圖片格式必須為jpeg, png, jpg, gif',
            'avatar.max' => '上傳的圖片大小不能超過2048KB',
        ]);

        // 獲取使用者實例
        $user = Auth::user();

        // 更新使用者數據
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->cellphone = $validatedData['cellphone'];
        $user->birthday = $validatedData['birthday'];

        // 如果有新密碼，更新密碼
        if (!empty($validatedData['new_password'])) {
            $user->password = bcrypt($validatedData['new_password']);
        }

        // 如果有上傳頭像，處理上傳
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_filename = time() . '_' . mt_rand() . '.' . $avatar->getClientOriginalExtension();
            $avatar_path = $avatar->storeAs('avatars', $avatar_filename, 'public');
            $user->avatar_filename = $avatar_filename;
            $user->avatar_path = $avatar_path;
        }

        // 更新其他信息
        $user->info = $request->input('info');
        $user->interest = $request->input('interest');
        $user->club = $request->input('club');
        $user->url = $request->input('url');

        // 保存使用者數據
        $user->save();
        
        // 重定向到使用者資料頁面或其他頁面
        return redirect()->route('profile.index')->with('success', '使用者資料已更新');
    }

}
