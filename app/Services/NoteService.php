<?php

namespace App\Services;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteService extends AbstractService
{
    protected string $cacheTag = 'notes';

    protected function getModelClass(): string
    {
        return Note::class;
    }

    public function getNotes(int $perPage = 4)
    {
        $page = request('page', 1);
        $key = $this->cacheKey("index_page_{$page}");

        return $this->rememberEmpty($key, 600, fn () => Note::latest()->paginate($perPage));
    }

    public function getNoteById(int $id)
    {
        $key = $this->cacheKey("show_{$id}");

        return $this->rememberEmpty($key, 600, fn () => Note::findOrFail($id));
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
        $this->clearCache($note->id);
    }

    public function clearCache(?int $id = null): void
    {
        if ($id) {
            $this->flushCache($this->cacheKey("show_{$id}"));
        }
        $this->flushCache();
    }
}
