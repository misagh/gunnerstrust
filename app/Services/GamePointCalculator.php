<?php

namespace App\Services;

use App\Game;
use App\Fixture;

class GamePointCalculator {

    const FULL_POINTS = 20;
    const SCORE_POINTS = 5;
    const DIFF_POINTS = 7;
    const DRAW_POINTS = 14;
    const WINNER_POINTS = 3;

    public function getPoints(Fixture $fixture, Game $game)
    {
        $winner = ($fixture->penalty && $fixture->getPenaltyWinner() === $game->winner_id) ? static::WINNER_POINTS : 0;

        if ($game->score1 === $fixture->score1 && $game->score2 === $fixture->score2)
        {
            return $winner + static::FULL_POINTS;
        }

        if ($fixture->isDraw() && $game->isDraw())
        {
            return $winner + static::DRAW_POINTS;
        }

        $score1_points = $game->score1 === $fixture->score1 ? static::SCORE_POINTS : 0;
        $score2_points = $game->score2 === $fixture->score2 ? static::SCORE_POINTS : 0;
        $result_posints = 0;

        if (($fixture->isWin() && $game->isWin()) || ($fixture->isLost() && $game->isLost()))
        {
            $result_posints = static::DIFF_POINTS;
        }

        return $result_posints + $score1_points + $score2_points;
    }
}
