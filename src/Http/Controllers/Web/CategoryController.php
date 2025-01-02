<?php

namespace Newnet\Cms\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Newnet\Cms\Models\Category;
use Newnet\Cms\Repositories\CategoryRepository;
use Newnet\Cms\Repositories\PostRepository;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
    }

    public function detail($id, Request $request)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->find($id);

        $catIds = $category->getDescendantIds();

        $defaultMax = config('cms.cms.item_per_page');

        $posts = $this->postRepository->paginateInCategory($catIds, $request->input('max', $defaultMax));

        return view('cms::web.category.detail', compact('category', 'posts'));
    }
}
