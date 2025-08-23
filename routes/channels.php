<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
| 這裡註冊你的應用程式可用的所有頻道授權規則。
| 授權回呼會接收目前已驗證的使用者，以及頻道名稱中的參數。
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('public.bulletins', function () {
    return true;
});
