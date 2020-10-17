@extends('layouts.app')

@section('title', 'افزودن بحث')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>عنوان</label>
                        <input type="text" name="title" class="form-control" value="{{ $discussion->title ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label>خلاصه</label>
                        <input type="text" name="summary" class="form-control" value="{{ $discussion->summary ?? '' }}" maxlength="160" minlength="150">
                    </div>
                    <div class="form-group overflow-hidden">
                        <label>تصویر</label>
                        <input type="file" name="cover" class="form-control-file" {{ empty($discussion->cover) ? 'required' : '' }}>
                        @if (! empty($discussion->cover))
                            <span class="float-left"><img src="{{ get_cover($discussion->cover) }}" width="200"></span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>متن</label>
                        <textarea id="summernote" name="body" class="form-control">{{ $discussion->body ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-right mr-2">ذخیره تغییرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
