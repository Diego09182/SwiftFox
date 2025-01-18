<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Services\NoteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $notes = $this->noteService->getNotesByPage($page);
        $user = Auth::user();
        $totalPosts = $user->posts->count();
        $totalNotes = $user->notes->count();

        return view('swiftfox.home.index', compact('user', 'totalPosts', 'totalNotes', 'notes'));
    }

    public function store(Request $request)
    {
        try {
            $this->noteService->checkNoteLimit();
        } catch (\Exception $e) {
            return redirect()->route('home.index')->with('error', $e->getMessage());
        }

        $validatedData = $request->validate([
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:2|max:50',
            'tag' => 'max:4',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過20個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',
            'tag.max' => '標籤不能超過4個字',
        ]);

        $this->noteService->createNote($validatedData);

        return redirect()->route('home.index')->with('success', '日記已創建成功！');
    }

    public function show($id)
    {
        $note = $this->noteService->getNoteById($id);

        $user = Auth::user();

        return view('swiftfox.home.show', compact('note', 'user'));
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);

        if (Gate::denies('delete-note', $note)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->noteService->deleteNote($note);

        return redirect()->route('home.index')->with('success', '日記已成功刪除！');
    }
}
