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
        $articles = (new ArticleRepository)->getUnpinnedArticles(10);
        $pinned = (new ArticleRepository)->getPinnedArticles();
        $interviews = (new InterviewRepository)->getLatestInterviews(6);
        $podcasts = (new PodcastRepository)->getLatestPodcasts(6);
        $comments = (new CommentRepository)->getLatestComments();

        $pinned = @$pinned[0];

        return view('home', compact('articles', 'pinned', 'interviews', 'podcasts', 'comments'));
    }
}
