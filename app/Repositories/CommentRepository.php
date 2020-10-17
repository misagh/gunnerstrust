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
                           ->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    public function getLatestComments()
    {
        return $this->model->with('user')
                           ->orderByDesc('id')
                           ->limit(9)
                           ->get();
    }

    public function getComments($model, $offset = null, $limit = null)
    {
        return $model->comments()
                     ->with('user')
                     ->with('reactions')
                     ->whereNull('reply_id')
                     ->orderByDesc('id')
                     ->offset(intval($offset))
                     ->limit($limit ?: static::PAGINATION_LIMIT)
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

    public function insertReply($body)
    {
        $user_id = auth()->id();
        $reply_id = $this->model->id;
        $commentable_id = $this->model->commentable_id;
        $commentable_type = $this->model->commentable_type;

        $this->model->create(compact('user_id', 'reply_id', 'commentable_id', 'commentable_type', 'body'));

        return $this->model;
    }
}
