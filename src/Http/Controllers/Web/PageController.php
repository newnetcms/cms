<?php

namespace Newnet\Cms\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use Newnet\Cms\Models\Page;
use Newnet\Cms\Repositories\PageRepository;

class PageController extends Controller
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function detail($id)
    {
        /** @var Page $page */
        $page = $this->pageRepository->find($id);

        if (!$page || !$page->is_active) {
            abort(404);
        }

        return view($this->layout($page), compact('page'));
    }

    /**
     * Xem trước trang, kể cả trang chưa kích hoạt. Route có middleware "signed" nên chỉ ai có URL hợp lệ mới xem được.
     */
    public function preview($id)
    {
        /** @var Page $page */
        $page = $this->pageRepository->find($id);

        if (!$page) {
            abort(404);
        }

        return response()
            ->view($this->layout($page), ['page' => $page, 'isPreview' => true])
            ->header('X-Robots-Tag', 'noindex, nofollow')
            ->header('Cache-Control', 'private, no-store');
    }

    protected function layout(Page $page): string
    {
        if (view()->exists('cms::web.page.layouts.'.$page->page_layout)) {
            return 'cms::web.page.layouts.'.$page->page_layout;
        }

        return 'cms::web.page.detail';
    }
}
