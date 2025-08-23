<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessFile;
use App\Models\File;
use App\Notifications\ResourceNotification;
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
        ]);

        $uploadedFile = $request->file('file');
        $filename = uniqid() . '_' . $uploadedFile->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);
        $path = $uploadedFile->storeAs('files', $filename, 'public');

        $validatedData['filename'] = $filename;
        $validatedData['path'] = $path;

        unset($validatedData['file']);

        $userId = Auth::id();

        ProcessFile::dispatch($validatedData, $userId);

        return redirect()->route('file.index')->with('success', '檔案已提交，系統正在處理中。');
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

        $owner = $file->user; // 檔案擁有者
        $admin = Auth::user(); // 當前操作人

        if ($admin->administration == 5) {
            $owner->notify(new ResourceNotification(
                resourceType: 'file',
                resourceId: $file->id,
                title: '檔案已刪除',
                reason: '違反社群規範'
            ));
        }

        $this->fileService->deleteFile($file);

        return redirect()->route('file.index')->with('success', '檔案已成功刪除！');
    }
}
