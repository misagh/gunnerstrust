<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TagRepository;

class TagController extends Controller {

    public function index($tag = null)
    {
        $tag = (new TagRepository)->findByOrFail('name', $tag);

        $updates = (new TagRepository($tag))->getLatestUpdates();

        return view('tags.updates', compact('tag', 'updates'));
    }
}
