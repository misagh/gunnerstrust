@extends('layouts.app')

@section('title', 'افزودن مصاحبه')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>عنوان</label>
                        <input type="text" name="title" class="form-control" value="{{ $interview->title ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>خلاصه</label>
                        <input type="text" name="summary" class="form-control" value="{{ $interview->summary ?? '' }}" maxlength="160" minlength="150" required>
                    </div>
                    <div class="form-group">
                        <label>توکن ویدیو</label>
                        <input type="text" name="embed" class="form-control eng-font" value="{{ $interview->embed ?? '' }}" placeholder="123456789-xxxxx">
                    </div>
                    <div class="form-group">
                        <label>مصاحبه شونده</label>
                        <select name="user_id" class="form-control eng-font" required>
                            <option value="">----------------------------------------------------</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id === ($interview->user_id ?? null) ? 'selected' : '' }}>{{ $user->username ?: $user->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group overflow-hidden">
                        <label>تصویر</label>
                        <input type="file" name="cover" class="form-control-file" {{ empty($interview->cover) ? 'required' : '' }}>
                        @if (! empty($interview->cover))
                            <span class="float-left"><img src="{{ get_cover($interview->cover) }}" width="200"></span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>متن</label>
                        <textarea id="summernote" name="body" class="form-control">{{ $interview->body ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-right mr-2">ذخیره تغییرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
