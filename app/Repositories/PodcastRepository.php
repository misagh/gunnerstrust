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
        $data['body'] = $this->processBodyText($data['body']);
        $data['slug'] = $this->getSlug($data['title']);

        return $this->create($data);
    }

    public function updatePodcast($data)
    {
        $data['body'] = $this->processBodyText($data['body']);

        $this->update($this->model, $data);

        return $this->model;
    }

    public function getLatestPodcasts($limit, $exclude = null, $random = false)
    {
        $podcasts = $this->model->whereNotIn('id', array_wrap($exclude))
                                ->limit($limit);

        if ($random)
        {
            $podcasts->inRandomOrder();
        }
        else
        {
            $podcasts->orderByDesc('id');
        }

        return $podcasts->get();
    }

    public function getList()
    {
        return $this->model->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }
}
