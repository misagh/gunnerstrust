<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Services\ArticleImageFinder;
use App\Repositories\TeamRepository;
use App\Repositories\StadiumRepository;

class StadiumController extends Controller {

    public function add()
    {
        if (request()->isMethod('post'))
        {
            $this->validate(request(), ['name_en' => [Rule::unique('stadiums', 'name_en')]]);

            (new StadiumRepository)->insertStadium(request()->all());

            $this->uploadLogo();

            session()->flash('success', 'خبر با موفقیت افزوده شد.');

            return redirect()->back();
        }

        $teams = (new TeamRepository)->getAllTeams();

        return view('stadiums.form', compact('teams'));
    }

    public function edit($id)
    {
        $stadium = (new StadiumRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            $this->validate(request(), ['name_en' => [Rule::unique('stadiums', 'name_en')->ignore($stadium)]]);

            (new StadiumRepository($stadium))->updateStadium(request()->all());

            $this->uploadLogo();

            session()->flash('success', 'استادیوم با موفقیت ویرایش شد.');

            return redirect()->back();
        }

        $teams = (new TeamRepository)->getAllTeams();

        return view('stadiums.form', compact('stadium', 'teams'));
    }

    public function delete($id)
    {
        $stadium = (new StadiumRepository)->findOrFail($id);

        $stadium->delete();

        return redirect()->back();
    }

    public function lists()
    {
        $stadiums = (new StadiumRepository)->getSimplePaginated();

        return view('stadiums.lists', compact('stadiums'));
    }

    private function uploadLogo()
    {
        if ($logo = request()->file('logo'))
        {
            $logo->storeAs('logos', request()->get('name_en') . '.jpg');

            (new ArticleImageFinder)->optimize(storage_path('app/logos/' . request()->get('name_en') . '.jpg'));
        }
    }
}
