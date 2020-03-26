<?php

namespace App\Repositories;

use App\Comment;

class CommentRepository extends Repository {

    public function __construct(Comment $comment = null)
    {
        $this->model = $comment ?: new Comment();
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
