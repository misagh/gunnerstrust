<?php

namespace App\Http\Controllers;

use App\Repositories\ChallengeRepository;
use Illuminate\Http\Request;

class ChallengeController extends Controller {

    public function __construct()
    {
        $this->middleware('admin', ['except' => ['view', 'lists']]);
    }

    public function add()
    {
        if (request()->isMethod('post'))
        {
            $rules = [
                'title'   => ['required'],
                'summary' => ['required', 'min:150', 'max:160'],
                'cover'   => ['required'],
            ];

            $this->validate(request(), $rules);

            (new ChallengeRepository)->insertChallenge(request()->all());

            session()->flash('success', 'چالش با موفقیت افزوده شد.');

            return redirect()->back();
        }

        return view('challenges.form');
    }

    public function edit($id)
    {
        $challenge = (new ChallengeRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            $rules = [
                'title'   => ['required'],
                'summary' => ['required', 'min:150', 'max:160'],
            ];

            $this->validate(request(), $rules);

            (new ChallengeRepository($challenge))->updateChallenge(request()->all());

            session()->flash('success', 'چالش با موفقیت ویرایش شد.');

            return redirect()->back();
        }

        return view('challenges.form', compact('challenge'));
    }

    public function delete($id)
    {
        $challenge = (new ChallengeRepository)->findOrFail($id);

        $challenge->delete();

        return redirect()->back();
    }

    public function view($slug)
    {
        $challenge = (new ChallengeRepository)->findByOrFail('slug', $slug);
        $posts = (new ChallengeRepository($challenge))->getPosts();

        return view('challenges.view', compact('challenge', 'posts'));
    }

    public function lists()
    {
        $challenges = (new ChallengeRepository)->getLatestChallenges();

        return view('challenges.lists', compact('challenges'));
    }
}
