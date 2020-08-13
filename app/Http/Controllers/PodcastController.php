<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Services\ArticleImageFinder;
use App\Repositories\PodcastRepository;

class PodcastController extends Controller {

    public function __construct()
    {
        $this->middleware('admin', ['except' => ['view', 'short', 'lists']]);
    }

    public function short($id)
    {
        $id = intval(base64url_decode($id));

        if ($id > 0)
        {
            $podcast = (new PodcastRepository)->findOrFail($id);

            return redirect()->route('podcasts.view', $podcast->slug);
        }

        abort(404);
    }

    public function add()
    {
        if (request()->isMethod('post'))
        {
            $data = request()->all();

            $data['cover'] = $this->uploadCover();

            (new PodcastRepository)->insertPodcast($data);

            session()->flash('success', 'پادکست با موفقیت در سایت ثبت شد.');

            return redirect()->route('podcasts.lists');
        }

        $users = (new UserRepository)->getSelectUsers();

        return view('podcasts.form', compact('users'));
    }

    public function edit($id)
    {
        $podcast = (new PodcastRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            $data = request()->all();

            $data['cover'] = $this->uploadCover($podcast);

            (new PodcastRepository($podcast))->updatePodcast($data);

            session()->flash('success', 'پادکست با موفقیت ویرایش شد.');

            return redirect()->route('podcasts.lists');
        }

        $users = (new UserRepository)->getSelectUsers();

        return view('podcasts.form', compact('podcast', 'users'));
    }

    public function lists()
    {
        $podcasts = (new PodcastRepository)->getList();

        return view('podcasts.lists', compact('podcasts'));
    }

    public function view($slug)
    {
        $podcast = (new PodcastRepository)->findByOrFail('slug', $slug);
        $podcasts = (new PodcastRepository)->getLatestPodcasts(2, $podcast->id);

        $podcast->increment('hit');

        return view('podcasts.view', compact('podcast', 'podcasts'));
    }

    private function uploadCover($podcast = null)
    {
        $file_name = $podcast->cover ?? null;

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
