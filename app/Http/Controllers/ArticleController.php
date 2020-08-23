<?php

namespace App\Http\Controllers;

use Telegram;
use App\Repositories\UserRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\FixtureRepository;
use App\Repositories\PartnerRepository;

class ArticleController extends Controller {

    public function __construct()
    {
        $this->middleware('author', ['except' => ['view', 'short', 'lists']]);
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
                'summary' => ['nullable', 'min:150', 'max:160'],
                'body'    => ['required'],
            ];

            $this->validate(request(), $rules);

            $article = (new ArticleRepository)->insertArticle(request()->all());

            $this->updateTelegram($article);

            session()->flash('success', 'خبر با موفقیت افزوده شد.');

            return redirect()->back();
        }

        $fixtures = (new FixtureRepository)->getLatestFixtures();
        $partners = (new PartnerRepository)->getAllRecords();
        $users = (new UserRepository)->getSelectUsers();

        return view('articles.form', compact('fixtures', 'partners', 'users'));
    }

    public function edit($id)
    {
        $article = (new ArticleRepository)->findOrFail($id);

        if (request()->isMethod('post'))
        {
            $rules = [
                'title'   => ['required'],
                'summary' => ['nullable', 'min:150', 'max:160'],
                'body'    => ['required'],
            ];

            $this->validate(request(), $rules);

            (new ArticleRepository($article))->updateArticle(request()->all());

            session()->flash('success', 'خبر با موفقیت ویرایش شد.');

            return redirect()->back();
        }

        $article->tags = $article->tags->pluck('name')->implode(',');

        $fixtures = (new FixtureRepository)->getLatestFixtures();
        $partners = (new PartnerRepository)->getAllRecords();
        $users = (new UserRepository)->getSelectUsers();

        return view('articles.form', compact('article', 'fixtures', 'partners', 'users'));
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
        $articles = (new ArticleRepository)->getLatestArticles(12);
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
                $short_link = route('articles.short', base64url_encode($article->id));
                $instant_view_link = 'https://t.me/iv?url=' . route('articles.view', $article->slug) . '&rhash=53dc04175a4911';

                $telegram = [
                    'chat_id'    => '@gunnerstrust',
                    'text'       => "<a href='{$instant_view_link}'>\xE2\x9A\xBD</a> <b>{$article->title}</b>\n\n\xF0\x9F\x92\xA5 برای ارسال نظر به لینک زیر بروید\n\xF0\x9F\x91\x87\xF0\x9F\x91\x87\xF0\x9F\x91\x87\xF0\x9F\x91\x87\xF0\x9F\x91\x87\xF0\x9F\x91\x87\n{$short_link}\n\xE2\x9E\x96\xE2\x9E\x96\xE2\x9E\x96\xE2\x9E\x96\xE2\x9E\x96\xE2\x9E\x96",
                    'parse_mode' => 'HTML',
                ];

                Telegram::sendMessage($telegram);
            }
        }
        catch (\Exception $e)
        {
            // Pass
        }
    }
}
