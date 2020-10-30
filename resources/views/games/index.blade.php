@extends('layouts.app')

@section('title', 'مسابقه حدس نتیجه بازی' . ($month > 0 ? ' | برترین های ماه ' . month_name($month) : ''))

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
                        @if ($fixture->penalty)
                        <div class="form-row mt-3">
                            <div class="col">
                                <label class="font-weight-bold d-block">تیم صعود کننده به دور بعد؟</label>
                                <div class="form-group text-center">
                                    <select class="form-control w-auto px-3 mx-auto" name="winner_id">
                                        <option value="">انتخاب کنید...</option>
                                        <option value="{{ $fixture->team1_id }}" {{ ($user_guess->winner_id ?? null) === $fixture->team1_id ? 'selected' : '' }}>{{ $fixture->team1->name_en }}</option>
                                        <option value="{{ $fixture->team2_id }}" {{ ($user_guess->winner_id ?? null) === $fixture->team2_id ? 'selected' : '' }}>{{ $fixture->team2->name_en }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
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
        @if (! is_null($user_points))
            <div class="card bg-info text-white shadow mb-4">
                <div class="card-body text-center">
                    <h1 class="font-weight-bold h4 mb-3">مجموع امتیازات شما</h1>
                    <hr>
                    <p class="mb-0 font-weight-bold h1">{{ $user_points }}</p>
                </div>
            </div>
        @endif
        <div class="overflow-hidden">
            <h3 class="mt-4 h5 font-weight-bold float-right"><i class="fas fa-chart-bar fa-lg mr-2"></i>جدول برترین های مسابقات{{ $month > 0 ? (' - ماه ' . month_name($month)) : '' }}</h3>
        </div>
        <hr class="mt-0">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6 col-lg-4 order-0 order-lg-0">
                        <a class="btn btn-block {{ $month == date('m') ? 'btn-success' : 'btn-secondary' }}" href="{{ route('games', ['d' => date('m')]) }}">برترین‌های این ماه</a>
                    </div>
                    <div class="col-12 col-lg-4 mt-2 mt-lg-0 order-2 order-lg-1">
                        <a class="btn btn-block {{ $month == 0 ? 'btn-success' : 'btn-secondary' }}" href="{{ route('games') }}">برترین‌های کل فصل</a>
                    </div>
                    <div class="col-6 col-lg-4 order-1 order-lg-2">
                        <a class="btn btn-block {{ $month == (date('m') - 1) ? 'btn-success' : 'btn-secondary' }}" href="{{ route('games', ['d' => date('m') - 1]) }}">برترین‌های ماه قبل</a>
                    </div>
                </div>
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
                    <tr class="{{ $loop->iteration === 1 ? 'font-weight-bold' : '' }}">
                        <th scope="row">{{ $loop->iteration + ((intval(request('page') ?: 1) - 1) * 20) }}</th>
                        <td class="eng-font"><a href="{{ route('users.profile', $row->user->username) }}">{{ $row->user->username }}</a></td>
                        <td class="eng-font">{{ intval($row->points) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-5 row justify-content-center">
                    {{ $month > 0 ? $table->appends(['d' => $month])->links() : $table->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
