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

        return view('home', compact('articles', 'pinned', 'challenge'));
    }
}
