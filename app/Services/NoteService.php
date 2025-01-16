<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class NoteService
{
    public function getNotesByPage(int $page)
    {
        $cacheKey = 'notes_index_page_'.$page;

        return Cache::tags(['notes'])->remember($cacheKey, 600, function () {
            return Note::orderBy('id', 'desc')->paginate(4);
        });
    }

    public function createNote(array $data)
    {
        $data['content'] = nl2br($data['content']);
        $data['user_id'] = Auth::id();

        $note = Note::create($data);

        $this->clearCache();

        return $note;
    }

    public function getNoteById($id)
    {
        $cacheKey = 'note_show_'.$id;

        return Cache::tags(['notes'])->remember($cacheKey, 600, function () use ($id) {
            return Note::findOrFail($id);
        });
    }

    public function deleteNote(Note $note)
    {
        $note->delete();

        $this->clearCache();
    }

    public function checkNoteLimit()
    {
        $user = Auth::user();
        $totalNotes = $user->notes->count();

        if ($totalNotes >= 100) {
            throw new \Exception('您已達到日記的最大限制。');
        }
    }

    private function clearCache()
    {
        Cache::tags(['notes'])->flush();
    }
}
