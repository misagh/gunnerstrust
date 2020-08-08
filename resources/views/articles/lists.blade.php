@extends('layouts.app')

@section('title', 'اخبار اضافه شده')

@section('content')
    <div class="container">
        @if (is_admin() || is_author())
        <div class="card mb-3">
            <div class="card-header">اخبار اضافه شده</div>
            <div class="card-body">
                <form method="post" action="{{ route('articles.pin') }}">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-6">
                            <label>خبر اول</label>
                            <select class="form-control" name="pin1">
                                <option value="0" selected>--------------------------------------</option>
                                @foreach($articles as $article)
                                    <option value="{{ $article->id }}" {{ $article->id === intval(@$pins[0]) ? 'selected' : '' }}>{{ $article->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label>خبر دوم</label>
                            <select class="form-control" name="pin2">
                                <option value="0" selected>--------------------------------------</option>
                                @foreach($articles as $article)
                                    <option value="{{ $article->id }}" {{ $article->id === intval(@$pins[1]) ? 'selected' : '' }}>{{ $article->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 text-center mt-3">
                            <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card-deck">
                    @foreach($articles as $article)
                        <div class="card mb-2 shadow">
                            <img class="card-img-top" src="{{ get_cover($article->cover) }}" alt="{{ $article->summary }}">
                            <div class="card-body">
                                <h2 class="h6 font-weight-bold"><a href="{{ route('articles.view', $article->slug) }}" class="stretched-link">{{ $article->title }}</a></h2>
                            </div>
                        </div>
                        @if ($loop->iteration % 3 === 0)
                        </div><div class="card-deck">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-5 row justify-content-center">
            {{ $articles->links() }}
        </div>
    </div>
@endsection
