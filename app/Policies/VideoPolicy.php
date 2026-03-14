<?php

namespace App\Policies;

use App\Models\Video;
use App\Models\User;

class VideoPolicy
{
    public function delete(User $user, Video $video): bool
    {
        return $user->id === $video->user_id || $user->administration === 5;
    }
}
