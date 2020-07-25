<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\ArticleImageFinder;
use App\Repositories\InterviewRepository;

class InterviewController extends Controller {

    public function __construct()
    {
        $this->middleware('admin', ['except' => ['view', 'short']]);
    }

    public function short($id)
    {
        $id = intval(base64url_decode($id));

        if ($id > 0)
        {
            $interview = (new InterviewRepository)->findOrFail($id);

            return redirect()->route('interviews.view', $interview->slug);
        }

        abort(404);
    }

    public function add()
    {
        if (request()->isMethod('post'))
        {
            $data = request()->all();

            $data['cover'] = $this->uploadCover();

            (new InterviewRepository)->insertInterview($data);

            session()->flash('success', 'مصاحبه با موفقیت در سایت ثبت شد.');

            return redirect()->route('interviews.lists');
        }

        $users = (new UserRepository)->getSelectUsers();

        return view('interviews.form', compact('users'));
    }

    public function edit($id)
    {
        $interview = (new InterviewRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            $data = request()->all();

            $data['cover'] = $this->uploadCover($interview);

            (new InterviewRepository($interview))->updateInterview($data);

            session()->flash('success', 'مصاحبه با موفقیت ویرایش شد.');

            return redirect()->route('interviews.lists');
        }

        $users = (new UserRepository)->getSelectUsers();

        return view('interviews.form', compact('interview', 'users'));
    }

    public function lists()
    {
        $interviews = (new InterviewRepository)->getList();

        return view('interviews.lists', compact('interviews'));
    }

    public function view($slug)
    {
        $interview = (new InterviewRepository)->findByOrFail('slug', $slug);
        $interviews = (new InterviewRepository)->getLatestInterviews($interview->id);
        $user_score = (new InterviewRepository($interview))->getUserScore();

        $interview->increment('hit');

        return view('interviews.view', compact('interview', 'interviews', 'user_score'));
    }

    public function score($id)
    {
        $interview = (new InterviewRepository)->findOrFail($id);

        $score = intval(request('score'));

        if ($score > 0 && $score <= 10 && $interview->user_id !== auth()->id())
        {
            (new InterviewRepository($interview))->addScore($score);
        }

        return redirect()->route('interviews.view', $interview->slug);
    }

    private function uploadCover($interview = null)
    {
        $file_name = $interview->cover ?? null;

        if ($cover = request()->file('cover'))
        {
            $file_name = $file_name ?: substr(sha1(time()), 0, 15) . '.jpg';
            $dir = substr($file_name, 0, 2);
            $path = storage_path('app/covers/' . $dir);

            is_dir($path) OR mkdir($path);

            $cover->storeAs('covers/' . $dir, $file_name);

            (new ArticleImageFinder)->optimize($path . '/' . $file_name);
        }

        return $file_name;
    }
}
