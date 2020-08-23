@extends('layouts.app')

@section('title', $interview->title)
@section('description', $interview->summary)

@section('meta')
    <meta property="og:title" content="{{ $interview->title }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $interview->summary }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ get_cover($interview->cover) }}">
    <meta name="image" content="{{ get_cover($interview->cover) }}">
    <meta itemprop="image" content="{{ get_cover($interview->cover) }}">
    <meta name="twitter:image:src" content="{{ get_cover($interview->cover) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $interview->title }}">
    <meta name="twitter:image:alt" content="{{ $interview->title }}">
    <meta name="twitter:description" content="{{ $interview->summary }}">
    <meta name="article:published_time" content="{{ $interview->created_at->toIso8601String() }}">
    <meta name="article:author" content="{{ $interview->user->name }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3 order-1 order-md-0">
                <ul class="list-group w-100 p-0 shadow mb-3">
                    <li class="list-group-item bg-info text-white">
                        <span class="float-right">مصاحبه شونده</span>
                        <span class="float-left eng-font font-weight-bold">
                            <a class="stretched-link" href="{{ route('users.profile', $interview->user->username) }}">{{ $interview->user->username }}</a>
                        </span>
                    </li>
                    <li class="list-group-item bg-info text-white">
                        <span class="float-right">تاریخ مصاحبه</span>
                        <span class="float-left font-weight-bold">{{ shamsi_format($interview->created_at, 'd F Y') }}</span>
                    </li>
                    <li class="list-group-item bg-info text-white">
                        <span class="float-right">تعداد بازدید</span>
                        <span class="float-left eng-font font-weight-bold">{{ $interview->hit }}</span>
                    </li>
                </ul>
                @if ($interviews->isNotEmpty())
                    @foreach($interviews as $other_interview)
                    <div class="card shadow mb-3">
                        <img class="img-fluid" src="{{ get_cover($other_interview->cover) }}">
                        <div class="card-body font-weight-bold">
                            <a class="stretched-link" href="{{ route('interviews.view', $other_interview->slug) }}">{{ $other_interview->title }}</a>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="col-md-8 article mb-3 order-0 order-md-1">
                <div class="card">
                    <div class="card-overlay position-relative">
                        <img src="{{ get_cover($interview->cover) }}" class="card-img-top" alt="{{ $interview->title }}">
                    </div>
                    <div class="card-body">
                        <h1 class="card-title font-weight-bold w-100">{{ $interview->title }}</h1>
                        <hr>
                        <div class="card-text">
                            <p>{!! $interview->summary !!}</p>
                            @if (! empty($interview->embed))
                            <div class="my-4 embed-video shadow">
                                {!! $interview->embed !!}
                            </div>
                            @endif
                            @if (! empty($interview->file))
                            <div class="my-4 pt-3 text-center">
                                <audio controls autoplay class="w-100">
                                    <source src="{{ $interview->file }}" type="audio/mpeg">
                                </audio>
                            </div>
                            @endif
                            <p>{!! $interview->body !!}</p>
                            <div class="float-left small mt-3">
                                <a target="_blank" href="{{ route('interviews.short', base64url_encode($interview->id)) }}" class="rounded text-white bg-secondary py-1 px-3" rel="nofollow">لینک کوتاه</a>
                            </div>
                            @if (is_admin($auth))
                            <div class="float-right small mt-3">
                                <a href="{{ route('interviews.edit', $interview->id) }}" class="rounded bg-warning py-1 px-3">ویرایش مصاحبه</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="comments mt-2" id="comments">
            <comment-box :commentable="{type: 'interview', id: '{{ $interview->id }}', auth: '{{ ! empty($auth) }}'}"></comment-box>
        </div>
    </div>
@endsection
