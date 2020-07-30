@extends('layouts.app')

@section('title', $podcast->title)
@section('description', $podcast->summary)

@section('meta')
    <meta property="og:title" content="{{ $podcast->title }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $podcast->summary }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ get_cover($podcast->cover) }}">
    <meta name="image" content="{{ get_cover($podcast->cover) }}">
    <meta itemprop="image" content="{{ get_cover($podcast->cover) }}">
    <meta name="twitter:image:src" content="{{ get_cover($podcast->cover) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $podcast->title }}">
    <meta name="twitter:image:alt" content="{{ $podcast->title }}">
    <meta name="twitter:description" content="{{ $podcast->summary }}">
    <meta name="article:published_time" content="{{ $podcast->created_at->toIso8601String() }}">
    <meta name="article:author" content="GunnersTrust">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <ul class="list-group w-100 p-0 shadow mb-3">
                    <li class="list-group-item bg-orange text-white">
                        <span class="float-right">تاریخ انتشار</span>
                        <span class="float-left font-weight-bold">{{ shamsi_format($podcast->created_at, 'd F Y') }}</span>
                    </li>
                    <li class="list-group-item bg-orange text-white">
                        <span class="float-right">تعداد بازدید</span>
                        <span class="float-left eng-font font-weight-bold">{{ $podcast->hit }}</span>
                    </li>
                </ul>
                @if ($podcasts->isNotEmpty())
                    @foreach($podcasts as $other_podcast)
                    <div class="card shadow mb-3">
                        <img class="img-fluid" src="{{ get_cover($other_podcast->cover) }}">
                        <div class="card-body font-weight-bold">
                            <a class="stretched-link" href="{{ route('podcasts.view', $other_podcast->slug) }}">{{ $other_podcast->title }}</a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="col-md-8 article mb-3">
                <div class="card">
                    <div class="card-overlay position-relative">
                        <img src="{{ get_cover($podcast->cover) }}" class="card-img-top" alt="{{ $podcast->title }}">
                        <h1 class="card-title font-weight-bold position-absolute text-left text-white w-100">{{ $podcast->title }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            <p>{!! $podcast->summary !!}</p>
                            @if (! empty($podcast->embed))
                            <div class="my-4 pt-3 embed-video">
                                {!! $podcast->embed_script !!}
                            </div>
                            @endif
                            <p>{!! $podcast->body !!}</p>
                            <div class="float-left small mt-3">
                                <a target="_blank" href="{{ route('podcasts.short', base64url_encode($podcast->id)) }}" class="rounded text-white bg-secondary py-1 px-3" rel="nofollow">لینک کوتاه</a>
                            </div>
                            @if (is_admin($auth))
                            <div class="float-right small mt-3">
                                <a href="{{ route('podcasts.edit', $podcast->id) }}" class="rounded bg-warning py-1 px-3">ویرایش پادکست</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="comments mt-2" id="comments">
            <comment-box :commentable="{type: 'podcast', id: '{{ $podcast->id }}', auth: '{{ ! empty($auth) }}'}"></comment-box>
        </div>
    </div>
@endsection
