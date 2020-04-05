<?php

namespace App\Repositories;

use App\Comment;

class CommentRepository extends Repository {

    public function __construct(Comment $comment = null)
    {
        $this->model = $comment ?: new Comment();
    }

    public function getList()
    {
        return $this->model->with('user')
                           ->select(['created_at', 'user_id', 'commentable_type', 'commentable_id'])
                           ->paginate(static::PAGINATION_LIMIT);
    }

    public function getComments($model, $offset = null)
    {
        return $model->comments()
                     ->with('user')
                     ->with('reactions')
                     ->orderByDesc('id')
                     ->offset(intval($offset))
                     ->take(10)
                     ->get();
    }

    public function insertComment($commentable, $body)
    {
        $this->model->fill(compact('body'));
        $this->model->user()->associate(auth()->user());
        $this->model->commentable()->associate($commentable);
        $this->model->save();

        return $this->model;
    }
}
