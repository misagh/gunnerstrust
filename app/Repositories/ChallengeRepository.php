<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Challenge;
use App\Services\ArticleImageFinder;
use App\Services\ChallengeImageFinder;

class ChallengeRepository extends Repository {

    public function __construct(Challenge $challenge = null)
    {
        $this->model = $challenge ?: new Challenge();
    }

    public function insertChallenge($data)
    {
        $data['cover'] = (new ArticleImageFinder)->find(null, $data['cover']);
        $data['finished_at'] = $this->getFinishedDate($data);
        $data['slug'] = $this->getSlug($data['title']);
        $data['user_id'] = auth()->id();

        return $this->create($data);
    }

    public function updateChallenge($data)
    {
        if (! empty($data['cover']))
        {
            $data['cover'] = (new ChallengeImageFinder)->find($data['source'], $data['cover'], true);
        }

        empty($data['cover']) AND $data['cover'] = $this->model->cover;
        $data['finished_at'] = $this->getFinishedDate($data);

        $this->update($this->model, $data);

        return $this->model;
    }

    public function getCurrentChallenge()
    {
        return $this->model->where('finished_at', '>=', today())
                           ->orderBy('id')
                           ->first();
    }

    public function getLatestChallenges()
    {
        return $this->model->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    public function getPosts()
    {
        return $this->model->posts()
                           ->where('verified', true)
                           ->orderByDesc('hit')
                           ->orderBy('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    private function getFinishedDate($data)
    {
        return Carbon::parse($data['started_at'])->addDays(intval(@$data['days']));
    }
}
