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
            <div class="card shadow bg-dark text-white">
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
        @endforeach
    </div>
    <div class="card-deck mt-sm-4">
        @foreach($articles as $key => $article)
            <div class="card shadow">
                <img src="{{ get_cover($article->cover) }}" class="card-img-top" alt="...">
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
    <div class="mt-5 row justify-content-center">
        {{ $articles->links() }}
    </div>
</div>
@endsection
