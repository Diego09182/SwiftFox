<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVideoRequest;
use App\Notifications\ResourceNotification;
use App\Services\VideoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VideoController extends Controller
{
    protected VideoService $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index()
    {
        $videos = $this->videoService->getVideos();

        return view('swiftfox.video.index', compact('videos'));
    }

    public function show($id)
    {
        $video = $this->videoService->getVideoById($id);

        return view('swiftfox.video.show', compact('video'));
    }

    public function create()
    {
        return view('swiftfox.video.create');
    }

    public function store(StoreVideoRequest $request)
    {
        $uploadResult = $this->videoService->createVideo($request->file('video'));

        $videoData = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'filename' => $uploadResult['filename'],
            'path' => $uploadResult['path'],
            'user_id' => Auth::id(),
        ];

        $this->videoService->storeVideoData($videoData);

        return redirect()->route('video.index')->with('success', '影片上傳成功');
    }

    public function destroy($id)
    {
        $video = $this->videoService->getVideoById($id);

        if (Gate::denies('delete-video', $video)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $currentUser = Auth::user();

        if ($currentUser->administration == 5) {
            $video->user->notify(new ResourceNotification(
                resourceType: 'video',
                resourceId: $video->id,
                title: '影片已刪除',
                reason: '違反社群規範'
            ));
        }

        $this->videoService->deleteVideo($video);

        $this->videoService->clearCache($id);

        return redirect()->route('video.index')->with('success', '影片刪除成功！');
    }
}
