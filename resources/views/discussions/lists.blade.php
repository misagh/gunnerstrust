@extends('layouts.app')

@section('title', 'تبادل نظر')

@section('content')
    <div class="container">
        <div class="overflow-hidden">
            <h1 class="mt-3 h5 font-weight-bold float-right"><i class="fas fa-glass-cheers fa-lg mr-2"></i>بحث و تبادل نظر هواداری</h1>
        </div>
        <hr class="mt-0 mb-4">
        <div class="row">
            @foreach($discussions as $key => $discussion)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card shadow">
                        <img src="{{ get_cover($discussion->cover) }}" class="card-img-top" alt="{{ $discussion->summary }}">
                        <div class="card-body">
                            <h5 class="card-title mb-0"><a class="stretched-link" href="{{ route('discussions.view', $discussion->slug) }}">{{ $discussion->title }}</a></h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 row justify-content-center">
            {{ $discussions->links() }}
        </div>
    </div>
@endsection
