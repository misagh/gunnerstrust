<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Repositories\TopicRepository;
use App\Repositories\UpdateRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\FixtureRepository;
use App\Repositories\PodcastRepository;
use App\Repositories\ReactionRepository;
use App\Repositories\InterviewRepository;
use App\Repositories\DiscussionRepository;

class CommentController extends Controller {

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['fetch', 'list', 'reactionList']]);
    }

    public function fetch($type, $id)
    {
        $model = $this->getModel($type, $id);

        $comments = (new CommentRepository)->getComments($model, request('offset'));
        $user = auth()->user();

        return response(compact('comments', 'user'));
    }

    public function add($type, $id)
    {
        $model = $this->getModel($type, $id);

        (new CommentRepository)->insertComment($model, request('body'));

        $comments = (new CommentRepository)->getComments($model, request('offset'));

        return response(compact('comments'));
    }

    public function edit($id)
    {
        $comments = (new CommentRepository)->findOrFail($id);

        if ($comments->user_id === auth()->id() || is_admin())
        {
            $comments->update(['body' => request('body')]);
        }

        return response(compact('comments'));
    }

    public function reply($id)
    {
        $comments = (new CommentRepository)->findOrFail($id);

        $comments = (new CommentRepository($comments))->insertReply(request('body'));

        return response(compact('comments'));
    }

    public function delete($id)
    {
        $comments = (new CommentRepository)->findOrFail($id);

        if ($comments->user_id === auth()->id() || is_admin())
        {
            $comments->delete();
        }

        return response(compact('comments'));
    }

    public function reactionAdd($id, $emoji)
    {
        $comment = (new CommentRepository)->findOrFail($id);

        if ($comment->user_id !== auth()->id())
        {
            $comment = (new ReactionRepository)->insertReaction($comment, $emoji);
        }

        return response(compact('comment'));
    }

    public function reactionList($id)
    {
        $comment = (new CommentRepository)->findOrFail($id);

        $reactions = $comment->reactions()->with('user')->get();

        return response(compact('reactions'));
    }

    public function list()
    {
        $comments = (new CommentRepository)->getList();

        return view('comments.list', compact('comments'));
    }

    private function getModel($type, $id)
    {
        switch ($type)
        {
            case 'article':
                return (new ArticleRepository)->findOrFail($id);
                break;
            case 'topic':
                return (new TopicRepository)->findOrFail($id);
                break;
            case 'post':
                return (new PostRepository)->findOrFail($id);
                break;
            case 'fixture':
                return (new FixtureRepository)->findOrFail($id);
                break;
            case 'interview':
                return (new InterviewRepository)->findOrFail($id);
                break;
            case 'podcast':
                return (new PodcastRepository)->findOrFail($id);
                break;
            case 'update':
                return (new UpdateRepository)->findOrFail($id);
                break;
            case 'discussion':
                return (new DiscussionRepository)->findOrFail($id);
                break;
            default:
                return null;
                break;
        }
    }
}
