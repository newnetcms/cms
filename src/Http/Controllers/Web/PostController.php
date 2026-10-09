<?php

namespace Newnet\Cms\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Newnet\Cms\Repositories\PostRepository;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(Request $request)
    {
        $posts = $this->postRepository->paginate($request->input('max', 20));

        return view('cms::web.post.index', compact('posts'));
    }

    public function detail($id, Request $request)
    {
        $post = $this->postRepository->find($id);

        if (!$post || !$post->is_active) {
            abort(404);
        }

        $totalViewed = $post->is_viewed + 1;
        $post->update(['is_viewed' => $totalViewed]);

        return view('cms::web.post.detail', compact('post'));
    }

    /**
     * Xem trước bài viết, kể cả bài nháp. Route có middleware "signed" nên chỉ ai có URL hợp lệ mới xem được.
     */
    public function preview($id)
    {
        $post = $this->postRepository->find($id);

        if (!$post) {
            abort(404);
        }

        return response()
            ->view('cms::web.post.detail', ['post' => $post, 'isPreview' => true])
            ->header('X-Robots-Tag', 'noindex, nofollow')
            ->header('Cache-Control', 'private, no-store');
    }
}
