<?php

namespace App\Http\Composers;

use App\Repositories\MessageRepository;
use App\Repositories\TopicRepository;
use Illuminate\View\View;

class AppComposer {

    public function compose(View $view)
    {
        $auth = auth()->user();
        $topics = (new TopicRepository)->getList();

        $new_messages = $auth ? (new MessageRepository)->newCount($auth->id) : null;

        $view->with('auth', $auth)
             ->with('topics', $topics)
             ->with('new_messages', $new_messages);
    }
}
