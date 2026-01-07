<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        $posts = $this->postService->getPostsByPage($page);
        $top_posts = $this->postService->getWeeklyTopPosts(3);

        return view('swiftfox.post.index', [
            'posts'     => $posts,
            'top_posts' => $top_posts,
        ]);
    }

    public function filter(Request $request)
    {
        $filter = $request->input('filter');
        $page   = $request->input('page', 1);

        $posts = $this->postService->getPostsByFilter($filter, $page);

        return view('swiftfox.post.filter', [
            'posts'  => $posts,
            'filter' => $filter,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $page   = $request->input('page', 1);

        $posts = $this->postService->searchPosts($search, $page);

        return view('swiftfox.post.search', [
            'posts'  => $posts,
            'search' => $search,
        ]);
    }

    public function show(int $id)
    {
        $post = $this->postService->viewPost($id);

        if (!$post) {
            abort(404);
        }

        $comments = $post->comments()->paginate(6);
        $relatedPosts = $this->postService->getRelatedPosts($post);

        return view('swiftfox.post.show', [
            'post'         => $post,
            'comments'     => $comments,
            'relatedPosts' => $relatedPosts,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => 'required|min:2|max:20',
            'content' => 'required|min:2|max:1000',
            'tag'     => 'required|in:學習問題,學習資源,活動宣傳,其他內容',
        ]);

        $this->postService->createPost($data, Auth::user());

        return redirect()
            ->route('forum.index')
            ->with('success', '貼文已創建成功！');
    }

    public function like(Post $post)
    {
        $result = $this->postService->like($post, Auth::user());

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 403);
        }

        return response()->json([
            'like'    => $result['data']->like,
            'dislike' => $result['data']->dislike,
        ]);
    }

    public function dislike(Post $post)
    {
        $result = $this->postService->dislike($post, Auth::user());

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 403);
        }

        return response()->json([
            'like'    => $result['data']->like,
            'dislike' => $result['data']->dislike,
        ]);
    }

    public function destroy(Post $post)
    {
        $result = $this->postService->deletePost($post, Auth::user());

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        return redirect()
            ->route('forum.index')
            ->with('success', '貼文已成功刪除！');
    }
}
