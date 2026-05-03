<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Work;

class WorkPolicy
{
    public function delete(User $user, Work $work): bool
    {
        return $user->id === $work->user_id || $user->administration === 5;
    }
}
