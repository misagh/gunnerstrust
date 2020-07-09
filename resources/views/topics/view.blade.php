@extends('layouts.app')

@section('title', $current_topic->title)
@section('description', $current_topic->summary)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 article mb-3">
                <div class="card">
                    <div class="card-overlay position-relative">
                        <img src="{{ asset('img/topics/' . $current_topic->name . '.jpg') }}" class="card-img-top" alt="{{ $current_topic->title }}">
                        <h1 class="card-title font-weight-bold position-absolute text-left text-white w-100">{{ $current_topic->title }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
                            {!! $current_topic->body !!}
                            <div class="float-left small mt-5">
                                <a target="_blank" href="{{ route('topics.short', base64url_encode($current_topic->id)) }}" class="rounded text-white bg-secondary py-1 px-3" rel="nofollow">لینک کوتاه</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="list-group p-0">
                    @foreach($topics as $topic)
                    <a href="{{ route('topics.view', $topic->slug) }}" class="list-group-item list-group-item-action {{ $current_topic->slug === $topic->slug ? 'list-group-item-danger active' : '' }}">
                        <i class="fa fa-futbol mr-2"></i>{{ $topic->title }}
                    </a>
                    @endforeach
                </div>
                @foreach($articles as $article)
                    <div class="card shadow mt-3">
                        <img class="img-fluid" src="{{ get_cover($article->cover) }}">
                        <div class="card-body font-weight-bold">
                            <a class="stretched-link" href="{{ route('articles.view', $article->slug) }}">{{ $article->title }}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="comments mt-2" id="comments">
            <comment-box :commentable="{type: 'topic', id: '{{ $current_topic->id }}', auth: '{{ ! empty($auth) }}'}"></comment-box>
        </div>
    </div>
@endsection
