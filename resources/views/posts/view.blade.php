@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->summary)

@section('meta')
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $post->summary }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ get_cover($post->cover) }}">
    <meta name="image" content="{{ get_cover($post->cover) }}">
    <meta itemprop="image" content="{{ get_cover($post->cover) }}">
    <meta name="twitter:image:src" content="{{ get_cover($post->cover) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:image:alt" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->summary }}">
    <meta name="article:published_time" content="{{ $post->created_at->toIso8601String() }}">
    <meta name="article:author" content="{{ $post->user->name }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                @if ($post->challenge)
                <div class="card bg-secondary text-white shadow mb-3 p-3">
                    <a class="stretched-link" href="{{ route('challenges.view', $post->challenge->slug) }}">{{ $post->challenge->title }}</a>
                </div>
                @endif
                <ul class="list-group w-100 p-0 shadow mb-3">
                    <li class="list-group-item bg-danger text-white">
                        <span class="float-right">نویسنده</span>
                        <span class="float-left eng-font font-weight-bold">
                            <a class="stretched-link" href="{{ route('users.profile', $post->user->username) }}">{{ $post->user->username }}</a>
                        </span>
                    </li>
                    <li class="list-group-item bg-danger text-white">
                        <span class="float-right">تاریخ ارسال</span>
                        <span class="float-left eng-font font-weight-bold">{{ $post->created_at->format('Y-m-d') }}</span>
                    </li>
                    <li class="list-group-item bg-danger text-white">
                        <span class="float-right">تعداد بازدید</span>
                        <span class="float-left eng-font font-weight-bold">{{ $post->hit }}</span>
                    </li>
                    <li class="list-group-item bg-danger text-white">
                        <span class="float-right">میانگین امتیاز</span>
                        <span class="float-left eng-font font-weight-bold">{{ $post->score ?? '-' }}</span>
                    </li>
                </ul>
                @if ($posts->isNotEmpty())
                    @foreach($posts as $other_post)
                    <div class="card shadow mb-3">
                        <img class="img-fluid" src="{{ get_cover($other_post->cover) }}">
                        <div class="card-body font-weight-bold">
                            <a class="stretched-link" href="{{ route('posts.view', $other_post->slug) }}">{{ $other_post->title }}</a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="col-md-8 article mb-3">
                <div class="card">
                    <div class="card-overlay position-relative">
                        <img src="{{ get_cover($post->cover) }}" class="card-img-top" alt="{{ $post->title }}">
                        <h1 class="card-title font-weight-bold position-absolute text-left text-white w-100">{{ $post->title }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            {!! $post->body !!}
                            <div class="float-left small mt-3">
                                <a target="_blank" href="{{ route('posts.short', base64url_encode($post->id)) }}" class="rounded text-white bg-secondary py-1 px-3" rel="nofollow">لینک کوتاه</a>
                            </div>
                            @if (is_admin($auth))
                            <div class="float-right small mt-3">
                                <a href="{{ route('posts.edit', $post->id) }}" class="rounded bg-warning py-1 px-3">ویرایش مقاله</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if (! empty($auth) && $auth->id !== $post->user_id)
                    @if ($user_score)
                        <div class="text-center mt-4 mb-2">
                            <span class="bg-dark text-white rounded-right py-2 px-3 m-0 font-weight-bold">امتیاز شما به این مقاله</span><span class="bg-info text-white rounded-left py-2 px-3 m-0 font-weight-bold">{{ $user_score }}</span>
                        </div>
                    @else
                    <div class="card mt-3">
                        <div class="card-header font-weight-bold bg-dark text-white">امتیاز به مقاله</div>
                        <div class="card-body text-center">
                            <p>از ۱ تا ۱۰ چه امتیازی به این مقاله می دهید؟</p>
                            <div class="row justify-content-center align-items-center">
                                <div class="col-md-7 col-lg-4">
                                    <form method="post" action="{{ route('posts.score', $post->id) }}">
                                        @csrf
                                        <div class="input-group">
                                            <select name="score" class="form-control">
                                                @foreach(range(10, 1) as $score)
                                                    <option value="{{ $score }}">{{ $score }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-success">ثبت امتیاز</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>
        <div class="comments mt-2" id="comments">
            <comment-box :commentable="{type: 'post', id: '{{ $post->id }}', auth: '{{ ! empty($auth) }}'}"></comment-box>
        </div>
    </div>
@endsection
