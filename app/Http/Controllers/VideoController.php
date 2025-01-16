<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideo;
use App\Models\Video;
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
        $user = Auth::user();
        $page = $request->input('page', 1);
        $videos = $this->videoService->getVideosByPage($page);

        return view('swiftfox.video.index', compact('videos', 'user'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $video = $this->videoService->getVideoById($id);

        return view('swiftfox.video.show', compact('video', 'user'));
    }

    public function create()
    {
        return view('swiftfox.video.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'video' => 'required|mimes:mp4,mov,ogg,qt|max:204800',
        ], [
            'title.required' => '標題為必填欄位。',
            'content.required' => '內容為必填欄位。',
            'video.required' => '請選擇一個影片檔案。',
            'video.mimes' => '影片格式必須為 mp4、mov、ogg 或 qt。',
            'video.max' => '影片大小不能超過200MB。',
        ]);

        $videoData = $this->videoService->storeVideo($request);

        $video = new Video;
        $video->title = $request->title;
        $video->content = $request->content;
        $video->filename = $videoData['filename'];
        $video->path = $videoData['path'];
        $video->user_id = Auth::id();
        $video->save();

        ProcessVideo::dispatch($video);

        $this->videoService->clearCache();

        return redirect()->route('video.index')->with('success', '影片發布成功！');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        if (Gate::denies('delete-video', $video)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->videoService->deleteVideo($video);

        $this->videoService->clearCache($id);

        return redirect()->route('video.index')->with('success', '影片刪除成功！');
    }
}
