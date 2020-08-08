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
    @include('home.articles')
</div>

<div class="container mt-4">
    @include('home.interviews')
</div>

<div class="container mt-4">
    @include('home.podcasts')
</div>

<div class="container mt-4">
    @include('home.comments')
</div>

@endsection
