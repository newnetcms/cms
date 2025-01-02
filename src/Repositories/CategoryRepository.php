<?php

namespace Newnet\Cms\Repositories;

use Newnet\Cms\Models\Category;
use Newnet\Core\Repositories\BaseRepository;
use Newnet\Core\Repositories\NestedRepositoryTrait;

class CategoryRepository extends BaseRepository
{
    use NestedRepositoryTrait;

    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function findBySlug($slug)
    {
        return $this->model
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function paginateTree($itemPerPage)
    {
        $data = $this->model->query();

        if ($name = request('name')) {
            $data->where(function ($q) use ($name) {
                foreach (explode(' ', $name) as $keyword) {
                    if ($keyword = trim($keyword)) {
                        $q->where('name', 'like', "%{$keyword}%");
                    }
                }
            });
        }

        return $data
            ->withDepth()
            ->defaultOrder()
            ->paginate($itemPerPage);
    }

    public function listRoot()
    {
        return Category::defaultOrder()->whereIsRoot()->get();
    }
}
