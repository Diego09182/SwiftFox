<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function getUser()
    {
        return Auth::user();
    }

    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'new_password' => 'nullable|string|min:8|max:15|confirmed|different:password',
            'name' => 'required|string|min:1|max:8',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'cellphone' => 'required|digits:10|unique:users,cellphone,'.$user->id,
            'birthday' => 'required|date_format:Y-m-d',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'info' => 'nullable|string',
            'interest' => 'nullable|string',
            'club' => 'nullable|string',
            'url' => 'nullable|string',
        ]);

        $user->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'cellphone' => $validatedData['cellphone'],
            'birthday' => $validatedData['birthday'],
            'info' => $request->input('info'),
            'interest' => $request->input('interest'),
            'club' => $request->input('club'),
            'url' => $request->input('url'),
        ]);

        if (! empty($validatedData['new_password'])) {
            $user->password = Hash::make($validatedData['new_password']);
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatar_filename = time().'_'.mt_rand().'.'.$avatar->getClientOriginalExtension();
            $avatar_path = $avatar->storeAs('avatars', $avatar_filename, 'public');
            $user->avatar_filename = $avatar_filename;
            $user->avatar_path = $avatar_path;
        }

        $user->save();
    }
}
