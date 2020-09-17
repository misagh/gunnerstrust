<?php

namespace App\Http\Controllers;

use Telegram;
use App\Repositories\UserRepository;
use App\Repositories\UpdateRepository;
use App\Repositories\FixtureRepository;
use App\Repositories\PartnerRepository;
use App\Repositories\CategoryRepository;

class UpdateController extends Controller {

    public function __construct()
    {
        $this->middleware('author', ['except' => ['view', 'fetch']]);
    }

    public function add()
    {
        if (request()->isMethod('post'))
        {
            $this->validate(request(), ['body' => ['required']]);

            $update = (new UpdateRepository)->insertUpdate(request()->all());

            session()->flash('success', 'خبر با موفقیت افزوده شد.');

            return redirect()->back();
        }

        $categories = (new CategoryRepository)->getAllRecords();

        return view('updates.form', compact('categories'));
    }

    public function edit($id)
    {
        $update = (new UpdateRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            $this->validate(request(), ['body' => ['required']]);

            (new UpdateRepository($update))->updateUpdate(request()->all());

            session()->flash('success', 'خبر با موفقیت ویرایش شد.');

            return redirect()->back();
        }

        $categories = (new CategoryRepository)->getAllRecords();
        $update_categories = $update->categories->pluck('id')->toArray() ?? [];

        return view('updates.form', compact('update', 'categories', 'update_categories'));
    }

    public function delete($id)
    {
        $update = (new UpdateRepository)->findOrFail($id);

        $update->delete();

        return redirect()->back();
    }

    public function view($id)
    {
        $update = (new UpdateRepository)->findOrFail($id);

        $update->increment('hit');

        return view('updates.view', compact('update'));
    }

    public function fetch()
    {
        $offset = intval(request('offset')) + UpdateRepository::PAGINATION_LIMIT;

        $updates = (new UpdateRepository)->getLatestUpdates($offset);

        $data = [
            'content' => view('updates.box_list', compact('updates'))->render(),
            'more'    => $updates->count() === UpdateRepository::PAGINATION_LIMIT,
            'offset'  => $offset,
        ];

        return response($data);
    }
}
