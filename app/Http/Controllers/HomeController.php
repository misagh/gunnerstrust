<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\FixtureRepository;
use App\Repositories\CommentRepository;
use App\Repositories\PodcastRepository;
use App\Repositories\ChallengeRepository;
use App\Repositories\InterviewRepository;

class HomeController extends Controller {

    public function index()
    {
        $articles = (new ArticleRepository)->getLatestArticles();
        $interviews = (new InterviewRepository)->getLatestInterviews(6);
        $podcasts = (new PodcastRepository)->getLatestPodcasts(6);
        $comments = (new CommentRepository)->getLatestComments();

        $articles_group1 = $articles->take(3);
        $articles_group2 = $articles->skip(3);

        $article_active = rand(0, $articles_group1->count() - 1);

        return view('home', compact('articles', 'articles_group1', 'articles_group2', 'interviews', 'podcasts', 'article_active', 'comments'));
    }
}
