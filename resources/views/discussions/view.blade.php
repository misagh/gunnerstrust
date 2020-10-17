@extends('layouts.app')

@section('title', $discussion->title)
@section('description', $discussion->summary)

@section('meta')
    <meta property="og:title" content="{{ $discussion->title }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $discussion->summary }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ get_cover($discussion->cover) }}">
    <meta name="image" content="{{ get_cover($discussion->cover) }}">
    <meta itemprop="image" content="{{ get_cover($discussion->cover) }}">
    <meta name="twitter:image:src" content="{{ get_cover($discussion->cover) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $discussion->title }}">
    <meta name="twitter:image:alt" content="{{ $discussion->title }}">
    <meta name="twitter:description" content="{{ $discussion->summary }}">
    <meta name="article:published_time" content="{{ $discussion->created_at->toIso8601String() }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3 order-1 order-md-0">
                <ul class="list-group w-100 p-0 shadow mb-3">
                    <li class="list-group-item bg-info text-white">
                        <span class="float-right">تاریخ شروع بحث</span>
                        <span class="float-left font-weight-bold">{{ shamsi_format($discussion->created_at, 'd F Y') }}</span>
                    </li>
                </ul>
                @if ($discussions->isNotEmpty())
                    @foreach($discussions as $other_discussion)
                    <div class="card shadow mb-3">
                        <img class="img-fluid d-none d-md-block" src="{{ get_cover($other_discussion->cover) }}">
                        <div class="card-body font-weight-bold">
                            <a class="stretched-link" href="{{ route('discussions.view', $other_discussion->slug) }}">{{ $other_discussion->title }}</a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="col-md-8 article mb-3 order-0 order-md-1">
                <div class="card">
                    <div class="card-overlay position-relative">
                        <img src="{{ get_cover($discussion->cover) }}" class="card-img-top" alt="{{ $discussion->title }}">
                    </div>
                    <div class="card-body">
                        <h1 class="card-title font-weight-bold w-100">{{ $discussion->title }}</h1>
                        <hr>
                        <div class="card-text">
                            <p>{!! $discussion->body !!}</p>
                            @if ($options)
                            <form method="post" action="{{ route('discussions.vote', $discussion->id) }}">
                                @csrf
                                <div class="card bg-light shadow mt-3 mb-2">
                                    <div class="card-body">
                                        @foreach($options as $option)
                                            <p>
                                                @if ($auth && empty($user_vote->id))
                                                <span><input type="radio" name="option_id" value="{{ $option['id'] }}" required></span>
                                                @endif
                                                <span class="{{ ($user_vote->option_id ?? null) === $option['id'] ? 'font-weight-bold text-success' : 'text-secondary' }}">{{ $option['title'] }}</span>
                                                <span class="float-left small eng-font">{{ $option['percent'] }}%</span>
                                            </p>
                                            <div class="progress my-1">
                                                <div class="progress-bar progress-bar-striped bg-{{ $option['color'] }}" role="progressbar" style="width: {{ $option['percent'] }}%" aria-valuenow="{{ $option['percent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @endforeach
                                        @if ($auth && empty($user_vote))
                                            <p class="text-center">
                                                <button type="submit" class="btn btn-success px-3 mt-3">ارسال رای</button>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </form>
                            @endif
                            <div class="float-left small mt-3">
                                <a target="_blank" href="{{ route('discussions.short', base64url_encode($discussion->id)) }}" class="rounded text-white bg-secondary py-1 px-3" rel="nofollow">لینک کوتاه</a>
                            </div>
                            @if (is_admin($auth))
                            <div class="float-right small mt-3">
                                <a href="{{ route('discussions.edit', $discussion->id) }}" class="rounded bg-warning py-1 px-3">ویرایش بحث</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="comments mt-2" id="comments">
            <comment-box :commentable="{type: 'discussion', id: '{{ $discussion->id }}', auth: '{{ ! empty($auth) }}'}"></comment-box>
        </div>
    </div>
@endsection
