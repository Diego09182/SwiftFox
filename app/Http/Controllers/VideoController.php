<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Notifications\ResourceNotification;
use App\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $videos = $this->videoService->getVideosByPage($page);

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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:2|max:50',
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:51200',
        ], [
            'title.required' => '影片標題為必填',
            'content.required' => '影片內容為必填',
            'video.required' => '影片檔案必須上傳',
        ]);

        $video = $request->file('video');

        $filename = time().'_'.uniqid().'.'.$video->getClientOriginalExtension();

        $path = $video->storeAs('videos', $filename, 'public');

        Video::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'filename' => $filename,
            'path' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('video.index')->with('success', '影片上傳成功');
    }

    public function destroy($id)
    {
        $video = $this->videoService->getVideoById($id);

        if (Gate::denies('delete-video', $video)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $user = $video->user;

        $currentUser = Auth::user();

        if ($currentUser->administration == 5) {
            $user->notify(new ResourceNotification(
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
