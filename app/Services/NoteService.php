<?php

namespace App\Services;

use App\Models\Note;

class NoteService
{
    public function checkNoteLimit()
    {
        $noteCount = Note::count();
        $maxNoteCount = 500;

        if ($noteCount >= $maxNoteCount) {
            throw new \Exception('日記數量已達到系統限制');
        }
    }
}
