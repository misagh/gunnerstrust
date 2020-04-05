<?php

namespace App\Http\Controllers;

use App\Repositories\TopicRepository;
use Illuminate\Http\Request;

class TopicController extends Controller {

    public function view($slug)
    {
        $current_topic = (new TopicRepository)->findByOrFail('slug', $slug);

        return view('topics.view', compact('current_topic'));
    }
}
