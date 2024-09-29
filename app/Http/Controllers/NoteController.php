<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Note;
use App\Services\NoteService;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    // 顯示所有日記
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $cacheKey = 'notes_index_page_' . $page;

        // 使用 Redis Tags 優化日記快取
        $notes = Cache::tags(['notes'])->remember($cacheKey, 600, function() {
            return Note::orderBy('id', 'desc')->paginate(4);
        });

        $user = Auth::user();
        $totalPosts = $user->posts->count();
        $totalNotes = $user->notes->count();

        return view('swiftfox.home.index', compact('user', 'totalPosts', 'totalNotes', 'notes'));
    }

    // 儲存新日記
    public function store(Request $request)
    {
        try {
            $this->noteService->checkNoteLimit();
        } catch (\Exception $e) {
            return redirect()->route('home.index')->with('error', $e->getMessage());
        }

        $validatedData = $request->validate([
            'title' => 'required|min:2|max:10',
            'content' => 'required|min:2|max:50',
            'tag' => 'max:4',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過10個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過50個字',
            'tag.max' => '標籤不能超過4個字',
        ]);

        $note = new Note($validatedData);
        $note->content = nl2br($validatedData['content']);
        $note->user_id = auth()->user()->id;
        $note->save();

        // 清除日記相關的快取
        $this->clearCache();

        return redirect()->route('home.index')->with('success', '日記已創建成功！');
    }

    // 顯示日記
    public function show($id)
    {
        $cacheKey = 'note_show_' . $id;

        // 使用快取存儲特定日記
        $note = Cache::tags(['notes'])->remember($cacheKey, 600, function() use ($id) {
            return Note::findOrFail($id);
        });

        $user = Auth::user();
        return view('swiftfox.home.show', compact('note', 'user'));
    }

    // 刪除日記
    public function destroy($id)
    {
        $note = Note::findOrFail($id);

        if ($note->user_id != Auth::id() && Auth::user()->administration != 5) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $note->delete();

        // 清除日記相關的快取
        $this->clearCache();

        return redirect()->route('home.index')->with('success', '日記已成功刪除！');
    }

    // 清除所有相關快取
    private function clearCache()
    {
        Cache::tags(['notes'])->flush();
    }
}