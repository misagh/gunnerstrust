@extends('layouts.app')

@section('title', $update->title)
@section('description', $update->summary)

@section('meta')
    <meta property="og:title" content="{{ $update->title }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $update->summary }}">
    <meta property="og:type" content="article">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $update->title }}">
    <meta name="twitter:image:alt" content="{{ $update->title }}">
    <meta name="twitter:description" content="{{ $update->summary }}">
    <meta name="article:published_time" content="{{ $update->created_at->toIso8601String() }}">
    <meta name="article:author" content="{{ $update->user->name }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col article" id="article-body">
                @include('updates.box', ['view' => true])
            </div>
        </div>
        <div class="comments mt-2" id="comments">
            <comment-box :commentable="{type: 'update', id: '{{ $update->id }}', auth: '{{ ! empty($auth) }}'}"></comment-box>
        </div>
    </div>
@endsection
