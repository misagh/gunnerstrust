<!doctype html>
<html lang="fa">
<head>
    @include('layouts.ga')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | GunnersTrust</title>
    <meta name="description" content="@yield('description')">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Metal+Mania" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ad682e5c71.js" crossorigin="anonymous"></script>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta name="google-site-verification" content="e5MJx7cW7IXtU5wxsklQqRabBFlp0NgISYr6ZkdK6lM" />
    @yield('meta')
</head>
<body>
<div id="app" class="rtl">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <span>گانرزتراست</span>
                <span class="eng-font">GunnersTrust</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto"></ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-4">
                        <a class="nav-link" href="{{ route('posts.add') }}">{{ __('نوشتن مطلب') }}</a>
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
                            <a class="dropdown-item" href="{{ route('users.list') }}">آرسنالی ها</a>
                        </div>
                    </li>
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
                                {{ $auth->name ?? $auth->email }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('users.profile', $auth->username) }}">{{ __('حساب کابری') }}</a>
                                <a class="dropdown-item" href="{{ route('notifications') }}">{{ __('اطلاعیه ها') }}
                                    @if ($new_notifications)
                                    <span class="badge badge-success ml-1">{{ $new_notifications }}</span>
                                    @endif
                                </a>
                                <a class="dropdown-item" href="{{ route('users.messages') }}">{{ __('پیام خصوصی') }}
                                    @if ($new_messages)
                                        <span class="badge badge-success ml-1">{{ $new_messages }}</span>
                                    @endif
                                </a>
                                <div class="dropdown-divider"></div>
                                @if (is_admin($auth) || is_author($auth))
                                    <a class="dropdown-item" href="{{ route('articles.add') }}">{{ __('افزودن خبر') }}</a>
                                    <a class="dropdown-item" href="{{ route('articles.lists') }}">{{ __('ویرایش اخبار') }}</a>
                                    <div class="dropdown-divider"></div>
                                @endif
                                @if (is_admin($auth))
                                    <a class="dropdown-item" href="{{ route('challenges.add') }}">{{ __('افزودن چالش') }}</a>
                                    <a class="dropdown-item" href="{{ route('challenges.lists') }}">{{ __('ویرایش چالش ها') }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('fixtures.add') }}">{{ __('افزودن منوی بازی') }}</a>
                                    <a class="dropdown-item" href="{{ route('fixtures.lists') }}">{{ __('ویرایش منوی بازی‌ها') }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('teams.add') }}">{{ __('افزودن تیم') }}</a>
                                    <a class="dropdown-item" href="{{ route('teams.lists') }}">{{ __('ویرایش تیم‌ها') }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('stadiums.add') }}">{{ __('افزودن استادیوم') }}</a>
                                    <a class="dropdown-item" href="{{ route('stadiums.lists') }}">{{ __('ویرایش استادیوم‌ها') }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('interviews.add') }}">{{ __('افزودن مصاحبه') }}</a>
                                    <a class="dropdown-item" href="{{ route('interviews.lists') }}">{{ __('ویرایش مصاحبه‌ها') }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('podcasts.add') }}">{{ __('افزودن پادکست') }}</a>
                                    <a class="dropdown-item" href="{{ route('podcasts.lists') }}">{{ __('ویرایش پادکست‌ها') }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('admin.upload') }}">{{ __('آپلود') }}</a>
                                    <a class="dropdown-item" href="{{ route('posts.lists') }}">{{ __('بررسی پست کابران') }}</a>
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
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <header class="shadow mt-5">
        <div class="container text-center position-relative">
            <div class="eng-font mt-3 text-white">
                <span class="title">Gunners<span class="text-danger">Trust</span></span>
                <span class="slogan font-weight-bold ml-md-3">Arsenal Fan Club Website in Iran</span>
            </div>
            @if (empty($auth))
            <div class="row mt-2">
                <div class="col-12">
                    <a href="{{ route('login') }}" class="btn btn-light text-black-50 btn-sm">ورود با نام کاربری</a>
                    <a href="{{ route('socialite.login', 'google') }}" class="btn btn-primary text-white btn-sm">ورود با اکانت گوگل</a>
                    <a href="{{ route('register') }}" class="btn btn-light text-black-50 btn-sm">ثبت نام در سایت</a>
                </div>
            </div>
            @endif
        </div>
    </header>

    <main class="py-4">
        @if (! empty($new_notifications))
            <div class="container">
                <div class="alert alert-warning shadow">
                    <a href="{{ route('notifications') }}">
                        <span class="mr-1"><i class="fas fa-compact-disc fa-spin fa-lg"></i></span>
                        <b>شما {{ $new_notifications }} اطلاعیه جدید دارید. لطفا اطلاعیه های خود را بررسی کنید.</b>
                    </a>
                </div>
            </div>
        @endif
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
        @if (! empty($auth) && ! empty($auth->username) && empty($auth->details))
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
{{--    <div class="fixed-bottom bottom-menu p-2 shadow">--}}
{{--        <div class="container p-0 text-center">--}}
{{--            <div class="row">--}}
{{--                <div class="col-6">--}}
{{--                    <div class="btn-group dropup w-100">--}}
{{--                        <button type="button" class="btn btn-link text-white btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            <span><i class="fas fa-lg fa-street-view mr-2"></i>بخش هواداری</span>--}}
{{--                        </button>--}}
{{--                        <div class="dropdown-menu">--}}
{{--                            <a class="dropdown-item" href="#">Action</a>--}}
{{--                            <a class="dropdown-item" href="#">Another action</a>--}}
{{--                            <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="#">Separated link</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-6">--}}
{{--                    <div class="btn-group dropup w-100">--}}
{{--                        <button type="button" class="btn btn-link text-white btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            <span><i class="fas fa-lg fa-street-view mr-2"></i>بخش هواداری</span>--}}
{{--                        </button>--}}
{{--                        <div class="dropdown-menu">--}}
{{--                            <a class="dropdown-item" href="#">Action</a>--}}
{{--                            <a class="dropdown-item" href="#">Another action</a>--}}
{{--                            <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="#">Separated link</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-3 col-6 mb-2 mb-md-0">--}}
{{--                    <a href="{{ route('topics.view', 'اخبار-و-شایعات-نقل-و-انتقالات') }}" class="btn btn-orange btn-block">نقل و انتقالات</a>--}}
{{--                </div>--}}
{{--                <div class="col-md-3 col-6 mb-2 mb-md-0">--}}
{{--                    <a href="{{ route('topics.view', 'بحث-و-تبادل-نظر-فوتبالی') }}" class="btn btn-info btn-block">بحث فوتبالی</a>--}}
{{--                </div>--}}
{{--                <div class="col-md-3 col-6">--}}
{{--                    <a href="{{ route('topics.view', 'قهوه-خونه') }}" class="btn btn-success btn-block">قهوه خونه</a>--}}
{{--                </div>--}}
{{--                <div class="col-md-3 col-6">--}}
{{--                    <a href="{{ route('posts.add') }}" class="btn btn-danger btn-block">ارسال مطلب</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>

<footer class="bg-dark text-white mt-auto">
    <div class="container py-4 text-right">
        <div class="row">
            <div class="col-12">
                <p class="logo m-0">Gunners<span class="text-danger">Trust</span></p>
                <h1 class="small">گانرزتراست، مرجع خبری باشگاه آرسنال انگلیس برای فارسی زبانان</h1>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12 eng-font pb-5 pb-md-3">
                <span class="float-left ltr"><i class="far fa-copyright"></i> {{ date('Y') }} GunnersTrust</span>
                <span class="float-right ltr">
                    <a href="https://t.me/GunnersTrust" class="mr-2" target="_blank"><i class="fab fa-telegram fa-lg"></i></a>
                    <a href="https://instagram.com/GunnersTrust1" class="mr-2" target="_blank"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="https://twitter.com/GunnersTrust" target="_blank"><i class="fab fa-twitter fa-lg"></i></a>
				</span>
            </div>
        </div>
    </div>
</footer>

<script src="{{ mix('/js/app.js') }}" defer></script>

</body>
</html>
