<?php

namespace App\Http\Controllers;

use App\Repositories\TeamRepository;
use App\Repositories\FixtureRepository;
use App\Repositories\StadiumRepository;
use App\Repositories\CompetitionRepository;

class FixtureController extends Controller {

    public function __construct()
    {
        $this->middleware('admin', ['except' => ['view', 'short']]);
    }

    public function short($id)
    {
        $id = intval(base64url_decode($id));

        if ($id > 0)
        {
            $fixture = (new FixtureRepository)->findOrFail($id);

            return redirect()->route('fixtures.view', $fixture->slug);
        }

        abort(404);
    }

    public function add()
    {
        if (request()->isMethod('post'))
        {
            (new FixtureRepository)->insertFixture(request()->all());

            session()->flash('success', 'منوی بازی با موفقیت اضافه شد.');

            return redirect()->route('fixtures.lists');
        }

        $teams = (new TeamRepository)->getAllTeams();
        $stadiums = (new StadiumRepository)->getAllStadiums();
        $competitions = (new CompetitionRepository)->getAllCompetitions();

        return view('fixtures.form', compact('teams', 'stadiums', 'competitions'));
    }

    public function edit($id)
    {
        $fixture = (new FixtureRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            (new FixtureRepository($fixture))->updateFixture(request()->all());

            session()->flash('success', 'منوی بازی با موفقیت ویرایش شد.');

            return redirect()->route('fixtures.lists');
        }

        $teams = (new TeamRepository)->getAllTeams();
        $stadiums = (new StadiumRepository)->getAllStadiums();
        $competitions = (new CompetitionRepository)->getAllCompetitions();

        return view('fixtures.form', compact('fixture', 'teams', 'stadiums', 'competitions'));
    }

    public function lists()
    {
        $fixtures = (new FixtureRepository)->getLatestFixtures();

        return view('fixtures.lists', compact('fixtures'));
    }

    public function view($slug)
    {
        $fixture = (new FixtureRepository)->findByOrFail('slug', $slug);

        $fixtures_previous = (new FixtureRepository)->getLatestPlayedFixtures($fixture->played_at, 'desc', 2);
        $fixtures_next = (new FixtureRepository)->getLatestPlayedFixtures($fixture->played_at, 'asc', 2)->reverse();

        $articles = (new FixtureRepository($fixture))->getArticles();

        return view('fixtures.view', compact('fixture', 'fixtures_previous', 'fixtures_next', 'articles'));
    }
}
