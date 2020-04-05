@extends('layouts.app')

@section('title', 'نظرات کاربران')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="mt-3">
                    @foreach($comments as $comment)
                        <div class="media mb-3 p-3 shadow-sm {{ $loop->odd ? 'bg-light' : '' }}">
                            <a href="{{ route('users.profile', $comment->user->username) }}">
                                <img class="rounded shadow-sm mr-3" width="50" src="{{ $comment->user->avatar }}">
                            </a>
                            <div class="media-body">
                                <span class="mt-0">
                                    <a class="eng-font font-weight-bold" href="{{ route('users.profile', $comment->user->username) }}">{{ $comment->user->username }}</a>
                                    <small class="float-left text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </span>
                                <span class="d-block mt-1"><a href="{{ $comment->commentable->url }}">{{ $comment->commentable->title }}</a></span>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($comments->links()->paginator->hasPages())
                    <div class="mt-4 row justify-content-center">
                        {{ $comments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
