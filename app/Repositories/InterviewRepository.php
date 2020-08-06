<?php

namespace App\Repositories;

use App\Interview;

class InterviewRepository extends Repository {

    public function __construct(Interview $interview = null)
    {
        $this->model = $interview ?: new Interview();
    }

    public function insertInterview($data)
    {
        $data['body'] = clean($data['body']);
        $data['slug'] = $this->getSlug($data['title']);

        return $this->create($data);
    }

    public function updateInterview($data)
    {
        $data['body'] = clean($data['body']);

        $this->update($this->model, $data);

        return $this->model;
    }

    public function getLatestInterviews($limit, $exclude = null)
    {
        return $this->model->with('user')
                           ->whereNotIn('id', array_wrap($exclude))
                           ->inRandomOrder()
                           ->limit($limit)
                           ->get();
    }

    public function getList()
    {
        return $this->model->with('user')
                           ->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    public function getUserScore()
    {
        $score = $this->model->scores()
                             ->where('user_id', auth()->id())
                             ->first();

        return $score ? $score->score : null;
    }

    public function addScore($score)
    {
        $user_id = auth()->id();

        return $this->model->scores()->firstOrCreate(compact('user_id'), compact('score'));
    }
}
