@extends('layouts.app')

@section('title', $tag->name)
@section('description', 'آخرین اخبار مربوط به هشتگ ' . $tag->name)

@section('meta')
    <meta property="og:title" content="{{ $tag->name }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ 'آخرین اخبار مربوط به هشتگ ' . $tag->name }}">
    <meta property="og:type" content="article">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $tag->name }}">
    <meta name="twitter:image:alt" content="{{ $tag->name }}">
    <meta name="twitter:description" content="{{ 'آخرین اخبار مربوط به هشتگ ' . $tag->name }}">
@endsection

@section('content')
    <div class="container px-2">
        <div class="row no-gutters updates-list">
            <div class="col-12">
                <div class="bg-purple text-white mb-3 shadow py-3 px-3 text-center">
                    <h1 class="font-weight-bold mb-0">{{ $tag->name }}</h1>
                </div>
                @include('updates.box_list')
                <div class="mt-5 row justify-content-center">
                    {{ $updates->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
