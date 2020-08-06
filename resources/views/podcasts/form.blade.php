@extends('layouts.app')

@section('title', 'افزودن پادکست')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>عنوان</label>
                        <input type="text" name="title" class="form-control" value="{{ $podcast->title ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>خلاصه</label>
                        <input type="text" name="summary" class="form-control" value="{{ $podcast->summary ?? '' }}" maxlength="160" minlength="150" required>
                    </div>
                    <div class="form-group overflow-hidden">
                        <label>تصویر</label>
                        <input type="file" name="cover" class="form-control-file" {{ empty($podcast->cover) ? 'required' : '' }}>
                        @if (! empty($podcast->cover))
                            <span class="float-left"><img src="{{ get_cover($podcast->cover) }}" width="200"></span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>فایل</label>
                        <input type="text" name="file" class="form-control eng-font" value="{{ $podcast->file ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>اسکریپت</label>
                        <textarea name="embed" rows="5" class="form-control eng-font">{{ $podcast->embed ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>متن</label>
                        <textarea id="summernote" name="body" class="form-control">{{ $podcast->body ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-right mr-2">ذخیره تغییرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
