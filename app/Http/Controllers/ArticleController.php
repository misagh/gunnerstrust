<?php

namespace App\Http\Controllers;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller {

    public function __construct()
    {
        $this->middleware('admin', ['except' => 'view']);
    }

    public function add()
    {
        if (request()->isMethod('post'))
        {
            $rules = [
                'title'   => ['required'],
                'summary' => ['required', 'min:150', 'max:160'],
                'body'    => ['required'],
            ];

            $this->validate(request(), $rules);

            (new ArticleRepository)->insertArticle(request()->all());

            session()->flash('success', 'خبر با موفقیت افزوده شد.');

            return redirect()->back();
        }

        return view('articles.form');
    }

    public function edit($id)
    {
        $article = (new ArticleRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            $rules = [
                'title'   => ['required'],
                'summary' => ['required', 'min:150', 'max:160'],
                'body'    => ['required'],
            ];

            $this->validate(request(), $rules);

            (new ArticleRepository($article))->updateArticle(request()->all());

            session()->flash('success', 'خبر با موفقیت ویرایش شد.');

            return redirect()->back();
        }

        $article->tags = $article->tags->pluck('name')->implode(',');

        return view('articles.form', compact('article'));
    }

    public function delete($id)
    {
        $article = (new ArticleRepository)->findOrFail($id);

        $article->delete();

        return redirect()->back();
    }

    public function view($slug)
    {
        $article = (new ArticleRepository)->findByOrFail('slug', $slug);
        $articles = (new ArticleRepository)->getLatestArticles();

        $article->increment('hit');

        return view('articles.view', compact('article', 'articles'));
    }

    public function lists()
    {
        $articles = (new ArticleRepository)->getLatestArticles();

        return view('articles.lists', compact('articles'));
    }
}
