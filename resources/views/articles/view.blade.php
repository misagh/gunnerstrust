@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->summary)

@section('meta')
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $article->summary }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ get_cover($article->cover) }}">
    <meta name="image" content="{{ get_cover($article->cover) }}">
    <meta itemprop="image" content="{{ get_cover($article->cover) }}">
    <meta name="twitter:image:src" content="{{ get_cover($article->cover) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:image:alt" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ $article->summary }}">
    <meta name="article:published_time" content="{{ $article->created_at->toIso8601String() }}">
    <meta name="article:author" content="{{ $article->user->name }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 article mb-3" id="article-body">
                <div class="card">
                    <div class="card-overlay position-relative">
                        <img src="{{ get_cover($article->cover) }}" class="card-img-top" alt="{{ $article->title }}">
                        <h1 class="card-title font-weight-bold position-absolute text-left text-white w-100">{{ $article->title }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-info mb-4" id="article-info">
                            <div class="alert alert-secondary rounded-0 shadow-sm overflow-hidden">
                                <span class="float-right">
                                    <span class="mr-2">مترجم:</span><a href="{{ route('users.profile', $article->user->username) }}">{{ $article->user->name }}</a>
                                </span>
                                <span class="float-left">
                                    <span data-toggle="tooltip" title="" class="d-block" data-original-title="بازدید: {{ $article->hit }}">
                                        {{ $article->hit }}<i class="fa fa-eye ml-2"></i>
                                    </span>
                                </span>
                            </div>
                            <hr class="w-100">
                        </div>
                        <div class="card-text">
                            {!! format_body($article->body) !!}
                            <div class="float-left small mt-5" id="article-details">
                                <a target="_blank" href="{{ route('articles.short', base64url_encode($article->id)) }}" class="rounded text-white bg-secondary py-1 px-3" rel="nofollow">لینک کوتاه</a>
                                <a target="_blank" href="{{ $article->source }}" class="rounded text-white bg-info py-1 px-3">لینک منبع</a>
                            </div>
                            @if (is_admin($auth) || is_author($auth))
                            <div class="float-right small mt-5">
                                <a href="{{ route('articles.edit', $article->id) }}" class="rounded bg-warning py-1 px-3">ویرایش خبر</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="list-group p-0">
                    @foreach($articles as $article_list)
                    <a href="{{ route('articles.view', $article_list->slug) }}" class="list-group-item list-group-item-action {{ $article_list->id === $article->id ? 'list-group-item-danger active' : '' }}">
                        <i class="fa fa-futbol mr-2"></i>{{ $article_list->title }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="comments mt-2" id="comments">
            <comment-box :commentable="{type: 'article', id: '{{ $article->id }}', auth: '{{ ! empty($auth) }}'}"></comment-box>
        </div>
    </div>
@endsection
