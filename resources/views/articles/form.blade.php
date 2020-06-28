@extends('layouts.app')

@section('title', 'ذخیره خبر')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">ذخیره خبر</div>
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
                        <label>لینک تصویر</label>
                        <input type="text" name="cover" class="form-control" dir="ltr">
                    </div>
                    <div class="form-group">
                        <label>تگ ها</label>
                        <tag-selector :tags="{title: this.articleTitle, tags: '{{ $article->tags ?? '' }}', selector: '{{ empty($article->title) }}'}"></tag-selector>
                    </div>
                    <div class="form-group">
                        <label>منوی بازی</label>
                        <select name="fixture_id" class="form-control">
                            <option value="">----------------------------------------------------</option>
                            @foreach($fixtures as $fixture)
                                <option value="{{ $fixture->id }}" {{ $fixture->id === ($article->fixture_id ?? null) ? 'selected' : '' }}>{{ fixture_title($fixture) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>متن</label>
                        <textarea id="summernote" name="body" class="form-control" required>{{ $article->body ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                    @if (! empty($article))
                    <a href="{{ route('articles.view', $article->slug) }}" class="btn btn-secondary float-left" target="_blank">مشاهده خبر</a>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
