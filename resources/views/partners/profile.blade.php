@extends('layouts.app')

@section('title', 'پروفایل ' . $partner->name_fa)

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="float-right">
                    <h1 class="font-weight-bold">{{ $partner->name_fa }}</h1>
                    <h2 class="h5 eng-font my-3">{{ $partner->name_en }}</h2>
                </div>
                <div class="float-left">
                    @if (! empty($partner->link_telegram))
                        <a href="{{ $partner->link_telegram }}" target="_blank" class="btn btn-primary px-5 d-block mb-2"><i class="fab fa-telegram-plane fa-lg mr-2"></i>کانال تلگرام</a>
                    @endif
                    @if (! empty($partner->link_instagram))
                        <a href="{{ $partner->link_instagram }}" target="_blank" class="btn btn-danger px-5 d-block mb-2"><i class="fab fa-instagram fa-lg mr-2"></i>پیج اینستاگرام</a>
                    @endif
                    @if (! empty($partner->link_twitter))
                        <a href="{{ $partner->link_twitter }}" target="_blank" class="btn btn-info px-5 d-block mb-2"><i class="fab fa-twitter fa-lg mr-2"></i>صفحه توییتر</a>
                    @endif
                    @if (! empty($partner->link_website))
                        <a href="{{ $partner->link_website }}" target="_blank" class="btn btn-success px-5 d-block"><i class="fas fa-globe fa-lg mr-2"></i>آدرس وبسایت</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
