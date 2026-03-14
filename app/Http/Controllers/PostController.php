<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Services\PostService;
use DomainException;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getPostsByPage();
        $top_posts = $this->postService->getWeeklyTopPosts(3);

        return view('swiftfox.post.index', compact('posts', 'top_posts'));
    }

    public function filter(?string $filter = null)
    {
        $posts = $this->postService->getPostsByFilter($filter);

        return view('swiftfox.post.filter', compact('posts', 'filter'));
    }

    public function search(?string $keyword = null)
    {
        $posts = $this->postService->searchPosts($keyword);

        return view('swiftfox.post.search', compact('posts', 'keyword'));
    }

    public function show(int $id)
    {
        $post = $this->postService->viewPost($id);
        $comments = $post->comments()->paginate(6);
        $relatedPosts = $this->postService->getRelatedPosts($post);

        return view('swiftfox.post.show', compact('post', 'comments', 'relatedPosts'));
    }

    public function create()
    {
        return view('swiftfox.post.create');
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        $this->postService->createPost($data, Auth::user());

        return redirect()
            ->route('forum.index')
            ->with('success', '貼文已創建成功！');
    }

    public function like(Post $post)
    {
        try {
            $post = $this->postService->like($post, Auth::user());

            return response()->json([
                'like' => $post->like,
                'dislike' => $post->dislike,
            ]);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function dislike(Post $post)
    {
        try {
            $post = $this->postService->dislike($post, Auth::user());

            return response()->json([
                'like' => $post->like,
                'dislike' => $post->dislike,
            ]);
        } catch (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        }
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        try {
            $this->postService->deletePost($post, Auth::user());

            return redirect()
                ->route('forum.index')
                ->with('success', '貼文已成功刪除！');
        } catch (DomainException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
