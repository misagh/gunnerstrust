<?php

namespace App\Repositories;

use App\Reaction;

class ReactionRepository extends Repository {

    public function __construct(Reaction $reaction = null)
    {
        $this->model = $reaction ?: new Reaction();
    }

    public function insertReaction($reactionable, $reaction)
    {
        $user = auth()->user();
        $user_id = $user->id;

        $this->model->user()->associate($user);
        $this->model->reactionable()->associate($reactionable);
        $this->model->fill(compact('reaction'));

        $reactions = $this->model->reactionable->reactions;

        if ($existed = $reactions->where('user_id', $user_id)->first())
        {
            $existed->update(compact('reaction'));
        }
        else
        {
            $this->model->save();
            $this->model->refresh();
        }

        return $this->model->reactionable;
    }
}
