<?php

namespace App\Http\Controllers;

use App\Repositories\DetailRepository;

class DetailController extends Controller {

    public function edit()
    {
        (new DetailRepository)->updateForUser(auth()->user(), request()->all());

        session()->flash('success', 'اطلاعات شما با موفقیت ذخیره شد.');

        return redirect()->back();
    }
}
