<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(8);

        return view('swiftfox.notifications.index', compact('notifications'));
    }

    public function readAll()
    {
        $user = auth()->user();

        $user->unreadNotifications->markAsRead();

        return back()->with('status', '所有通知已標記為已讀');
    }
}
