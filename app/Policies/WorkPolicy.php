<?php

namespace App\Policies;

use App\Models\Work;
use App\Models\User;

class WorkPolicy
{
    public function delete(User $user, Work $work): bool
    {
        return $user->id === $work->user_id || $user->administration === 5;
    }
}
