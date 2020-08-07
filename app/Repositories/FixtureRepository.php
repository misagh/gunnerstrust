<?php

namespace App\Repositories;

use App\Fixture;
use Carbon\Carbon;

class FixtureRepository extends Repository {

    public function __construct(Fixture $fixture = null)
    {
        $this->model = $fixture ?: new Fixture();
    }

    public function insertFixture($data)
    {
        $data['body'] = $this->processBodyText($data['body']);
        $data['slug'] = $this->generateSlug($data);

        return $this->create($data);
    }

    public function updateFixture($data)
    {
        $data['body'] = $this->processBodyText($data['body']);

        $this->update($this->model, $data);

        return $this->model;
    }

    public function getTodayFixture()
    {
        return $this->model->whereBetween('played_at', [today(), tomorrow()])
                           ->first();
    }

    public function getNextFixture()
    {
        return $this->model->where('played_at', '>', today())
                           ->orderBy('played_at')
                           ->first();
    }

    public function getPreviousFixture()
    {
        return $this->model->where('played_at', '<', today())
                           ->orderByDesc('played_at')
                           ->first();
    }

    public function getLatestFixtures()
    {
        return $this->model->orderByDesc('played_at')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    public function getLatestPlayedFixtures($offset_played, $order, $limit = 1)
    {
        return $this->model->where('played_at', $order === 'asc' ? '>' : '<', $offset_played)
                           ->orderBy('played_at', $order)
                           ->limit($limit)
                           ->get();
    }

    public function getArticles()
    {
        return $this->model->articles()
                           ->orderByDesc('id')
                           ->get();
    }

    private function generateSlug($data)
    {
        $date = shamsi($data['played_at'])->format('l j F Y');

        $team1 = (new TeamRepository)->getTeamNameFa($data['team1_id']);
        $team2 = (new TeamRepository)->getTeamNameFa($data['team2_id']);

        return $this->getSlug("{$team1} {$team2} {$date}");
    }
}
