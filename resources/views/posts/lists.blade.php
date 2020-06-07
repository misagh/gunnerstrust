@extends('layouts.app')

@section('title', 'مقالات ارسالی')

@section('content')
    <div class="container">
        @if ($notverified->isNotEmpty())
        <div class="card shadow mb-4">
            <div class="card-header bg-danger text-white font-weight-bold">مقالات تایید نشده</div>
            <div class="card-body">
                @if ($notverified->isEmpty())
                    <div class="alert alert-info shadow-sm m-2">مقاله تایید نشده ای وجود ندارد.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>موضوع</th>
                                <th>تاریخ ارسال</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notverified as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($post->challenge)
                                        <a class="d-block" href="{{ route('challenges.view', $post->challenge->slug) }}">{{ $post->challenge->title }}</a>
                                        @else
                                        <a class="d-block" href="{{ route('posts.edit', $post->id) }}">{{ $post->title }}</a>
                                        @endif
                                        @if (is_admin($auth))
                                            <a class="d-block font-weight-bold eng-font" href="{{ route('posts.edit', $post->id) }}">{{ $post->user->username }}</a>
                                        @endif
                                    </td>
                                    <td class="eng-font">{{ $post->created_at }}</td>
                                    <td class="eng-font">
                                        <a href="{{ route('posts.edit', $post->id) }}"><i class="fas fa-envelope-open-text fa-lg"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        @endif
        @if ($verified->isNotEmpty())
        <div class="card shadow">
            <div class="card-header bg-success text-white font-weight-bold">مقالات منتشر شده</div>
            <div class="card-body">
                @if ($verified->isEmpty())
                    <div class="alert alert-info shadow-sm m-2">مقاله منتشر شده ای وجود ندارد.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>موضوع</th>
                                <th>تاریخ ارسال</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($verified as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if ($post->challenge)
                                    <td>
                                        @if ($post->challenge)
                                            <a class="d-block" href="{{ route('challenges.view', $post->challenge->slug) }}">{{ $post->challenge->title }}</a>
                                        @else
                                            <a class="d-block" href="{{ route('posts.view', $post->slug) }}">{{ $post->title }}</a>
                                        @endif
                                        @if (is_admin($auth))
                                            <a class="d-block font-weight-bold eng-font" href="{{ route('posts.edit', $post->id) }}">{{ $post->user->username }}</a>
                                        @endif
                                    </td>
                                    @endif
                                    <td class="eng-font">{{ $post->created_at }}</td>
                                    <td class="eng-font">
                                        @if (is_admin($auth))
                                        <a href="{{ route('posts.edit', $post->id) }}"><i class="fas fa-envelope-open-text fa-lg"></i></a>
                                        @else
                                        <a href="{{ route('posts.view', $post->slug) }}" target="_blank"><i class="fas fa-external-link-alt fa-lg"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($verified->links()->paginator->hasPages())
                        <div class="mt-4 row justify-content-center">
                            {{ $verified->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @endif
    </div>
@endsection
