<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;

class NotePolicy
{
    public function delete(User $user, Note $note): bool
    {
        return $user->id === $note->user_id || $user->administration === 5;
    }
}
