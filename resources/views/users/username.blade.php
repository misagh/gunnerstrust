@extends('layouts.app')

@section('title', 'انتخاب نام کاربری')

@section('content')

    <div class="container">
        <div class="card shadow">
            <div class="card-body text-center">
                <p class="font-weight-bold mb-0">لطفا یک نام کاربری برای خود انتخاب کنید</p>
                <small class="text-muted">حداقل ۳ و حداکثر ۱۵ حرف. فقط حروف انگلیسی و اعداد قابل قبول هستند.</small>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form action="{{ route('users.username') }}" method="post">
                            @csrf
                            <input type="text" name="username" class="form-control eng-font my-3" value="{{ old('username') }}" required>
                            <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
