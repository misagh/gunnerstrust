@extends('layouts.app')

@section('title', $challenge->title)
@section('description', $challenge->summary)

@section('meta')
    <meta property="og:title" content="{{ $challenge->title }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $challenge->summary }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ get_cover($challenge->cover) }}">
    <meta name="image" content="{{ get_cover($challenge->cover) }}">
    <meta itemprop="image" content="{{ get_cover($challenge->cover) }}">
    <meta name="twitter:image:src" content="{{ get_cover($challenge->cover) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $challenge->title }}">
    <meta name="twitter:image:alt" content="{{ $challenge->title }}">
    <meta name="twitter:description" content="{{ $challenge->summary }}">
    <meta name="article:published_time" content="{{ $challenge->created_at->toIso8601String() }}">
@endsection

@section('content')
    <div class="container">
        <div class="card mb-3 shadow">
            <div class="row no-gutters">
                <div class="col-md-4">
                   <img src="{{ get_cover($challenge->cover) }}" class="card-img" alt="{{ $challenge->title }}">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">
                            <a href="{{ route('challenges.view', $challenge->slug) }}">{{ $challenge->title }}</a>
                        </h5>
                        <p class="card-text">{{ $challenge->summary }}</p>
                    </div>
                </div>
            </div>
        </div>
        @if ($auth && $challenge->finished_at->isFuture())
            <div class="rounded p-3 bg-success overflow-hidden">
                <div class="float-right">
                    <a href="{{ route('posts.add', $challenge->id) }}" class="btn btn-success">
                        <i class="fas fa-plus-circle mr-2"></i><span>نوشتن تحلیل جدید</span>
                    </a>
                </div>
                <div class="float-left">
                    <span class="text-white btn btn-success">
                        <span>مهلت شرکت:</span>
                        <span class="font-weight-bold">{{ now()->diffInDays($challenge->finished_at) }}</span>
                        <span>روز</span>
                    </span>
                </div>
            </div>
        @endif
        @if ($posts->isNotEmpty())
            <hr>
            <div class="row row-cols-1 row-cols-md-2">
                @foreach($posts as $post)
                    <div class="col mb-3">
                        <div class="card shadow p-0">
                            <a href="{{ route('posts.view', $post->slug) }}">
                                <img src="{{ get_cover($post->cover) }}" class="card-img-top" alt="{{ $post->title }}">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title m-0">
                                    <a href="{{ route('posts.view', $post->slug) }}">{{ $post->title }}</a>
                                </h5>
                            </div>
                            <div class="card-footer text-center bg-secondary">
                                <div class="eng-font font-weight-bold">
                                    <a class="float-left btn btn-light font-weight-bold py-1" href="{{ route('users.profile', $post->user->username) }}">{{ $post->user->username }}</a>
                                    @if ($post->score)
                                        <span class="float-right text-white mt-1">{{ $post->score }} / 10</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if ($posts->links()->paginator->hasPages())
            <div class="mt-4 row justify-content-center">
                {{ $posts->links() }}
            </div>
        @endif
        <div class="text-right mt-4"><a class="btn btn-outline-secondary" href="{{ route('challenges.lists') }}">آرشیو موضوعات</a></div>
    </div>
@endsection
