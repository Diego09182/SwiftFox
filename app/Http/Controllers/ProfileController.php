<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $user = $this->profileService->getUser();

        return view('swiftfox.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $this->profileService->updateUser($request);

        return redirect()->route('profile.index')->with('success', '使用者資料已更新');
    }
}
