<?php

namespace Newnet\Cms\Repositories;

use Newnet\Cms\Models\Page;
use Newnet\Core\Repositories\AuthorRepositoryTrait;
use Newnet\Core\Repositories\BaseRepository;
use Newnet\Core\Repositories\NestedRepositoryTrait;

class PageRepository extends BaseRepository
{
    use AuthorRepositoryTrait;
    use NestedRepositoryTrait;

    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function findBySlug($slug)
    {
        return $this->model
            ->where('is_active', 1)
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function findActive($id)
    {
        return $this->model
            ->where('is_active', 1)
            ->where('id', $id)
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
}
