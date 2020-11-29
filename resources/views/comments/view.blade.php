@extends('layouts.app')

@section('title', $comment->title)
@section('description', $comment->summary)

@section('meta')
    <meta property="og:title" content="{{ $comment->title }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $comment->summary }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ $user->avatar }}">
    <meta name="image" content="{{ $user->avatar }}">
    <meta itemprop="image" content="{{ $user->avatar }}">
    <meta name="twitter:image:src" content="{{ $user->avatar }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $comment->title }}">
    <meta name="twitter:image:alt" content="{{ $comment->title }}">
    <meta name="twitter:description" content="{{ $comment->summary }}">
    <meta name="article:published_time" content="{{ $comment->created_at->toIso8601String() }}">
    <meta name="article:author" content="{{ $user->name }}">
@endsection

@section('content')
    <div class="container">
        <div class="card shadow bg-success text-white">
            <div class="card-body">
                <div class="media">
                    <a href="{{ route('users.profile', $user->username) }}">
                        <img class="rounded shadow-sm mr-3" width="50" src="{{ $user->avatar }}">
                    </a>
                    <div class="media-body">
                        <span class="mt-0">
                            <a class="eng-font font-weight-bold" href="{{ route('users.profile', $user->username) }}">{{ $user->username }}</a>
                        </span>
                        <span class="d-block mt-1"><a href="{{ $comment->commentable->url }}">{{ $comment->commentable->title }}</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="comments mt-3" id="comments">
            <comment-box :commentable="{comment: '{{ $comment->id }}', auth: '{{ ! empty($auth) }}'}"></comment-box>
        </div>
        <div class="mt-3 text-center">
            <a class="btn btn-info px-5" href="{{ $comment->commentable->url }}">دیدن همه نظرات این بحث</a>
        </div>
    </div>
@endsection
