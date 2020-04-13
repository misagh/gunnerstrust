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
        $new_notifications = $auth ? $auth->unreadNotifications->count() : null;

        $auth AND $auth->touchSeen();

        $view->with('auth', $auth)
             ->with('topics', $topics)
             ->with('new_messages', $new_messages)
             ->with('new_notifications', $new_notifications);
    }
}
