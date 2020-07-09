<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\TopicRepository;
use Illuminate\Http\Request;

class TopicController extends Controller {

    public function short($id)
    {
        $id = intval(base64url_decode($id));

        if ($id > 0)
        {
            $article = (new TopicRepository)->findOrFail($id);

            return redirect()->route('topics.view', $article->slug);
        }

        abort(404);
    }

    public function view($slug)
    {
        $current_topic = (new TopicRepository)->findByOrFail('slug', $slug);
        $articles = (new ArticleRepository)->getLatestRandomArticles();

        return view('topics.view', compact('current_topic', 'articles'));
    }
}
