<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Note;
use App\Services\NoteService;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function __construct(
        protected NoteService $noteService
    ) {}

    public function index()
    {
        $notes = $this->noteService->getNotes();
        $user = Auth::user();
        $totalPosts = $user->posts->count();
        $totalNotes = $user->notes->count();

        return view('swiftfox.home.index', compact('notes', 'totalPosts', 'totalNotes', 'user'));
    }

    public function create()
    {
        return view('swiftfox.home.create');
    }

    public function store(StoreNoteRequest $request)
    {
        $validatedData = $request->validated();

        $this->noteService->createNote($validatedData);

        return redirect()
            ->route('home.index')
            ->with('success', '日記已創建成功！');
    }

    public function show(int $id)
    {
        $note = $this->noteService->getNoteById($id);

        return view('swiftfox.home.show', compact('note'));
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);

        $this->noteService->deleteNote($note);

        return redirect()
            ->route('home.index')
            ->with('success', '日記已成功刪除！');
    }
}
