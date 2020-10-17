@extends('layouts.app')

@section('title', 'منوی مدیریت')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header font-weight-bold">منوی بازی ها</div>
            <div class="card-body">
                <a class="dropdown-item" href="{{ route('fixtures.add') }}">{{ __('افزودن منوی بازی') }}</a>
                <a class="dropdown-item" href="{{ route('fixtures.lists') }}">{{ __('ویرایش منوی بازی‌ها') }}</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('teams.add') }}">{{ __('افزودن تیم') }}</a>
                <a class="dropdown-item" href="{{ route('teams.lists') }}">{{ __('ویرایش تیم‌ها') }}</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('stadiums.add') }}">{{ __('افزودن استادیوم') }}</a>
                <a class="dropdown-item" href="{{ route('stadiums.lists') }}">{{ __('ویرایش استادیوم‌ها') }}</a>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header font-weight-bold">تبادل نظر</div>
            <div class="card-body">
                <a class="dropdown-item" href="{{ route('discussions.add') }}">{{ __('افزودن بحث') }}</a>
                <a class="dropdown-item" href="{{ route('discussions.lists') }}">{{ __('ویرایش بحث‌ها') }}</a>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header font-weight-bold">مصاحبه با هواداران</div>
            <div class="card-body">
                <a class="dropdown-item" href="{{ route('interviews.add') }}">{{ __('افزودن مصاحبه') }}</a>
                <a class="dropdown-item" href="{{ route('interviews.lists') }}">{{ __('ویرایش مصاحبه‌ها') }}</a>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header font-weight-bold">پادکست هایبوری</div>
            <div class="card-body">
                <a class="dropdown-item" href="{{ route('podcasts.add') }}">{{ __('افزودن پادکست') }}</a>
                <a class="dropdown-item" href="{{ route('podcasts.lists') }}">{{ __('ویرایش پادکست‌ها') }}</a>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header font-weight-bold">موارد دیگر</div>
            <div class="card-body">
                <a class="dropdown-item" href="{{ route('admin.upload') }}">{{ __('آپلود') }}</a>
                <a class="dropdown-item" href="{{ route('posts.lists') }}">{{ __('بررسی پست کابران') }}</a>
            </div>
        </div>
    </div>
@endsection
