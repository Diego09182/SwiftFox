<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Work;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    protected $photoService;

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    public function create($workId)
    {
        $work = Work::with('photos')->findOrFail($workId);
        $user = Auth::user();

        return view('swiftfox.photo.create', compact('work', 'user'));
    }

    public function show($workId, $photoId)
    {
        $work = Work::with('photos')->findOrFail($workId);
        $user = Auth::user();
        $photo = Photo::findOrFail($photoId);
        $photoUrl = Storage::url($photo->path);
        $photos = $work->photos;

        return view('swiftfox.photo.show', compact('work', 'user', 'photo', 'photoUrl', 'photos'));
    }

    public function store(Request $request, $workId)
    {
        try {
            $this->photoService->checkPhotoLimit($workId);
        } catch (\Exception $e) {
            return redirect()->route('work.show', compact('workId'))->with('error', $e->getMessage());
        }

        $photo = $this->photoService->storePhoto($request, $workId);

        return redirect()->route('work.show', ['work' => $workId])->with('success', '相片已添加！');
    }

    public function destroy($workId, $photoId)
    {
        $photo = Photo::findOrFail($photoId);

        if (Gate::denies('delete-photo', $photo)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->photoService->deletePhoto($photo);

        return redirect()->route('work.show', ['work' => $workId])->with('success', '相片已刪除！');
    }
}
