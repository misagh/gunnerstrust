<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;

class HomeController extends Controller {

    public function index()
    {
        $pinned = (new ArticleRepository)->getPinnedArticles();
        $articles = (new ArticleRepository)->getUnpinnedArticles();

        return view('home', compact('articles', 'pinned'));
    }
}
