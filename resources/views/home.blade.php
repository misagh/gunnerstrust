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
    <div class="card-deck">
        @foreach($pinned as $pin)
            <div class="card shadow bg-dark text-white">
                <img src="{{ get_cover($pin->cover) }}" class="card-img-top" alt="{{ $pin->title }}">
                <div class="card-body">
                    <h4 class="card-title font-weight-bold"><a class="stretched-link" href="{{ route('articles.view', $pin->slug) }}">{{ $pin->title }}</a></h4>
                    <p class="card-text">{{ $pin->summary }}</p>
                    <p class="card-text">
                        <small>{{ $pin->created_at->diffForHumans() }}</small>
                        @if ($pin->comments_count > 0)
                        <span class="float-left eng-font font-weight-bold"><i class="fas fa-comment-dots ml-1"></i>{{ $pin->comments_count }}</span>
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card-deck mt-sm-4">
        @foreach($articles as $key => $article)
            <div class="card shadow">
                <img src="{{ get_cover($article->cover) }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><a class="stretched-link" href="{{ route('articles.view', $article->slug) }}">{{ $article->title }}</a></h5>
                    <p class="card-text">
                        <small>{{ $article->created_at->diffForHumans() }}</small>
                        @if ($article->comments_count > 0)
                        <span class="float-left eng-font font-weight-bold"><i class="fas fa-comment-dots ml-1"></i>{{ $article->comments_count }}</span>
                        @endif
                    </p>
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
