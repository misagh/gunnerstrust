@extends('layouts.app')

@section('title', 'آرسنالی ها')

@section('content')
    <div class="container">
        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 row-cols-xl-6">
        @foreach($gunners as $gunner)
            <div class="col mb-4">
                <div class="card text-center shadow">
                    <img src="{{ $gunner->avatar }}" class="card-img-top shadow-sm">
                    <div class="card-body px-2">
                        <h5 class="card-title eng-font font-weight-bold mb-0"><a class="stretched-link" href="{{ route('users.profile', $gunner->username) }}">{{ $gunner->username }}</a></h5>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
        @if ($gunners->links()->paginator->hasPages())
            <div class="mt-4 row justify-content-center">
                {{ $gunners->links() }}
            </div>
        @endif
    </div>
@endsection
