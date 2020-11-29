@extends('layouts.app')

@section('title', 'پادکست هایبوری')

@section('content')
    <div class="container">
        <div class="overflow-hidden">
            <h1 class="mt-3 h5 font-weight-bold float-right"><i class="fas fa-podcast fa-lg mr-2"></i>پادکست هایبری</h1>
        </div>
        <hr class="mt-0 mb-4">
        <div class="row">
            @foreach($podcasts as $key => $podcast)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card shadow">
                        <img src="{{ get_cover($podcast->cover) }}" class="card-img-top" alt="{{ $podcast->summary }}">
                        <div class="card-body">
                            <h5 class="card-title mb-0"><a class="stretched-link" href="{{ route('podcasts.view', $podcast->slug) }}">{{ $podcast->title }}</a></h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 row justify-content-center">
            {{ $podcasts->links() }}
        </div>
    </div>
@endsection
