<?php

namespace App\Repositories;

use App\Discussion;

class DiscussionRepository extends Repository {

    public function __construct(Discussion $discussion = null)
    {
        $this->model = $discussion ?: new Discussion();
    }

    public function insertDiscussion($data)
    {
        $data['body'] = $this->processBodyText($data['body']);
        $data['summary'] = $this->processSummaryText($data);
        $data['slug'] = $this->getSlug($data['title']);

        return $this->create($data);
    }

    public function updateDiscussion($data)
    {
        $data['body'] = $this->processBodyText($data['body']);
        $data['summary'] = $this->processSummaryText($data);

        $this->update($this->model, $data);

        return $this->model;
    }

    public function getLatestDiscussions($limit, $exclude = null)
    {
        return $this->model->whereNotIn('id', array_wrap($exclude))
                           ->inRandomOrder()
                           ->limit($limit)
                           ->get();
    }

    public function getLatestDiscussion()
    {
        return $this->model->orderByDesc('id')
                           ->first();
    }

    public function getList()
    {
        return $this->model->with('user')
                           ->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }
}
