@extends('layouts.app')

@section('title', $fixture->title)
@section('description', $fixture->summary)

@section('meta')
    <meta property="og:title" content="{{ $fixture->title }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $fixture->summary }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ $fixture->stadium->logo }}">
    <meta name="image" content="{{ $fixture->stadium->logo }}">
    <meta itemprop="image" content="{{ $fixture->stadium->logo }}">
    <meta name="twitter:image:src" content="{{ $fixture->stadium->logo }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $fixture->title }}">
    <meta name="twitter:image:alt" content="{{ $fixture->title }}">
    <meta name="twitter:description" content="{{ $fixture->summary }}">
    <meta name="article:author" content="GunnersTrust">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @include('fixtures.menu', ['fixture' => $fixture, 'bg_color' => 'light', 'no_menu_link' => true])
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-md-8 article mb-3">
                <div class="card">
                    <div class="card-overlay position-relative">
                        <img src="{{ $fixture->stadium->logo }}" class="card-img-top" alt="{{ $fixture->title }}">
                        <h1 class="card-title font-weight-bold position-absolute text-left text-white w-100">{{ $fixture->title }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <div class="alert alert-light shadow text-center small">{!! $fixture->summary !!}</div>
                            <hr>
                            {!! $fixture->body !!}
                            <div class="float-left small mt-3">
                                <a target="_blank" href="{{ route('fixtures.short', base64url_encode($fixture->id)) }}" class="rounded text-white bg-secondary py-1 px-3" rel="nofollow">لینک کوتاه</a>
                            </div>
                            @if (is_admin($auth))
                            <div class="float-right small mt-3">
                                <a href="{{ route('fixtures.edit', $fixture->id) }}" class="rounded bg-warning py-1 px-3">ویرایش بازی</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                @if ($fixtures_next->isNotEmpty())
                    @foreach($fixtures_next as $next_fixture)
                        @include('fixtures.menu', ['fixture' => $next_fixture, 'compact' => true, 'bg_color' => 'info'])
                    @endforeach
                @endif
                <div class="card bg-dark text-white shadow text-center my-2">
                    <div class="card-body p-3">
                        <span class="font-weight-bold">{{ fixture_title($fixture) }}</span>
                    </div>
                </div>
                @if ($fixtures_previous->isNotEmpty())
                    @foreach($fixtures_previous as $previous_fixture)
                        @include('fixtures.menu', ['fixture' => $previous_fixture, 'compact' => true, 'bg_color' => 'warning'])
                    @endforeach
                @endif
            </div>
        </div>
        @if ($articles->isNotEmpty())
        <div class="row mt-2">
            <div class="col-12">
                <ul class="nav nav-tabs font-weight-bold" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="articles-tab" data-toggle="tab" href="#articles" role="tab" aria-controls="articles" aria-selected="true">اخبار و حواشی بازی</a>
                    </li>
{{--                    <li class="nav-item" role="presentation">--}}
{{--                        <a class="nav-link disabled" id="motm-tab" data-toggle="tab" href="#motm" role="tab" aria-controls="motm" aria-selected="false">بهترین بازیکن زمین</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item" role="presentation">--}}
{{--                        <a class="nav-link disabled" id="stats-tab" data-toggle="tab" href="#stats" role="tab" aria-controls="stats" aria-selected="false">آمار و جزییات</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item" role="presentation">--}}
{{--                        <a class="nav-link disabled" id="twitts-tab" data-toggle="tab" href="#twitts" role="tab" aria-controls="twitts" aria-selected="false">نظرات هواداران</a>--}}
{{--                    </li>--}}
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="articles" role="tabpanel" aria-labelledby="articles-tab">
                        <div class="row mt-3 mb-2">
                            @foreach($articles as $article)
                                <div class="col-md-6">
                                    <div class="card mb-2 shadow-sm">
                                        <div class="row no-gutters">
                                            <div class="col-md-4">
                                                <a href="{{ route('articles.view', $article->slug) }}">
                                                    <img src="{{ get_cover($article->cover) }}" class="card-img" alt="{{ $article->title }}">
                                                </a>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h6 class="card-title font-weight-bold mb-0">
                                                        <a href="{{ route('articles.view', $article->slug) }}">{{ $article->title }}</a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
{{--                    <div class="tab-pane fade" id="motm" role="tabpanel" aria-labelledby="motm-tab"></div>--}}
{{--                    <div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats-tab"></div>--}}
{{--                    <div class="tab-pane fade" id="twitts" role="tabpanel" aria-labelledby="twitts-tab"></div>--}}
                </div>
            </div>
        </div>
        @endif
        <div class="comments mt-2" id="comments">
            <comment-box :commentable="{type: 'fixture', id: '{{ $fixture->id }}', auth: '{{ ! empty($auth) }}'}"></comment-box>
        </div>
    </div>
@endsection
