<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;

class ActivityPolicy
{
    public function delete(User $user, Activity $activity): bool
    {
        return $user->id === $activity->user_id || $user->administration === 5;
    }
}
