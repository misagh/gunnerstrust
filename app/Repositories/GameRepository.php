<?php

namespace App\Repositories;

use App\Game;
use App\Fixture;
use App\Services\GamePointCalculator;

class GameRepository extends Repository {

    public function __construct(Game $game = null)
    {
        $this->model = $game ?: new Game();
    }

    public function insertGuess($data, $fixture_id)
    {
        $user_id = auth()->id();
        $data = array_only($data, ['score1', 'score2']);

        return $this->model->updateOrCreate(compact('user_id', 'fixture_id'), $data);
    }

    public function getLeagueTable()
    {
        return $this->model->with('user')
                           ->selectRaw('SUM(`points`) AS `points`')
                           ->addSelect(['user_id'])
                           ->groupBy('user_id')
                           ->orderByDesc('points')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    public function getUserGuess($fixture_id, $user_id)
    {
        return $this->model->where('fixture_id', $fixture_id)
                           ->where('user_id', $user_id)
                           ->first();
    }

    public function calculatePoints(Fixture $fixture)
    {
        $games = $this->model->where('fixture_id', $fixture->id)->get();

        foreach ($games as $game)
        {
            $game->points = (new GamePointCalculator)->getPoints($fixture, $game);

            $game->save();
        }
    }
}
