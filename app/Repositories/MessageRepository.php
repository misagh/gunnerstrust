<?php

namespace App\Repositories;

use App\Message;

class MessageRepository extends Repository {

    public function __construct(Message $message = null)
    {
        $this->model = $message ?: new Message();
    }

    public function newMessage($user_from_id, $user_to_id, $body)
    {
        $this->model->fill(compact('user_from_id', 'user_to_id', 'body'));

        return $this->model->saveOrFail();
    }

    public function newCount($user_to_id)
    {
        return $this->model->where('user_to_id', $user_to_id)
                           ->whereNull('read_at')
                           ->count();
    }

    public function getList($user_to_id)
    {
        return $this->model->where('user_to_id', $user_to_id)
                           ->orderByDesc('created_at')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    public function findForUser($id, $user)
    {
        $message = $this->findOrFail($id);

        if ($message->user_to_id !== $user)
        {
            abort(404);
        }

        return $message;
    }
}
