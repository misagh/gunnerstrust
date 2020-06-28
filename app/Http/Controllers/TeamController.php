<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Repositories\TeamRepository;

class TeamController extends Controller {

    public function add()
    {
        if (request()->isMethod('post'))
        {
            $this->validate(request(), ['name_en' => [Rule::unique('teams', 'name_en')]]);

            (new TeamRepository)->insertTeam(request()->all());

            $this->uploadLogo();

            session()->flash('success', 'خبر با موفقیت افزوده شد.');

            return redirect()->back();
        }

        return view('teams.form');
    }

    public function edit($id)
    {
        $team = (new TeamRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            $this->validate(request(), ['name_en' => [Rule::unique('teams', 'name_en')->ignore($team)]]);

            (new TeamRepository($team))->updateTeam(request()->all());

            $this->uploadLogo();

            session()->flash('success', 'تیم با موفقیت ویرایش شد.');

            return redirect()->back();
        }

        return view('teams.form', compact('team'));
    }

    public function delete($id)
    {
        $team = (new TeamRepository)->findOrFail($id);

        $team->delete();

        return redirect()->back();
    }

    public function lists()
    {
        $teams = (new TeamRepository)->getSimplePaginated();

        return view('teams.lists', compact('teams'));
    }

    private function uploadLogo()
    {
        if ($logo = request()->file('logo'))
        {
            $logo->storeAs('logos', request()->get('name_en') . '.png');
        }
    }
}
