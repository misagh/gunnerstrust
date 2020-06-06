<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use App\Repositories\ChallengeRepository;

class HomeController extends Controller {

    public function index()
    {
        $pinned = (new ArticleRepository)->getPinnedArticles();
        $articles = (new ArticleRepository)->getUnpinnedArticles();
        $challenge = (new ChallengeRepository)->getCurrentChallenge();

        $articles_group1 = $articles->take(6);
        $articles_group2 = $articles->skip(6);

        return view('home', compact('articles', 'articles_group1', 'articles_group2', 'pinned', 'challenge'));
    }
}
