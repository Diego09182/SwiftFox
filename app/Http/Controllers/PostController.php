<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function filter(Request $request)
    {
        $filter = $request->input('filter');
        $page = $request->input('page', 1);
        $cacheKey = 'posts_filter_'.$filter.'_page_'.$page;

        $posts = Cache::tags(['posts', 'filter_'.$filter])->remember($cacheKey, 600, function () use ($filter) {
            return match ($filter) {
                '觀看次數' => Post::orderBy('view', 'desc')->paginate(9),
                '喜歡次數' => Post::orderBy('like', 'desc')->paginate(9),
                default => Post::orderBy('id', 'desc')->paginate(9),
            };
        });

        return view('swiftfox.forum.filter', compact('posts', 'filter'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $cacheKey = 'posts_search_'.md5($search).'_page_'.$page;

        $posts = Cache::tags(['posts', 'search'])->remember($cacheKey, 600, function () use ($search) {
            if (empty($search)) {
                return Post::latest()->paginate(9);
            }

            return Post::where('title', 'LIKE', "%$search%")
                ->orWhere('content', 'LIKE', "%$search%")
                ->orWhere('tag', 'LIKE', "%$search%")
                ->paginate(9);
        });

        return view('swiftfox.forum.search', compact('posts', 'search'));
    }

    public function like(Post $post)
    {
        $user = Auth::user();

        $evaluation = Evaluation::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($evaluation) {
            return response()->json([
                'message' => '已經評價過了',
                'like' => $post->like,
                'dislike' => $post->dislike,
            ], 403);
        }

        Evaluation::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'evaluation' => 1,
        ]);

        $post->increment('like');

        $this->clearPostCache($post->id);

        return response()->json([
            'like' => $post->like,
            'dislike' => $post->dislike,
        ]);
    }

    public function dislike(Post $post)
    {
        $user = Auth::user();

        $evaluation = Evaluation::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($evaluation) {
            return response()->json([
                'message' => '已經評價過了',
                'like' => $post->like,
                'dislike' => $post->dislike,
            ], 403);
        }

        Evaluation::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'evaluation' => -1,
        ]);

        $post->increment('dislike');

        $this->clearPostCache($post->id);

        return response()->json([
            'like' => $post->like,
            'dislike' => $post->dislike,
        ]);
    }

    public function create()
    {
        return view('swiftfox.forum.create');
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $cacheKey = 'posts_index_page_'.$page;

        $posts = Cache::tags(['posts'])->remember($cacheKey, 600, function () {
            return Post::orderBy('id', 'desc')->paginate(9);
        });

        return view('swiftfox.forum.index', compact('posts'));
    }

    public function store(Request $request)
    {
        try {
            $this->postService->checkPostLimit();
        } catch (\Exception $e) {
            return redirect()->route('forum.index')->with('error', $e->getMessage());
        }

        $validatedData = $request->validate([
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:2|max:60',
            'tag' => 'required|in:學科問題,社團問題,自主學習,大學面試,活動宣傳',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過20個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過60個字',
            'tag.required' => '標籤為必填項目',
            'tag.in' => '標籤必須符合選項',
        ]);

        $post = new Post($validatedData);
        $post->content = nl2br($validatedData['content']);
        $post->user_id = Auth::id();
        $post->save();

        $this->clearCache();

        return redirect()->route('forum.index')->with('success', '貼文已創建成功！');
    }

    public function show($id)
    {
        $post = Cache::tags(['posts'])->remember("post_{$id}", 600, function () use ($id) {
            return Post::with('comments')->findOrFail($id);
        });

        $comments = $post->comments()->paginate(6);

        $post->increment('view');

        $this->clearPostCache($post->id);

        return view('swiftfox.forum.show', compact('post', 'comments'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Gate::denies('delete-post', $post)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $post->delete();

        $this->clearCache();

        return redirect()->route('forum.index')->with('success', '貼文已成功刪除！');
    }

    private function clearCache()
    {
        Cache::tags(['posts'])->flush();
    }

    private function clearPostCache($postId)
    {
        Cache::tags(['posts'])->forget("post_{$postId}");
    }
}
