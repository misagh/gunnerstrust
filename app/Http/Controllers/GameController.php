<?php

namespace App\Http\Controllers;

use App\Repositories\GameRepository;
use App\Repositories\FixtureRepository;

class GameController extends Controller {

    public function index()
    {
        $month = intval(request('d'));

        if ($month > 12)
        {
            abort(404);
        }

        $fixture = (new FixtureRepository)->getNextFixture();
        $table = (new GameRepository)->getLeagueTable($month);
        $user_guess = (new GameRepository)->getUserGuess($fixture->id ?? null, auth()->id());
        $user_points = (new GameRepository)->getUserPoints(auth()->id());

        return view('games.index', compact('fixture', 'table', 'user_guess', 'user_points', 'month'));
    }

    public function add()
    {
        $fixture = (new FixtureRepository)->getNextFixture();

        if (now() < $fixture->played_at)
        {
            (new GameRepository)->insertGuess(request()->all(), $fixture->id);
        }

        session()->flash('success', 'حدس شما از نتیجه بازی با موفقیت ثبت شد.');

        return redirect()->back();
    }

    public function calculate($id)
    {
        $fixture = (new FixtureRepository)->findOrFail($id);

        $fixture->hasScore() AND (new GameRepository)->calculatePoints($fixture);

        session()->flash('success', 'محاسبه امتیاز ها با موفقیت انجام شد.');

        return redirect()->back();
    }
}
