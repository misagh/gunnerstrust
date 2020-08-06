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

<div class="container articles">
    <div class="row">
        <div class="col-md-8 mb-2">
            <div id="articleSlider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach($articles_group1 as $key => $article)
                        <li data-target="#articleSlider" data-slide-to="{{ $key }}" @if ($key === $article_active) class="active" @endif></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach($articles_group1 as $key => $article)
                        <div class="carousel-item {{ $key === $article_active ? 'active' : '' }}">
                            <img src="{{ get_cover($article->cover) }}" class="d-block w-100" alt="{{ $article->summary }}">
                            <div class="carousel-caption">
                                <h2 class="carousel-caption-title text-white font-weight-bold p-3">
                                    <a href="{{ route('articles.view', $article->slug) }}">{{ $article->title }}</a>
                                </h2>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#articleSlider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#articleSlider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <div class="col-md-4 pr-md-1 pl-md-0 nice-scroll side-articles">
            <ul class="list-group pr-0">
            @foreach($articles_group2 as $key => $article)
                <li class="list-group-item rounded-0">
                    <h3 class="mb-2 h6">
                        <i class="fa fa-futbol mr-2"></i><a class="stretched-link" href="{{ route('articles.view', $article->slug) }}">{{ $article->title }}</a>
                    </h3>
                    <small>{{ $article->summary }}</small>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
</div>

<div class="container home-cards">
    <hr>
    <div class="row">
        @if ($podcasts->isNotEmpty())
        <div class="col-md-6">
            @foreach($podcasts as $podcast)
                @if ($loop->iteration === 1)
                <div class="card">
                    <img src="{{ get_cover($podcast->cover) }}" class="card-img-top" alt="...">
                    <div class="card-title text-center">
                        <a href="{{ route('podcasts.view', $podcast->slug) }}">{{ $podcast->title }}</a>
                    </div>
                </div>
                @else
                    <div class="card mt-1">
                        <div class="card-body py-3 bg-orange text-white">
                            <i class="fas fa-podcast fa-lg mr-1"></i>
                            <a class="font-weight-bold stretched-link" href="{{ route('podcasts.view', $podcast->slug) }}">{{ $podcast->title }}</a>
                        </div>
                    </div>
                @endif
            @endforeach
{{--            <a class="btn btn-block btn-secondary mt-1 rounded-0" href="{{ route('podcasts.lists') }}">فهرست همه پادکست ها</a>--}}
            <hr class="d-md-none">
        </div>
        @endif
        @if ($interviews->isNotEmpty())
        <div class="col-md-6 mb-2">
            @foreach($interviews as $interview)
                @if ($loop->iteration === 1)
                    <div class="card">
                        <img src="{{ get_cover($interview->cover) }}" class="card-img-top" alt="...">
                        <div class="card-title text-center">
                            <a href="{{ route('interviews.view', $interview->slug) }}">{{ $interview->title }}</a>
                        </div>
                    </div>
                @else
                    <div class="card mt-1">
                        <div class="card-body py-3 bg-purple text-white">
                            <i class="fas fa-user-astronaut fa-lg mr-1"></i>
                            <a class="font-weight-bold stretched-link" href="{{ route('interviews.view', $interview->slug) }}">{{ $interview->title }}</a>
                        </div>
                    </div>
                @endif
            @endforeach
{{--            <a class="btn btn-block btn-secondary mt-1 rounded-0" href="{{ route('interviews.lists') }}">فهرست همه مصاحبه ها</a>--}}
        </div>
        @endif
    </div>
</div>

<div class="container">
    <hr>
    <div class="card-columns">
    @foreach($comments as $comment)
        <div class="card">
            <div class="card-body">
                <span class="card-title text-secondary"><img class="rounded-circle shadow-sm mr-2" width="30" src="{{ $comment->user->avatar }}">{{ $comment->commentable->title }}</span>
                <p class="card-text mt-3">
                    <a href="{{ $comment->commentable->url }}" class="stretched-link">{{ str_limit($comment->body, 500) }}</a>
                </p>
            </div>
        </div>
    @endforeach
    </div>
    <div class="text-right">
        <a href="{{ route('users.list') }}" class="btn btn-secondary rounded-0">کاربران سایت</a>
        <a href="{{ route('comments.list') }}" class="btn btn-success rounded-0">مشاهده همه نظرات</a>
    </div>
</div>

{{--<div class="container d-none">--}}
{{--    @if (! empty($fixtures['today']))--}}
{{--        <div class="row mb-2">--}}
{{--            <div class="col-12">--}}
{{--                @include('fixtures.menu', ['fixture' => $fixtures['today']])--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--    @if (empty($fixtures['today']) && (! empty($fixtures['next']) || ! empty($fixtures['previous'])))--}}
{{--        <div class="row mb-1">--}}
{{--            <div class="col-lg-6 mb-2">--}}
{{--                @if (! empty($fixtures['next']))--}}
{{--                    @include('fixtures.menu', ['fixture' => $fixtures['next'], 'bg_color' => 'info'])--}}
{{--                @endif--}}
{{--            </div>--}}
{{--            <div class="col-lg-6">--}}
{{--                @if (! empty($fixtures['previous']))--}}
{{--                    @include('fixtures.menu', ['fixture' => $fixtures['previous'], 'bg_color' => 'danger'])--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--</div>--}}

@endsection
