<?php

namespace Newnet\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Newnet\Acl\Models\Admin;
use Newnet\Cms\CmsAdminMenuKey;
use Newnet\Cms\Http\Requests\PostRequest;
use Newnet\Cms\Models\Post;
use Newnet\Cms\Repositories\PostRepository;
use Newnet\AdminUi\Facades\AdminMenu;

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
        $items = $this->postRepository->paginate($request->input('max', 20));

        return view('cms::admin.post.index', compact('items'));
    }

    public function create()
    {
        AdminMenu::activeMenu(CmsAdminMenuKey::POST);

        $item = new Post();

        return view('cms::admin.post.create', compact('item'));
    }

    public function store(PostRequest $request)
    {
        $post = $this->postRepository->create($request->all());

        return redirect()
            ->route('cms.admin.post.edit', $post)
            ->with('success', __('cms::post.notification.created'));
    }

    public function show($id)
    {
        return redirect()->route('cms.admin.post.edit', $id);
    }

    public function edit($id)
    {
        AdminMenu::activeMenu(CmsAdminMenuKey::POST);

        $item = $this->postRepository->find($id);

        $this->checkPermission($item);

        return view('cms::admin.post.edit', compact('item'));
    }

    public function update($id, Request $request)
    {
        $item = $this->postRepository->find($id);
        $this->checkPermission($item);
        $item->update($request->all());

        return back()->with('success', __('cms::post.notification.updated'));
    }

    public function destroy($id, Request $request)
    {
        $item = $this->postRepository->find($id);
        $this->checkPermission($item);
        $item->delete();

        if ($request->wantsJson()) {
            Session::flash('success', __('cms::post.notification.deleted'));
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()
            ->route('cms.admin.post.index')
            ->with('success', __('cms::post.notification.deleted'));
    }

    public function checkPermission(mixed $item)
    {
        if (config('cms.cms.enable_manage_own') && !admin_can('cms.admin.post.manage_all')) {
            if (!($item->author_type == Admin::class && $item->author_id == auth('admin')->id())) {
                abort(403);
            }
        }
    }
}
