@extends('layouts.app')

@section('title', 'پایگاه خبری باشگاه آرسنال در ایران')
@section('description', 'گانرزتراست، مرجع خبری باشگاه آرسنال انگلیس برای فارسی زبانان. گزارش بازی های تیم، مقالات تحلیلی فنی و بررسی عملکرد بازیکنان و کادر فنی، آخرین اخبار و حواشی آرسنال در رقابت های لیگ برتر انگلیس، جام حذفی، لیگ قهرمانان و لیگ اروپا.')

@section('meta')
    <meta property="og:title" content="پایگاه خبری باشگاه آرسنال در ایران">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="گانرزتراست، مرجع خبری باشگاه آرسنال انگلیس برای فارسی زبانان. گزارش بازی های تیم، مقالات تحلیلی فنی و بررسی عملکرد بازیکنان و کادر فنی، آخرین اخبار و حواشی آرسنال در رقابت های لیگ برتر انگلیس، جام حذفی، لیگ قهرمانان و لیگ اروپا.">
    <meta property="og:image" content="{{ asset('img/favicon/android-chrome-512x512.png') }}">
    <meta name="image" content="{{ asset('img/favicon/android-chrome-512x512.png') }}">
    <meta itemprop="image" content="{{ asset('img/favicon/android-chrome-512x512.png') }}">
    <meta name="twitter:image:src" content="{{ asset('img/cover.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="پایگاه خبری باشگاه آرسنال در ایران">
    <meta name="twitter:description" content="گانرزتراست، مرجع خبری باشگاه آرسنال انگلیس برای فارسی زبانان. گزارش بازی های تیم، مقالات تحلیلی فنی و بررسی عملکرد بازیکنان و کادر فنی، آخرین اخبار و حواشی آرسنال در رقابت های لیگ برتر انگلیس، جام حذفی، لیگ قهرمانان و لیگ اروپا.">
@endsection

@section('content')

<div class="container">
    @if (! empty($fixtures['today']))
        <div class="row mb-2">
            <div class="col-12">
                @include('fixtures.menu', ['fixture' => $fixtures['today']])
            </div>
        </div>
    @endif
    @if (empty($fixtures['today']) && (! empty($fixtures['next']) || ! empty($fixtures['previous'])))
        <div class="row mb-1">
            <div class="col-lg-6 mb-2">
                @if (! empty($fixtures['next']))
                    @include('fixtures.menu', ['fixture' => $fixtures['next'], 'bg_color' => 'info'])
                @endif
            </div>
            <div class="col-lg-6">
                @if (! empty($fixtures['previous']))
                    @include('fixtures.menu', ['fixture' => $fixtures['previous'], 'bg_color' => 'danger'])
                @endif
            </div>
        </div>
    @endif
</div>

@if (! empty($podcast))
<div class="container mb-3">
    <div class="row">
        <div class="col-12 text-center">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body">
                    <h5 class="mb-0 font-weight-bold">
                        <a href="{{ route('podcasts.view', $podcast->slug) }}" class="stretched-link mx-1">{{ $podcast->title }}</a>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container articles">
    @if (! empty($challenge))
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 shadow">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <a href="{{ route('challenges.view', $challenge->slug) }}">
                            <img src="{{ get_cover($challenge->cover) }}" class="card-img" alt="{{ $challenge->title }}">
                        </a>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">
                                <a href="{{ route('challenges.view', $challenge->slug) }}">{{ $challenge->title }}</a>
                            </h5>
                            <p class="card-text">{{ $challenge->summary }}</p>
                        </div>
                        <div class="card-footer border-0 overflow-hidden mb-2 bg-transparent">
                            <div class="float-left">
                                <a class="btn btn-success" href="{{ route('posts.add', $challenge->id) }}">نوشتن تحلیل جدید</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
    @endif
    <div class="card-deck">
        @foreach($pinned as $pin)
            @if ($posts->isEmpty() || $comments->isNotEmpty() || $interviews->isNotEmpty() ? true : $loop->index === 0)
            <div class="card shadow bg-dark text-white {{ $loop->index === 0 && $posts->isNotEmpty() ? 'ml-sm-3 mr-sm-0' : '' }}">
                <img src="{{ get_cover($pin->cover) }}" class="card-img-top" alt="{{ $pin->title }}">
                <div class="card-body">
                    <h4 class="card-title font-weight-bold"><a class="stretched-link" href="{{ route('articles.view', $pin->slug) }}">{{ $pin->title }}</a></h4>
                    <p class="card-text mb-0">{{ $pin->summary }}</p>
                </div>
                <div class="card-footer p-3">
                    <small>{{ $pin->created_at->diffForHumans() }}</small>
                    @if ($pin->comments_count > 0)
                        <span class="float-left eng-font font-weight-bold"><i class="fas fa-comment-dots ml-1"></i>{{ $pin->comments_count }}</span>
                    @else
                        <small class="float-left bg-info text-white py-1 px-2 rounded">ارسال نظر</small>
                    @endif
                </div>
            </div>
            @endif
        @endforeach
        @if ($posts->isNotEmpty() || $comments->isNotEmpty() || $interviews->isNotEmpty())
            <div class="card bg-transparent border-0">
                @if ($posts->isNotEmpty() && $interviews->isEmpty())
                    <ul class="list-group p-0 shadow">
                        @foreach($posts as $post)
                            <li class="list-group-item text-white bg-secondary py-0 pl-0 pr-2">
                                <a href="{{ route('posts.view', $post->slug) }}">
                                    <img src="{{ get_cover($post->cover) }}" width="100" alt="{{ $post->summary }}">
                                    <span class="h5 font-weight-bold ml-2">{{ $post->title }}</span>
                                </a>
                                <a href="{{ route('users.profile', $post->user->username) }}" class="small float-left my-2">{{ $post->user->username }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if ($interviews->isNotEmpty())
                    <div class="bg-white text-dark shadow rounded p-3">
                        <span class="font-weight-bold">مصاحبه با هواداران</span>
                        <hr class="my-1">
                        <ul class="list-group p-0 mt-2">
                            @foreach($interviews as $interview)
                                <li class="list-group-item text-white bg-purple py-0 pl-0 pr-2">
                                    <a href="{{ route('interviews.view', $interview->slug) }}">
                                        <img src="{{ get_cover($interview->cover) }}" width="100" alt="{{ $interview->summary }}">
                                        <span class="h6 font-weight-bold ml-2">{{ $interview->title }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if ($comments->isNotEmpty())
                    <div class="bg-white text-dark shadow rounded mt-2 p-3">
                        <span class="font-weight-bold">آخرین نظردهندگان</span>
                        <hr class="my-1">
                        <div class="text-center overflow-auto text-nowrap nice-scroll pb-2 comment-users">
                            @foreach($comments as $comment)
                                <a href="{{ $comment->commentable->url }}" class="d-inline-block mx-1 mt-1 text-center text-dark eng-font">
                                    <img class="rounded-circle shadow-sm mx-auto border border-danger" width="50" src="{{ $comment->user->avatar }}">
                                    <span class="d-block">{{ $comment->user->username }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
    <div class="card-deck mt-sm-4">
        @foreach($articles_group1 as $key => $article)
            <div class="card shadow">
                <img src="{{ get_cover($article->cover) }}" class="card-img-top" alt="{{ $article->summary }}">
                <div class="card-body">
                    <h5 class="card-title mb-0"><a class="stretched-link" href="{{ route('articles.view', $article->slug) }}">{{ $article->title }}</a></h5>
                </div>
                <div class="card-footer p-2">
                    <small>{{ $article->created_at->diffForHumans() }}</small>
                    @if ($article->comments_count > 0)
                        <span class="float-left eng-font font-weight-bold"><i class="fas fa-comment-dots ml-1"></i>{{ $article->comments_count }}</span>
                    @else
                        <small class="float-left bg-success text-white py-1 px-2 rounded">ارسال نظر</small>
                    @endif
                </div>
            </div>
            @if ($loop->iteration % 3 === 0)
            </div><div class="card-deck mt-sm-4">
            @endif
        @endforeach
    </div>
    @if ($articles_group2->isNotEmpty())
    <div class="card-group">
        @foreach($articles_group2 as $key => $article)
            <div class="card border {{ $loop->iteration % 2 === 0 ? 'ml-sm-1' : 'mr-sm-1' }}">
                <div class="card-body">
                    <h5 class="card-title mb-2">
                        <i class="fa fa-futbol mr-2"></i><a class="stretched-link" href="{{ route('articles.view', $article->slug) }}">{{ $article->title }}</a>
                    </h5>
                    <small>{{ $article->summary }}</small>
                </div>
            </div>
            @if ($loop->iteration % 2 === 0)
            </div><div class="card-group mt-sm-2">
            @endif
        @endforeach
    </div>
    @endif
    <div class="mt-5 row justify-content-center">
        {{ $articles->links() }}
    </div>
</div>
@endsection
