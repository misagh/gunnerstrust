<?php

namespace App\Http\Controllers;

use App\Notifications\PostPublish;
use App\Repositories\PostRepository;
use App\Repositories\ChallengeRepository;

class PostController extends Controller {

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['view', 'short']]);
    }

    public function short($id)
    {
        $id = intval(base64url_decode($id));

        if ($id > 0)
        {
            $post = (new PostRepository)->findOrFail($id);

            if ($post->verified)
            {
                return redirect()->route('posts.view', $post->slug);
            }
        }

        abort(404);
    }

    public function add($challenge_id)
    {
        $challenge = (new ChallengeRepository)->findOrFail($challenge_id);

        if (request()->isMethod('post'))
        {
            (new PostRepository)->insertPost($challenge_id, request()->all());

            session()->flash('success', 'مقاله شما ذخیره شد و پس از بازبینی توسط مدیریت، در سایت منتشر خواهد شد.');

            return redirect()->route('posts.lists');
        }

        return view('posts.form', compact('challenge'));
    }

    public function edit($id)
    {
        $post = (new PostRepository)->findOrFail($id);
        $challenge = $post->challenge;
        $auth = auth()->user();

        if (! is_admin($auth) && ($post->user_id !== $auth->id || $post->verified))
        {
            abort(404);
        }

        if (request()->isMethod('post'))
        {
            if (request()->has('publish') && is_admin($auth))
            {
                (new PostRepository($post))->verifyPost(request()->all());

                session()->flash('success', 'مقاله با موفقیت منتشر شد.');
            }
            else
            {
                (new PostRepository($post))->updatePost(request()->all());

                session()->flash('success', 'مقاله شما با موفقیت ویرایش شد.');
            }

            $post->user->notify(new PostPublish($post));

            return redirect()->route('posts.lists');
        }

        return view('posts.form', compact('post', 'challenge'));
    }

    public function lists()
    {
        $verified = (new PostRepository)->getVerified();
        $notverified = (new PostRepository)->getNotVerified();

        return view('posts.lists', compact('verified', 'notverified'));
    }

    public function view($slug)
    {
        $post = (new PostRepository)->getVerifiedPost($slug);
        $posts = (new PostRepository)->getLatestPosts($post->id);
        $user_score = (new PostRepository($post))->getUserScore();

        $post->increment('hit');

        return view('posts.view', compact('post', 'posts', 'user_score'));
    }

    public function score($id)
    {
        $post = (new PostRepository)->findOrFail($id);

        $score = intval(request('score'));

        if ($score > 0 && $score <= 10 && $post->user_id !== auth()->id())
        {
            (new PostRepository($post))->addScore($score);
        }

        return redirect()->route('posts.view', $post->slug);
    }
}
