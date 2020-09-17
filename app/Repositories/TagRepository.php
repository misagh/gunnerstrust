<?php

namespace App\Repositories;

use App\Tag;
use Illuminate\Database\QueryException;

class TagRepository extends Repository {

    public function __construct(Tag $tag = null)
    {
        $this->model = $tag ?: new Tag();
    }

    public function getLatestUpdates()
    {
        return $this->model->updates()->paginate(static::PAGINATION_LIMIT);
    }

    public function insertTag($name)
    {
        try
        {
            return $this->create(compact('name'));
        }
        catch (QueryException $e)
        {
            return $this->findBy('name', $name);
        }
    }
}
