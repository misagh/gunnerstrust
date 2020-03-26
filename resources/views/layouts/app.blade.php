<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ad682e5c71.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('ورود') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('ثبت نام') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.profile', auth()->user()->username) }}">{{ __('حساب کابری') }}</a>
                                    @if (is_admin())
                                        <div class="dropdown-divider"></div>
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
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
        <div class="container py-4 mt-3 mt-md-4 text-right">
            <div class="row">
                <div class="col-md-6">
                    <p class="logo m-0">Gunners<span class="text-danger">Trust</span></p>
                    <h1 class="small">گانرزتراست، مرجع خبری باشگاه آرسنال انگلیس برای فارسی زبانان</h1>
                </div>
                <div class="col-md-3">
                    <ul class="list-unstyled pt-2">
                        <li><a href="{{ route('articles.lists') }}">آرشیو اخبار</a></li>
                        <li><a href="{{ route('home') }}">برنامه بازی ها</a></li>
                        <li><a href="{{ route('home') }}">جدول لیگ برتر</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="list-unstyled pt-2">
                        <li><a href="{{ url('/') }}">صفحه اصلی</a></li>
                        <li><a href="{{ route('home') }}">درباره ما</a></li>
                        <li><a href="{{ route('home') }}">همکاری با سایت</a></li>
                        <li><a href="{{ route('home') }}">تماس با ما</a></li>
                    </ul>
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
