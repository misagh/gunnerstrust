<?php

namespace App\Http\Controllers;

class NotificationController extends Controller {

    public function index()
    {
        $notifications = auth()->user()->notifications->take(20);

        $unreads = [];

        foreach ($notifications as $notification)
        {
            is_null($notification->read_at) AND $unreads[] = $notification->id;
        }

        $notifications->markAsRead();

        return view('notifications.lists', compact('notifications', 'unreads'));
    }
}
