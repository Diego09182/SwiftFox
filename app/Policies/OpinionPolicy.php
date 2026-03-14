<?php

namespace App\Policies;

use App\Models\Opinion;
use App\Models\User;

class OpinionPolicy
{
    public function delete(User $user, Opinion $opinion): bool
    {
        return $user->id === $opinion->user_id || $user->administration === 5;
    }
}
