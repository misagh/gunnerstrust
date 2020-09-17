@extends('layouts.app')

@section('title', 'ذخیره پست خبر')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">ذخیره پست خبر</div>
            <div class="card-body p-1">
                <form action="" method="post">
                    @csrf
                    <div class="form-group col-12 px-2 mt-2">
                        <textarea name="body" class="form-control" rows="7" dir="auto" required>{!! strip_tags($update->body ?? '') !!}</textarea>
                    </div>
                    <div class="form-row mb-3">
                    @if (! empty($categories))
                        @foreach($categories as $category)
                        <div class="form-group px-3 col-6">
                            <input type="checkbox" id="category{{ $category->id }}" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, ($update_categories ?? [])) ? 'checked' : '' }}>
                            <label for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary m-2">ذخیره تغییرات</button>
                    @if (! empty($update))
                    <a href="{{ route('updates.view', $update->id) }}" class="btn btn-secondary float-left mt-2 mr-2" target="_blank">مشاهده پست</a>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
