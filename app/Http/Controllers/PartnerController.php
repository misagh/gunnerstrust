<?php

namespace App\Http\Controllers;

use App\Repositories\PartnerRepository;

class PartnerController extends Controller {

    public function profile($slug)
    {
        $partner = (new PartnerRepository)->findByOrFail('slug', $slug);

        return view('partners.profile', compact('partner'));
    }
}
