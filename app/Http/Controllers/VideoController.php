<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideo;
use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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

        $videos = Cache::tags(['videos'])->remember("videos_index_page_{$page}", 600, function () {
            return Video::orderBy('id', 'desc')->paginate(6);
        });

        return view('swiftfox.video.index', compact('videos', 'user'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $video = Cache::tags(['videos'])->remember("video_{$id}", 600, function () use ($id) {
            return Video::findOrFail($id);
        });

        return view('swiftfox.video.show', compact('video', 'user'));
    }

    public function create()
    {
        return view('swiftfox.video.create');
    }

    public function store(Request $request)
    {
        try {
            $this->videoService->checkVideoLimit();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

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

        $uploadedFile = $request->file('video');
        $filename = time().'_'.mt_rand().'.'.$uploadedFile->getClientOriginalExtension();
        $path = $uploadedFile->storeAs('videos', $filename, 'public');

        $video = new Video;
        $video->title = $request->title;
        $video->content = $request->content;
        $video->filename = $filename;
        $video->path = $path;
        $video->user_id = Auth::id();
        $video->save();

        ProcessVideo::dispatch($video);

        $this->clearCache();

        return redirect()->route('video.index')->with('success', '影片發布成功！');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        if (Gate::denies('delete-video', $video)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        Storage::delete('public/videos/'.$video->filename);

        $video->delete();

        $this->clearCache($id);

        return redirect()->route('video.index')->with('success', '影片刪除成功！');
    }

    private function clearCache($videoId = null)
    {
        Cache::tags(['videos'])->flush();

        if ($videoId) {
            Cache::tags(['videos'])->forget("video_{$videoId}");
        }
    }
}
