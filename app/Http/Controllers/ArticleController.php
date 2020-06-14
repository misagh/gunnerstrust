<?php

namespace App\Http\Controllers;

use Telegram;
use App\Repositories\ArticleRepository;

class ArticleController extends Controller {

    public function __construct()
    {
        $this->middleware('author', ['except' => ['view', 'short']]);
    }

    public function short($id)
    {
        $id = intval(base64url_decode($id));

        if ($id > 0)
        {
            $article = (new ArticleRepository)->findOrFail($id);

            return redirect()->route('articles.view', $article->slug);
        }

        abort(404);
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

            $article = (new ArticleRepository)->insertArticle(request()->all());

            $this->updateTelegram($article);

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
        $pins = (new ArticleRepository)->getPinnedArticles()->pluck('id');

        return view('articles.lists', compact('articles', 'pins'));
    }

    public function pin()
    {
        (new ArticleRepository)->updatePins();

        $pin1 = (new ArticleRepository)->find(intval(request('pin1')));
        $pin1 AND $pin1->setPin(1);

        $pin2 = (new ArticleRepository)->find(intval(request('pin2')));
        $pin2 AND $pin2->setPin(2);

        return redirect()->back();
    }

    private function updateTelegram($article)
    {
        try
        {
            if (! empty(env('TELEGRAM_BOT_TOKEN')))
            {
                $link = route('articles.short', base64url_encode($article->id));

                $telegram = [
                    'chat_id'    => '@gunnerstrust',
                    'photo'      => get_cover($article->cover),
                    'caption'    => "\xE2\x9A\xBD <b>{$article->title}</b>\n{$article->summary}\n\n\xF0\x9F\x92\xA5 <a href='{$link}'>برای خواندن متن خبر و ارسال نظر کلیک کنید</a>\n\n@GunnersTrust",
                    'parse_mode' => 'HTML',
                ];

                Telegram::sendPhoto($telegram);
            }
        }
        catch (\Exception $e)
        {
            // Pass
        }
    }
}
