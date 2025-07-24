<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function like(File $file)
    {
        try {
            $file = $this->fileService->likeFile($file);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'like' => $file->like,
                'dislike' => $file->dislike,
            ], 403);
        }

        return response()->json([
            'like' => $file->like,
            'dislike' => $file->dislike,
        ]);
    }

    public function dislike(File $file)
    {
        try {
            $file = $this->fileService->dislikeFile($file);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'like' => $file->like,
                'dislike' => $file->dislike,
            ], 403);
        }

        return response()->json([
            'like' => $file->like,
            'dislike' => $file->dislike,
        ]);
    }

    public function index()
    {
        $files = $this->fileService->getFilesByPage(6);

        return view('swiftfox.file.index', compact('files'));
    }

    public function create()
    {
        return view('swiftfox.file.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|min:2|max:20',
            'content' => 'nullable|string',
            'file' => 'required|file|max:20480|mimes:jpg,jpeg,png,pdf,docx,xlsx,pptx,txt,csv',
            'donation' => 'nullable|string|max:150',
        ], [
            'title.required' => '標題是必填的。',
            'title.string' => '標題必須是字串。',
            'title.min' => '標題的長度不能少於2個字。',
            'title.max' => '標題的長度不能超過20個字。',
            'content.string' => '內容必須是字串。',
            'file.required' => '檔案是必填的。',
            'file.file' => '檔案必須是一個有效的檔案。',
            'file.max' => '檔案大小不能超過 20480 KB。',
            'file.mimes' => '只允許上傳 JPG、JPEG、PNG、PDF、Word、Excel、PPT、TXT、CSV 檔案。',
            'donation.string' => '贊助資訊必須是字串。',
        ]);

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filename = uniqid().'_'.$uploadedFile->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            $path = $uploadedFile->storeAs('files', $filename, 'public');

            $validatedData['filename'] = $filename;
            $validatedData['path'] = $path;
        }

        $validatedData['user_id'] = Auth::id();

        $this->fileService->createFile($validatedData);

        $user = Auth::user();

        $user->increment('points', 10);

        return redirect()->route('file.index')->with('success', '檔案已成功新增！');
    }

    public function show($id)
    {
        $file = $this->fileService->getFileById($id);

        $file->increment('view');

        return view('swiftfox.file.show', compact('file'));
    }

    public function destroy(File $file)
    {
        if (Gate::denies('delete-file', $file)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->fileService->deleteFile($file);

        return redirect()->route('file.index')->with('success', '檔案已成功刪除！');
    }
}
