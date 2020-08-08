@extends('layouts.app')

@section('title', 'مصاحبه با هواداران آرسنال')

@section('content')
    <div class="container">
        <div class="overflow-hidden">
            <h1 class="mt-3 h5 font-weight-bold float-right"><i class="fas fa-microphone-alt fa-lg mr-2"></i>مصاحبه اختصاصی با هواداران آرسنال</h1>
        </div>
        <hr class="mt-0 mb-4">
        <div class="row">
            @foreach($interviews as $key => $interview)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow">
                        <img src="{{ get_cover($interview->cover) }}" class="card-img-top" alt="{{ $interview->summary }}">
                        <div class="card-body">
                            <h5 class="card-title mb-0"><a class="stretched-link" href="{{ route('interviews.view', $interview->slug) }}">{{ $interview->title }}</a></h5>
                        </div>
                        <div class="card-footer text-right px-2">
                            <span class="bg-secondary text-white rounded py-1 px-3 eng-font font-weight-bold">{{ $interview->user->username }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 row justify-content-center">
            {{ $interviews->links() }}
        </div>
    </div>
@endsection
