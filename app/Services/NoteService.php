<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class NoteService
{
    protected string $cacheTag = 'notes';

    public function getNotes()
    {
        $page = request('page', 1);

        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("index_page_{$page}"), 600, fn () => Note::latest()->paginate(4));
    }

    public function getNoteById(int $id)
    {
        return Cache::tags([$this->cacheTag])
            ->remember($this->cacheKey("show_{$id}"), 600, fn () => Note::findOrFail($id));
    }

    public function createNote(array $data)
    {
        $data['user_id'] = Auth::id();
        $data['content'] = nl2br($data['content'] ?? '');
        $note = Note::create($data);
        $this->clearCache();

        return $note->fresh();
    }

    public function deleteNote(Note $note): void
    {
        $note->delete();
        $this->clearCache();
    }

    protected function cacheKey(string $key): string
    {
        return "{$this->cacheTag}_{$key}";
    }

    protected function clearCache(): void
    {
        Cache::tags([$this->cacheTag])->flush();
    }
}
