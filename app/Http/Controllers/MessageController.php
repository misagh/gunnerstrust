<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\MessageRepository;

class MessageController extends Controller {

    public function send()
    {
        $body = request('body');
        $user_from_id = auth()->id();
        $user_to_id = (new UserRepository)->findOrFail(request('user_to_id'))->id;

        if ($user_to_id !== $user_from_id && ! empty($body))
        {
            (new MessageRepository)->newMessage($user_from_id, $user_to_id, $body);
        }

        session()->flash('success', 'پیام خصوصی شما با موفقیت ارسال شد.');

        return redirect(request('return_url') ?: back());
    }

    public function view($id)
    {
        $auth = auth()->user();
        $message = (new MessageRepository)->findForUser($id, $auth->id);

        is_null($message->read_at) AND $message->markAsRead();

        return view('messages.view', compact('message'));
    }
}
