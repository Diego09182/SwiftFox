<?php

namespace App\Http\Controllers;

use App\Models\PrizeRedemption;
use App\Services\ProfileService;
use Illuminate\Http\Request;

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

    public function redemptions()
    {
        $user = $this->profileService->getUser();

        $redemptions = PrizeRedemption::with('prize')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        return view('swiftfox.profile.redemptions', compact('user', 'redemptions'));
    }

    public function update(Request $request)
    {
        $this->profileService->updateUser($request);

        return redirect()->route('profile.index')->with('success', '使用者資料已更新');
    }
}
