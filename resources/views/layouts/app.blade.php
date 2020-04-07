<!doctype html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | GunnersTrust</title>
    <meta name="description" content="@yield('description')">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Metal+Mania" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ad682e5c71.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    @yield('meta')
</head>
<body>
<div id="app" class="rtl">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span>گانرزتراست</span>
                <span class="eng-font">GunnersTrust</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                </ul>
                <ul class="navbar-nav ml-auto">
                    @if (empty($auth))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('ورود') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('ثبت نام') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ $auth->name }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('users.profile', $auth->username) }}">{{ __('حساب کابری') }}</a>
                                <a class="dropdown-item" href="{{ route('users.messages') }}">{{ __('پیام خصوصی') }}</a>
                                <div class="dropdown-divider"></div>
                                @if (is_admin($auth) || is_author($auth))
                                    <a class="dropdown-item" href="{{ route('articles.add') }}">{{ __('افزودن خبر') }}</a>
                                    <a class="dropdown-item" href="{{ route('articles.lists') }}">{{ __('ویرایش اخبار') }}</a>
                                    <div class="dropdown-divider"></div>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('خروج') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @if ($topics->isNotEmpty())
                        <li class="nav-item dropdown">
                            <a id="navbarDropdownTopics" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span>تاپیک ها</span> <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownTopics">
                                @foreach($topics as $topic)
                                <a class="dropdown-item" href="{{ route('topics.view', $topic->slug) }}">{{ $topic->title }}</a>
                                @endforeach
                            </div>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdownMenu" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <span>منوی سایت</span> <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenu">
                                <a class="dropdown-item" href="{{ route('comments.list') }}">نظرات کاربران</a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <header class="shadow">
        <div class="container text-white text-center position-relative">
            <div class="eng-font mt-4">
                <span class="title">Gunners<span class="text-danger">Trust</span></span>
                <span class="slogan font-weight-bold ml-md-3">Arsenal Fan Club Website in Iran</span>
            </div>
        </div>
    </header>

    <main class="py-4">
        @if (! empty($new_messages))
            <div class="container">
                <div class="alert alert-warning shadow">
                    <a href="{{ route('users.messages') }}">
                        <span class="mr-1"><i class="fas fa-compact-disc fa-spin fa-lg"></i></span>
                        <b>شما {{ $new_messages }} پیام خصوصی جدید دارید. لطفا صندوق پیام ها را بررسی کنید.</b>
                    </a>
                </div>
            </div>
        @endif
        @if (! empty($auth) && empty($auth->details))
            <div class="container">
                <div class="alert alert-warning shadow">
                    <a href="{{ route('users.profile', $auth->username) }}">
                        <span class="mr-1"><i class="fas fa-compact-disc fa-spin fa-lg"></i></span>
                        <b>اطلاعات هواداری شما کامل نیست. لطفا با ورود به حساب کاربری، آنها را تکمیل کنید.</b>
                    </a>
                </div>
            </div>
        @endif
        @if (session()->has('errors'))
            <div class="container">
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach(session('errors')->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="container">
                <div class="alert alert-danger">
                    <p class="m-0 p-0">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        @if (session()->has('success'))
            <div class="container">
                <div class="alert alert-success">
                    <p class="m-0 p-0">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @yield('content')
    </main>
</div>

<footer class="bg-dark text-white mt-auto">
    <div class="container py-4 text-right">
        <div class="row">
            <div class="col">
                <p class="logo m-0">Gunners<span class="text-danger">Trust</span></p>
                <h1 class="small">گانرزتراست، مرجع خبری باشگاه آرسنال انگلیس برای فارسی زبانان</h1>
            </div>
        </div>
    </div>
    <div class="bottom eng-font py-3">
        <div class="container">
            <div class="row">
                <div class="col">
                    <span class="float-left ltr"><i class="far fa-copyright"></i> {{ date('Y') }} GunnersTrust</span>
                    <span class="float-right ltr">
						<a href="https://t.me/GunnersTrust" class="mr-3" target="_blank"><i class="fab fa-telegram fa-lg"></i></a>
						<a href="https://twitter.com/GunnersTrust" target="_blank"><i class="fab fa-twitter fa-lg"></i></a>
					</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('js/app.js') }}" defer></script>

</body>
</html>
