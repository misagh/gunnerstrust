@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">افزودن خبر جدید</div>
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label>عنوان</label>
                        <input type="text" name="title" class="form-control" value="{{ $article->title ?? '' }}" @if (empty($article->title)) v-model="articleTitle" @endif required>
                    </div>
                    <div class="form-group">
                        <label>خلاصه</label>
                        <input type="text" name="summary" class="form-control" value="{{ $article->summary ?? '' }}" maxlength="160" minlength="150" required>
                    </div>
                    <div class="form-group">
                        <label>لینک منبع</label>
                        <input type="text" name="source" class="form-control" value="{{ $article->source ?? '' }}" dir="ltr">
                    </div>
                    <div class="form-group">
                        <label>تگ ها</label>
                        <tag-selector :tags="{title: this.articleTitle, tags: '{{ $article->tags ?? '' }}', selector: '{{ empty($article->title) }}'}"></tag-selector>
                    </div>
                    <div class="form-group">
                        <label>متن</label>
                        <textarea id="summernote" name="body" class="form-control" required>{{ $article->body ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
