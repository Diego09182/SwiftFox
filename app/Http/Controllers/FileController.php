<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'file' => 'required|file|mimes:jpg,txt,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filename = time().'_'.$uploadedFile->getClientOriginalName();
            $path = $uploadedFile->storeAs('uploads', $filename, 'public');

            $validated['filename'] = $filename;
            $validated['path'] = $path;
        }

        $validated['user_id'] = Auth::id();

        $this->fileService->createFile($validated);

        return redirect()->route('file.index')->with('success', '檔案已成功新增！');
    }

    public function show($id)
    {
        $file = $this->fileService->getFileById($id);

        return view('swiftfox.file.show', compact('file'));
    }

    public function destroy(File $file)
    {
        $this->fileService->deleteFile($file);

        return redirect()->route('file.index')->with('success', '檔案已成功刪除！');
    }
}
