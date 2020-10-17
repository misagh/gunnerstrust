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

<div class="container px-2">
    @if (! empty($pinned))
        <div class="card shadow bg-darkred mb-3">
            <div class="card-body p-1">
                <div class="row no-gutters">
                    <div class="col-md-7 col-lg-7 order-0 order-md-1">
                        <img src="{{ get_cover($pinned->cover) }}" alt="{{ $pinned->summary }}">
                    </div>
                    <div class="col-md-5 col-lg-5 pl-lg-0 pl-lg-4 pl-md-3 text-white order-1 order-md-0">
                        <div class="d-lg-flex flex-column h-100 mt-3 mt-lg-4 px-3 px-md-0">
                            <h2 class="font-weight-bold h4 text-center article-title">
                                <a href="{{ route('articles.view', $pinned->slug) }}" class="stretched-link">{{ $pinned->title }}</a>
                            </h2>
                            <hr class="d-none d-lg-block bg-secondary mx-3 mt-4">
                            <p class="mt-3 mt-md-3 text-justify px-md-3 d-none d-md-block">{{ $pinned->summary }}</p>
                            <div class="mt-auto text-center mb-4 d-none d-lg-block">
                                <div class="mb-3">
                                    <span class="bg-white text-dark py-2 px-3">مطالعه و ارسال نظر</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row no-gutters updates-list">
        <div class="col-md-7">
            @include('updates.box_list')
            <div class="mt-5 row justify-content-center">
                {{ $updates->links() }}
            </div>
        </div>
        <div class="col-md-5 pl-md-3">
            @include('home.articles')
            @include('home.interviews')
            @include('home.podcasts')
        </div>
    </div>
</div>

@endsection
