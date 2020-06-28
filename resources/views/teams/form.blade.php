@extends('layouts.app')

@section('title', 'ذخیره تیم')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">ذخیره تیم</div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>نام انگلیسی</label>
                        <input type="text" name="name_en" class="form-control" value="{{ $team->name_en ?? '' }}" dir="ltr" required>
                    </div>
                    <div class="form-group">
                        <label>نام انگلیسی کوتاه</label>
                        <input type="text" name="short_name_en" class="form-control" value="{{ $team->short_name_en ?? '' }}" dir="ltr" required>
                    </div>
                    <div class="form-group">
                        <label>نام فارسی</label>
                        <input type="text" name="name_fa" class="form-control" value="{{ $team->name_fa ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>نام فارسی کوتاه</label>
                        <input type="text" name="short_name_fa" class="form-control" value="{{ $team->short_name_fa ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>لوگو</label>
                        <input type="file" name="logo" class="form-control-file">
                        @if (! empty($team->logo))
                            <span class="float-left"><img src="{{ $team->logo }}" width="100"></span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success mt-4">ذخیره تغییرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
