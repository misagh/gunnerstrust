<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository extends Repository {

    public function __construct(Category $category = null)
    {
        $this->model = $category ?: new Category();
    }

    public function getLatestUpdates()
    {
        return $this->model->updates()->paginate(static::PAGINATION_LIMIT);
    }
}
