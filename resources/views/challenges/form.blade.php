@extends('layouts.app')

@section('title', 'ذخیره چالش')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">ذخیره چالش</div>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label>عنوان</label>
                        <input type="text" name="title" class="form-control" value="{{ $challenge->title ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>خلاصه</label>
                        <input type="text" name="summary" class="form-control" value="{{ $challenge->summary ?? '' }}" maxlength="160" minlength="150" required>
                    </div>
                    <div class="form-group">
                        <label>لینک تصویر</label>
                        <input type="text" name="cover" class="form-control" dir="ltr">
                    </div>
                    <div class="form-group">
                        <label>تاریخ شروع</label>
                        <input type="date" name="started_at" class="form-control" value="{{ empty($challenge) ? date('Y-m-d', time()) : $challenge->started_at->format('Y-m-d') }}" dir="ltr">
                    </div>
                    <div class="form-group">
                        <label>مدت زمان (روز)</label>
                        <input type="number" name="days" class="form-control" value="{{ empty($challenge) ? 7 : $challenge->started_at->diffInDays($challenge->finished_at) }}" dir="ltr">
                    </div>
                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
