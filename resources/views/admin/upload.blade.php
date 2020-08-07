@extends('layouts.app')

@section('title', 'آپلود')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="d-inline">
                    <button type="submit" class="btn btn-primary d-inline">ذخیره تغییرات</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @foreach($images as $image)
                        <div class="col-4 mb-3">
                            <img src="{{ asset('img/uploads/' . last(explode('/', $image))) }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
