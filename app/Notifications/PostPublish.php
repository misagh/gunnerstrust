<?php

namespace App\Notifications;

use App\Post;
use Illuminate\Notifications\Notification;

class PostPublish extends Notification {

    private $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        if ($this->post->verified)
        {
            $message = 'مقاله شما تایید و در سایت منتشر شد.';
            $url = route('posts.view', $this->post->slug);
        }
        else
        {
            $message = 'مقاله شما نیاز به ویرایش دارد.';
            $url = route('posts.edit', $this->post->id);
        }

        return compact('message', 'url');
    }
}
