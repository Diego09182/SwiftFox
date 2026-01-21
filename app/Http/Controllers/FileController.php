<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Notifications\ResourceNotification;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FileController extends Controller
{
    public function __construct(protected FileService $fileService) {}

    public function like(File $file)
    {
        $result = $this->fileService->likeFile($file);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'like' => $file->like,
            'dislike' => $file->dislike,
        ], $result['success'] ? 200 : 403);
    }

    public function dislike(File $file)
    {
        $result = $this->fileService->dislikeFile($file);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'like' => $file->like,
            'dislike' => $file->dislike,
        ], $result['success'] ? 200 : 403);
    }

    public function index()
    {
        $files = $this->fileService->getFiles();

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

        $this->fileService->createFile($validatedData, $uploadedFile);

        return redirect()->route('file.index')
            ->with('success', '檔案已上傳成功！');
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

        $owner = $file->user;
        $admin = Auth::user();

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
