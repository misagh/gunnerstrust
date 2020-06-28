<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\FixtureRepository;
use App\Repositories\ChallengeRepository;

class HomeController extends Controller {

    public function index()
    {
        $pinned = (new ArticleRepository)->getPinnedArticles();
        $articles = (new ArticleRepository)->getUnpinnedArticles();
        $challenge = (new ChallengeRepository)->getCurrentChallenge();
        $posts = (new PostRepository)->getLatestGlobalPosts();

        $articles_group1 = $articles->take(6);
        $articles_group2 = $articles->skip(6);

        $fixtures['today'] = (new FixtureRepository)->getTodayFixture();

        if (empty($fixtures['today']))
        {
            $fixtures['next'] = (new FixtureRepository)->getNextFixture();
            $fixtures['previous'] = (new FixtureRepository)->getPreviousFixture();
        }

        return view('home', compact('articles', 'articles_group1', 'articles_group2', 'pinned', 'challenge', 'posts', 'fixtures'));
    }
}
