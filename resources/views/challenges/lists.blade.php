@extends('layouts.app')

@section('title', 'کارشناسی و تحلیل')
@section('description', 'در بخش کارشناسی و تحلیل، شما هواداران آرسنال در مورد موضوع انتخاب شده هفته مطالبی را خواهید نوشت و پس از بررسی و ویرایش در سایت به نام خود شما منتشر خواهد شد.')

@section('meta')
    <meta property="og:title" content="کارشناسی و تحلیل">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="در بخش کارشناسی و تحلیل، شما هواداران آرسنال در مورد موضوع انتخاب شده هفته مطالبی را خواهید نوشت و پس از بررسی و ویرایش در سایت به نام خود شما منتشر خواهد شد.">
    <meta property="og:image" content="{{ asset('img/cover.png') }}">
    <meta name="image" content="{{ asset('img/cover.png') }}">
    <meta itemprop="image" content="{{ asset('img/cover.png') }}">
    <meta name="twitter:image:src" content="{{ asset('img/cover.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="کارشناسی و تحلیل">
    <meta name="twitter:description" content="در بخش کارشناسی و تحلیل، شما هواداران آرسنال در مورد موضوع انتخاب شده هفته مطالبی را خواهید نوشت و پس از بررسی و ویرایش در سایت به نام خود شما منتشر خواهد شد.">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @foreach($challenges as $challenge)
                <div class="col-12 {{ $loop->index > 0 ? 'col-md-6' : '' }}">
                    <div class="card mb-3 shadow">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <a href="{{ route('challenges.view', $challenge->slug) }}">
                                    <img src="{{ get_cover($challenge->cover) }}" class="card-img" alt="{{ $challenge->title }}">
                                </a>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title {{ $loop->index === 0 ? 'font-weight-bold' : '' }}">
                                        <a href="{{ route('challenges.view', $challenge->slug) }}">{{ $challenge->title }}</a>
                                    </h5>
                                    @if ($loop->index === 0)
                                        <p class="card-text">{{ $challenge->summary }}</p>
                                    @else
                                        <p class="small text-muted text-right m-0 p-0">
                                            @if (is_admin($auth))
                                                <a class="btn btn-warning btn-sm mr-2" href="{{ route('challenges.edit', $challenge->id) }}">ویرایش</a>
                                            @endif
                                            <span>{{ $challenge->finished_at->diffForHumans() }}</span>
                                        </p>
                                    @endif
                                </div>
                                @if ($loop->index === 0)
                                <div class="card-footer border-0 overflow-hidden mb-2 bg-transparent">
                                    <div class="float-left">
                                        @if (is_admin($auth))
                                            <a class="btn btn-warning" href="{{ route('challenges.edit', $challenge->id) }}">ویرایش</a>
                                        @endif
                                        <a class="btn btn-success" href="{{ route('posts.add', $challenge->id) }}">نوشتن تحلیل جدید</a>
                                    </div>
                                    <div class="float-right bg-secondary text-white py-1 px-3 rounded mt-2">
                                        <span>مهلت شرکت:</span>
                                        <span class="font-weight-bold">{{ now()->diffInDays($challenge->finished_at) }}</span>
                                        <span>روز</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($loop->index === 0)
                        <hr>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mt-5 row justify-content-center">
            {{ $challenges->links() }}
        </div>
    </div>
@endsection
