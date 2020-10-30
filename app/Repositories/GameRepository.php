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
        $data = array_only($data, ['score1', 'score2', 'winner_id']);

        return $this->model->updateOrCreate(compact('user_id', 'fixture_id'), $data);
    }

    public function getLeagueTable($month)
    {
        $table = $this->model->with('user')
                             ->selectRaw('SUM(`games`.`points`) AS `points`')
                             ->addSelect(['games.user_id'])
                             ->groupBy('games.user_id')
                             ->orderByDesc('games.points')
                             ->orderBy('games.id');

        if ($month > 0)
        {
            $table->leftJoin('fixtures', 'games.fixture_id', '=', 'fixtures.id')
                  ->whereMonth('fixtures.played_at', $month);
        }

        return $table->paginate(static::PAGINATION_LIMIT);
    }

    public function getUserGuess($fixture_id, $user_id)
    {
        return $this->model->where('fixture_id', $fixture_id)
                           ->where('user_id', $user_id)
                           ->first();
    }

    public function getUserPoints($user_id)
    {
        if (! $user_id)
        {
            return null;
        }

        return $this->model->where('user_id', $user_id)
                           ->sum('points');
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
