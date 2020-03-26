@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">اخبار اضافه شده</div>
            <div class="card-body">
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
            </div>
        </div>
    </div>
@endsection
