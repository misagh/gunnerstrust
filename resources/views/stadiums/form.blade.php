@extends('layouts.app')

@section('title', 'ذخیره استادیوم')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">ذخیره استادیوم</div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>نام انگلیسی</label>
                        <input type="text" name="name_en" class="form-control" value="{{ $stadium->name_en ?? '' }}" dir="ltr" required>
                    </div>
                    <div class="form-group">
                        <label>نام فارسی</label>
                        <input type="text" name="name_fa" class="form-control" value="{{ $stadium->name_fa ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label>لوگو</label>
                        <input type="file" name="logo" class="form-control-file">
                        @if (! empty($stadium->logo))
                            <span class="float-left"><img src="{{ $stadium->logo }}" width="300"></span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success mt-4">ذخیره تغییرات</button>
                </form>
            </div>
        </div>
    </div>
@endsection
