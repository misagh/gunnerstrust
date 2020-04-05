@extends('layouts.app')

@section('title', $article->title)
@section('description', $article->summary)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 article mb-3">
                <div class="card">
                    <div class="card-overlay position-relative">
                        <img src="{{ get_cover($article->cover) }}" class="card-img-top" alt="{{ $article->title }}">
                        <h1 class="card-title font-weight-bold position-absolute text-left text-white w-100">{{ $article->title }}</h1>
                    </div>
                    <div class="card-body">
                        <div class="card-info mb-4">
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
                        <div class="card-text">{!! $article->body !!}</div>
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
            <comment-box :commentable="{type: 'article', id: '{{ $article->id }}', auth: '{{ $auth }}'}"></comment-box>
        </div>
    </div>
@endsection
