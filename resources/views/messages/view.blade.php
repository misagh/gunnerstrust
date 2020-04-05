@extends('layouts.app')

@section('title', 'مشاهده پیام خصوصی')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <div class="alert alert-secondary overflow-hidden font-weight-bold">
                    <div class="float-right">
                        <span>فرستنده:</span>
                        <a class="eng-font" href="{{ route('users.profile', $message->userFrom->username) }}">{{ $message->userFrom->username }}</a>
                    </div>
                    <div class="float-left eng-font">{{ $message->created_at }}</div>
                </div>
                <div class="bg-light shadow p-4">{{ $message->body }}</div>
                <p class="d-block mt-5">
                    <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#sendMessage" aria-expanded="false" aria-controls="sendMessage">ارسال پاسخ</button>
                    <a class="btn btn-secondary" href="{{ route('users.messages') }}">بازگشت به پیام ها</a>
                </p>
                <div class="collapse" id="sendMessage">
                    <div class="card card-body bg-dark">
                        <form action="{{ route('messages.send') }}" method="post">
                            @csrf
                            <input type="hidden" name="return_url" value="{{ route('users.messages') }}">
                            <input type="hidden" name="user_to_id" value="{{ $message->user_from_id }}">
                            <textarea rows="5" name="body" class="form-control border border-dark" required></textarea>
                            <button type="submit" class="btn btn-success mt-3">ارسال پیام</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
