@extends('layouts.app')

@section('content')

<div class="container articles">
    <div class="card-deck">
        @foreach($pinned as $pin)
            <div class="card shadow bg-dark text-white">
                <img src="{{ get_cover($pin->cover) }}" class="card-img-top" alt="{{ $pin->title }}">
                <div class="card-body">
                    <h5 class="card-title"><a class="stretched-link" href="{{ route('articles.view', $pin->slug) }}">{{ $pin->title }}</a></h5>
                    <p class="card-text">{{ $pin->summary }}</p>
                    <p class="card-text"><small>Last updated 3 mins ago</small></p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="card-deck mt-sm-4">
        @foreach($articles as $key => $article)
            <div class="card shadow">
                <img src="{{ get_cover($article->cover) }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><a class="stretched-link" href="{{ route('articles.view', $article->slug) }}">{{ $article->title }}</a></h5>
                    <p class="card-text"><small>Last updated 3 mins ago</small></p>
                </div>
            </div>
            @if ($loop->iteration % 3 === 0)
            </div><div class="card-deck mt-sm-4">
            @endif
        @endforeach
    </div>
    <div class="mt-5 row justify-content-center">
        {{ $articles->links() }}
    </div>
</div>
@endsection
