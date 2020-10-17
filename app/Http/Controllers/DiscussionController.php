<?php

namespace App\Http\Controllers;

use App\Services\ArticleImageFinder;
use App\Repositories\VoteRepository;
use App\Repositories\OptionRepository;
use App\Repositories\DiscussionRepository;

class DiscussionController extends Controller {

    private static $option_colors = ['primary', 'danger', 'purple', 'secondary', 'orange', 'dark'];

    public function __construct()
    {
        $this->middleware('admin', ['only' => ['add', 'edit']]);
    }

    public function short($id)
    {
        $id = intval(base64url_decode($id));

        if ($id > 0)
        {
            $discussion = (new DiscussionRepository)->findOrFail($id);

            return redirect()->route('discussions.view', $discussion->slug);
        }

        abort(404);
    }

    public function add()
    {
        if (request()->isMethod('post'))
        {
            $data = request()->all();

            $data['cover'] = $this->uploadCover();

            (new DiscussionRepository)->insertDiscussion($data);

            session()->flash('success', 'بحث با موفقیت اضافه شد.');

            return redirect()->route('discussions.lists');
        }

        return view('discussions.form');
    }

    public function edit($id)
    {
        $discussion = (new DiscussionRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            $data = request()->all();

            $data['cover'] = $this->uploadCover($discussion);

            (new DiscussionRepository($discussion))->updateDiscussion($data);

            session()->flash('success', 'بحث با موفقیت ویرایش شد.');

            return redirect()->route('discussions.lists');
        }

        return view('discussions.form', compact('discussion'));
    }

    public function lists()
    {
        $discussions = (new DiscussionRepository)->getSimplePaginated();

        return view('discussions.lists', compact('discussions'));
    }

    public function view($slug)
    {
        $discussion = (new DiscussionRepository)->findByOrFail('slug', $slug);
        $discussions = (new DiscussionRepository)->getLatestDiscussions(2, $discussion->id);
        $user_vote = (new VoteRepository)->getUserVote(auth()->id(), $discussion->id);

        $options = [];

        foreach ($discussion->options as $key => $option)
        {
            $options[] = [
                'id'    => $option->id,
                'title' => $option->title,
                'votes' => $option->votes()->count(),
                'color' => static::$option_colors[$key],
            ];
        }

        $all_votes = collect($options)->sum('votes');

        foreach ($options as &$option)
        {
            $option['percent'] = round(($option['votes'] * 100) / $all_votes);
        }

        return view('discussions.view', compact('discussion', 'discussions', 'options', 'all_votes', 'user_vote'));
    }

    public function vote($id)
    {
        $discussion = (new DiscussionRepository)->findOrFail($id);
        $option = (new OptionRepository)->findOrFail(request('option_id'));

        $user_id = auth()->id();

        $user_vote = (new VoteRepository)->getUserVote($user_id, $discussion->id);

        if (empty($user_vote) && $option->discussion_id === $discussion->id)
        {
            (new VoteRepository)->insertVote($user_id, $option->id, $discussion->id);
        }

        return redirect()->back();
    }

    private function uploadCover($discussion = null)
    {
        $file_name = $discussion->cover ?? null;

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
