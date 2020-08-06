<?php

namespace App\Repositories;

use App\Podcast;

class PodcastRepository extends Repository {

    public function __construct(Podcast $podcast = null)
    {
        $this->model = $podcast ?: new Podcast();
    }

    public function insertPodcast($data)
    {
        $data['body'] = clean($data['body']);
        $data['slug'] = $this->getSlug($data['title']);

        return $this->create($data);
    }

    public function updatePodcast($data)
    {
        $data['body'] = clean($data['body']);

        $this->update($this->model, $data);

        return $this->model;
    }

    public function getLatestPodcasts($limit, $exclude = null)
    {
        return $this->model->whereNotIn('id', array_wrap($exclude))
                           ->inRandomOrder()
                           ->limit($limit)
                           ->get();
    }

    public function getList()
    {
        return $this->model->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }
}
