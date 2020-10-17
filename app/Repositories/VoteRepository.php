<?php

namespace App\Repositories;

use App\Vote;

class VoteRepository extends Repository {

    public function __construct(Vote $vote = null)
    {
        $this->model = $vote ?: new Vote();
    }

    public function getUserVote($user_id, $discussion_id)
    {
        return $this->model->where('user_id', $user_id)
                           ->where('discussion_id', $discussion_id)
                           ->first();
    }

    public function insertVote($user_id, $option_id, $discussion_id)
    {
        return $this->model->create(compact('user_id', 'option_id', 'discussion_id'));
    }
}
