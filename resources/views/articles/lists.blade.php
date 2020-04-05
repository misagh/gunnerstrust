@extends('layouts.app')

@section('title', 'اخبار اضافه شده')

@section('content')
    <div class="container">
        <div class="card">
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
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        @foreach($articles as $article)
                            <tr>
                                <td><a href="{{ route('articles.view', $article->slug) }}">{{ $article->title }}</a></td>
                                <td><a href="{{ route('articles.edit', $article->id) }}" class="mr-2"><i class="fas fa-lg fa-pen-square"></i></a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="mt-5 row justify-content-center">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
