<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Video;
use App\Services\VideoService;
use App\Jobs\ProcessVideo;

class VideoController extends Controller
{
    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    // 顯示所有影片
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->input('page', 1);

        // 使用快取來儲存影片列表
        $videos = Cache::tags(['videos'])->remember("videos_index_page_{$page}", 600, function() {
            return Video::orderBy('id', 'desc')->paginate(6);
        });

        return view('swiftfox.video.index', compact('videos', 'user'));
    }

    // 顯示單個影片
    public function show($id)
    {
        $user = Auth::user();

        // 使用快取來儲存單個影片的詳細信息
        $video = Cache::tags(['videos'])->remember("video_show_{$id}", 600, function() use ($id) {
            return Video::findOrFail($id);
        });

        return view('swiftfox.video.show', compact('video', 'user'));
    }

    // 顯示發布影片頁面
    public function create()
    {
        return view('swiftfox.video.create');
    }

    // 發布影片
    public function store(Request $request)
    {
        // 檢查影片數量限制
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

        // 取得上傳的檔案
        $uploadedFile = $request->file('video');
        $filename = time() . '_' . mt_rand() . '.' . $uploadedFile->getClientOriginalExtension();
        $path = $uploadedFile->storeAs('videos', $filename, 'public');

        // 建立影片
        $video = new Video();
        $video->title = $request->title;
        $video->content = $request->content;
        $video->filename = $filename;
        $video->path = $path;
        $video->user_id = Auth::id();
        $video->save();

        // 處理影片的任務
        ProcessVideo::dispatch($video);

        // 清除相關快取
        $this->clearCache();

        return redirect()->route('video.index')->with('success', '影片發布成功！');
    }

    // 刪除影片
    public function destroy($id)
    {
        // 查找影片
        $video = Video::findOrFail($id);

        // 檢查影片是否屬於當前用戶或用戶具有管理權限
        if ($video->user_id != Auth::id() && Auth::user()->administration != 5) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        // 刪除影片檔案
        Storage::delete('public/videos/' . $video->filename);

        // 刪除資料庫中的影片記錄
        $video->delete();

        // 清除相關快取
        $this->clearCache($id);

        // 重定向到影片列表頁，並顯示成功消息
        return redirect()->route('video.index')->with('success', '影片刪除成功！');
    }

    // 清除所有快取
    private function clearCache($videoId = null)
    {
        // 清除所有影片列表的快取
        Cache::tags(['videos'])->flush();

        // 清除特定影片的快取
        if ($videoId) {
            Cache::tags(['videos'])->forget("video_show_{$videoId}");
        }
    }
}