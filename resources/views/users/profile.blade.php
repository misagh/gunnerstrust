@extends('layouts.app')

@section('title', 'پروفایل ' . $profile->username)
@section('description', 'پروفایل کاربری هوادار آرسنال در گانرزتراست | ' . $profile->username)

@section('meta')
    <meta property="og:title" content="{{ 'پروفایل ' . $profile->username }}">
    <meta property="og:site_name" content="GunnersTrust">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ 'پروفایل کاربری هوادار آرسنال در گانرزتراست | ' . $profile->username }}">
    <meta property="og:type" content="article">
    <meta property="og:image" content="{{ $profile->avatar }}">
    <meta name="image" content="{{ $profile->avatar }}">
    <meta itemprop="image" content="{{ $profile->avatar }}">
    <meta name="twitter:image:src" content="{{ $profile->avatar }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ 'پروفایل ' . $profile->username }}">
    <meta name="twitter:image:alt" content="{{ 'پروفایل ' . $profile->username }}">
    <meta name="twitter:description" content="{{ 'پروفایل کاربری هوادار آرسنال در گانرزتراست | ' . $profile->username }}">
@endsection

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-7 col-lg-8 text-center text-md-left">
                        <div class="overflow-hidden">
                            <div class="d-block mb-3">
                                <span class="float-md-left text-white py-1 px-3 rounded font-weight-bold username-{{ $profile->role }}">{{ $profile->title }}</span>
                                <h1 class="font-weight-bold eng-font mt-3 mt-md-0">{{ $profile->username }}</h1>
                            </div>
                            <div class="d-block">
                                <span class="float-right">{{ $profile->name }}@if (! empty($profile->nickname))<br>{{ $profile->nickname }}@endif</span>
                                <span data-toggle="tooltip" title="" class="float-left eng-font font-weight-bold" data-original-title="تعداد بازدید از پروفایل">
                                    <i class="fa fa-eye ml-1"></i>{{ number_format($profile->hits) }}
                                </span>
                            </div>
                        </div>
                        <hr>
                        @if (! empty($profile->details))
                            @include('details.view')
                        @endif
                    </div>
                    <div class="col-md-5 col-lg-4 text-center text-md-right">
                        <div class="d-block">
                            @if ($profile->id === ($auth->id ?? null))
                            <user-avatar :avatar="{ src: '{{ $profile->avatar }}' }"></user-avatar>
                            @else
                            <img class="rounded shadow" src="{{ $profile->avatar }}" width="200">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (! empty($auth) && $auth->id === $profile->id)
            <div class="card mt-4">
                <div class="card-header font-weight-bold text-white bg-secondary">ویرایش اطلاعات کاربری</div>
                <div class="card-body">
                    <form action="{{ route('users.edit') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">نام کامل</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ $auth->name }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">آدرس ایمیل</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" dir="ltr" value="{{ $auth->email }}" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">ذخیره تغییرات</button>
                    </form>
                </div>
            </div>
            @include('details.form')
            <div class="card mt-3">
                <div class="card-header font-weight-bold text-white bg-secondary">تغییر رمز عبور</div>
                <div class="card-body">
                    <form action="{{ route('users.password') }}" method="post">
                        @csrf
                        @if (! empty($auth->password))
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">رمز عبور فعلی</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password_current" dir="ltr" required>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">رمز عبور جدید</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" dir="ltr" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">تکرار رمز عبور جدید</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password_confirmation" dir="ltr" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-3">ذخیره تغییرات</button>
                    </form>
                </div>
            </div>
        @elseif (! empty($auth))
            <div class="card shadow mt-3">
                <div class="card-body">
                    <div class="d-block">
                        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#sendMessage" aria-expanded="false" aria-controls="sendMessage">ارسال پیام خصوصی</button>
                    </div>
                    <div class="collapse" id="sendMessage">
                        <div class="card card-body bg-dark text-center mt-3">
                            <form action="{{ route('messages.send') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_to_id" value="{{ $profile->id }}">
                                <input type="hidden" name="return_url" value="{{ url()->current() }}">
                                <textarea rows="5" name="body" class="form-control border border-dark" required></textarea>
                                <button type="submit" class="btn btn-success mt-3">ارسال پیام</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
