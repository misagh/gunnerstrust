<?php

namespace App\Repositories;

use App\Like;

class LikeRepository extends Repository {

    public function __construct(Like $like = null)
    {
        $this->model = $like ?: new Like();
    }

    public function insertLike($likeable)
    {
        $user = auth()->user();
        $user_id = $user->id;

        $this->model->user()->associate($user);
        $this->model->likeable()->associate($likeable);

        $likes = $this->model->likeable->likes;

        if ($existed = $likes->where('user_id', $user_id)->first())
        {
            $existed->delete();
        }
        else
        {
            $this->model->save();
        }

        $this->model->likeable->refresh();

        return $this->model->likeable;
    }
}
