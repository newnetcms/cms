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

        if (view()->exists('cms::web.page.layouts.'.$page->page_layout)) {
            $layout = 'cms::web.page.layouts.'.$page->page_layout;
        } else {
            $layout = 'cms::web.page.detail';
        }

        return view($layout, compact('page'));
    }
}
