<?php

namespace App\Policies;

use App\Models\Club;
use App\Models\User;

class ClubPolicy
{
    public function delete(User $user, Club $club): bool
    {
        return $user->id === $club->user_id || $user->administration === 5;
    }
}
