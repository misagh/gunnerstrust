<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Post;
use App\Services\ArticleImageFinder;
use App\Services\PostImageFinder;

class PostRepository extends Repository {

    public function __construct(Post $post = null)
    {
        $this->model = $post ?: new Post();
    }

    public function getVerifiedPost($slug)
    {
        $post = $this->model->where('slug', $slug)
                            ->where('verified', true)
                            ->first();

        if (empty($post))
        {
            abort(404);
        }

        return $post;
    }

    public function insertPost($challenge_id, $data)
    {
        $data['challenge_id'] = $challenge_id;
        $data['body'] = clean($data['body']);
        $data['user_id'] = auth()->id();

        return $this->create($data);
    }

    public function updatePost($data)
    {
        $data['body'] = clean($data['body']);

        $this->update($this->model, $data);

        return $this->model;
    }

    public function verifyPost($data)
    {
        $data['cover'] = (new ArticleImageFinder)->find(null, $data['cover'], true);
        $data['verified'] = true;
        $data['tip'] = null;

        if (empty($this->model->slug))
        {
            $data['slug'] = $this->getSlug($data['title']);
        }

        return $this->updatePost($data);
    }

    public function getVerified()
    {
        return $this->model->where('verified', true)
                           ->orderByDesc('id')
                           ->paginate(static::PAGINATION_LIMIT);
    }

    public function getNotVerified()
    {
        return $this->model->where('verified', false)
                           ->orderByDesc('id')
                           ->get();
    }

    public function getLatestPosts($exclude)
    {
        return $this->model->with('user')
                           ->where('verified', true)
                           ->whereNotIn('id', [$exclude])
                           ->inRandomOrder()
                           ->limit(2)
                           ->get();
    }

    public function getUserScore()
    {
        $score = $this->model->scores()
                             ->where('user_id', auth()->id())
                             ->first();

        return $score ? $score->score : null;
    }

    public function addScore($score)
    {
        $user_id = auth()->id();

        return $this->model->scores()->firstOrCreate(compact('user_id'), compact('score'));
    }
}
