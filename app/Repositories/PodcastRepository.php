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

    public function getLatestPodcasts($exclude = null)
    {
        return $this->model->whereNotIn('id', array_wrap($exclude))
                           ->inRandomOrder()
                           ->limit(4)
                           ->get();
    }

    public function getLatestPodcast()
    {
        return $this->model->orderByDesc('id')
                           ->first();
    }

    public function getList()
    {
        return $this->model->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }
}
