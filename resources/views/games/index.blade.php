@extends('layouts.app')

@section('title', 'مسابقه حدس نتیجه بازی')

@section('content')
    <div class="container">
        @if (! empty($fixture))
            @include('fixtures.menu', ['bg_color' => 'purple'])
            @if (now() < $fixture->played_at)
            <div class="card bg-purple text-white shadow mb-4">
                <div class="card-body text-center">
                    <h1 class="font-weight-bold h4 mb-3">حدس نتیجه این بازی</h1>
                    <form action="{{ route('games.add') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col">
                                <label class="eng-font">{{ $fixture->team2->name_en }}</label>
                                <select name="score2" class="form-control eng-font">
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $i === ($user_guess->score2 ?? null) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col">
                                <label class="eng-font">{{ $fixture->team1->name_en }}</label>
                                <select name="score1" class="form-control eng-font">
                                    @for ($i = 0; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $i === ($user_guess->score1 ?? null) ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg px-5 mt-3" {{ auth()->check() ? '' : 'disabled' }}>
                            {{ empty($user_guess) ? 'ثبت نتیجه' : 'تغییر نتیجه ثبت شده' }}
                        </button>
                        @if (! auth()->check())
                            <hr>
                            <p class="mt-3 font-weight-bold">برای شرکت در مسابقه باید وارد سایت شوید</p>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <a href="{{ route('login') }}" class="btn btn-dark text-black-50 btn-sm">ورود با نام کاربری</a>
                                    <a href="{{ route('socialite.login', 'google') }}" class="btn btn-success text-white btn-sm">ورود با اکانت گوگل</a>
                                    <a href="{{ route('register') }}" class="btn btn-dark text-black-50 btn-sm">ثبت نام در سایت</a>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            @else
                @if (! empty($user_guess))
                <div class="card bg-dark text-white shadow mb-2">
                    <div class="card-body text-center">
                        <h1 class="font-weight-bold h4 mb-3">حدس شما از نتیجه این بازی</h1>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <h2 class="eng-font font-weight-bold h5 mb-3">{{ $fixture->team2->name_en }}</h2>
                                <span class="eng-font font-weight-bold h4">{{ $user_guess->score2 }}</span>
                            </div>
                            <div class="col-6">
                                <h2 class="eng-font font-weight-bold h5 mb-3">{{ $fixture->team1->name_en }}</h2>
                                <span class="eng-font font-weight-bold h4">{{ $user_guess->score1 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-success text-white shadow mb-4">
                    <div class="card-body text-center">
                        <h1 class="font-weight-bold h4 mb-3">امتیاز شما از این بازی</h1>
                        <hr>
                        <p class="mb-0 font-weight-bold h1">{{ $user_guess->points }}</p>
                    </div>
                </div>
                @endif
            @endif
        @endif
        <div class="overflow-hidden">
            <h3 class="mt-4 h5 font-weight-bold float-right"><i class="fas fa-chart-bar fa-lg mr-2"></i>جدول برترین های مسابقات</h3>
        </div>
        <hr class="mt-0">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">رتبه</th>
                        <th scope="col">کاربر</th>
                        <th scope="col">امتیاز</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($table as $row)
                    <tr>
                        <th scope="row">{{ $loop->iteration + ((intval(request('page') ?: 1) - 1) * 20) }}</th>
                        <td class="eng-font"><a href="{{ route('users.profile', $row->user->username) }}">{{ $row->user->username }}</a></td>
                        <td class="eng-font">{{ intval($row->points) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-5 row justify-content-center">
                    {{ $table->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
