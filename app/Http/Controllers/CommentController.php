<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\CommentRepository;
use App\Repositories\ReactionRepository;

class CommentController extends Controller {

    public function fetch($type, $id)
    {
        $article = $this->getModel($type, $id);

        $comments = (new ArticleRepository($article))->getComments(request('offset'));
        $user = auth()->user();

        return response(compact('comments', 'user'));
    }

    public function add($type, $id)
    {
        $article = $this->getModel($type, $id);

        (new CommentRepository)->insertComment($article, request('body'));

        $comments = (new ArticleRepository($article))->getComments();

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

    public function delete($id)
    {
        $comments = (new CommentRepository)->findOrFail($id);

        if ($comments->user_id === auth()->id() || is_admin())
        {
            $comments->delete();
        }

        return response(compact('comments'));
    }

    public function reaction($id, $emoji)
    {
        $comment = (new CommentRepository)->findOrFail($id);

        if ($comment->user_id !== auth()->id())
        {
            $comment = (new ReactionRepository)->insertReaction($comment, $emoji);
        }

        return response(compact('comment'));
    }

    private function getModel($type, $id)
    {
        switch ($type)
        {
            case 'article':
                return (new ArticleRepository)->findOrFail($id);
                break;
            default:
                return null;
                break;
        }
    }
}
