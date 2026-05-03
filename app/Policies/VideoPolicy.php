<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;

class VideoPolicy
{
    public function delete(User $user, Video $video): bool
    {
        return $user->id === $video->user_id || $user->administration === 5;
    }
}
