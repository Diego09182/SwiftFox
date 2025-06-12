<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
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

        $posts = $this->postService->getPostsByFilter($filter, $page);

        return view('swiftfox.forum.filter', compact('posts', 'filter'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);

        $posts = $this->postService->searchPosts($search, $page);

        return view('swiftfox.forum.search', compact('posts', 'search'));
    }

    public function like(Post $post)
    {
        try {
            $post = $this->postService->likePost($post);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'like' => $post->like,
                'dislike' => $post->dislike,
            ], 403);
        }

        return response()->json([
            'like' => $post->like,
            'dislike' => $post->dislike,
        ]);
    }

    public function dislike(Post $post)
    {
        try {
            $post = $this->postService->dislikePost($post);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'like' => $post->like,
                'dislike' => $post->dislike,
            ], 403);
        }

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

        $top_posts_limit = 3;

        $posts = $this->postService->getPostsByPage($page);

        $top_posts = $this->postService->getWeeklyTopPosts($top_posts_limit);

        return view('swiftfox.forum.index', compact('posts','top_posts'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:20',
            'content' => 'required|min:2|max:1000',
            'tag' => 'required|in:學習問題,學習資源,活動宣傳,其他內容',
        ], [
            'title.required' => '標題為必填項目',
            'title.min' => '標題至少需要2個字',
            'title.max' => '標題不能超過20個字',
            'content.required' => '內容為必填項目',
            'content.min' => '內容至少需要2個字',
            'content.max' => '內容不能超過1000個字',
            'tag.required' => '標籤為必填項目',
            'tag.in' => '標籤必須符合選項',
        ]);

        $this->postService->createPost($validatedData);

        return redirect()->route('forum.index')->with('success', '貼文已創建成功！');
    }

    public function show($id)
    {
        $post = $this->postService->getPostById($id);

        $this->postService->incrementPostView($post);

        $comments = $post->comments()->paginate(6);

        $relatedPosts = $this->postService->getRelatedPosts($post);

        return view('swiftfox.forum.show', compact('post', 'comments', 'relatedPosts'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if (Gate::denies('delete-post', $post)) {
            return redirect()->back()->with('error', '您沒有權限刪除此資源');
        }

        $this->postService->deletePost($post);

        return redirect()->route('forum.index')->with('success', '貼文已成功刪除！');
    }
}
