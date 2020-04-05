<?php

namespace App\Repositories;

use App\Topic;

class TopicRepository extends Repository {

    public function __construct(Topic $topic = null)
    {
        $this->model = $topic ?: new Topic();
    }

    public function getList()
    {
        return $this->model->select(['title', 'slug'])->get();
    }
}
