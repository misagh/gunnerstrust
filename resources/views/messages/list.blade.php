@extends('layouts.app')

@section('title', 'پیام خصوصی')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
            @if ($messages->isEmpty())
                <div class="alert alert-info shadow-sm mt-3 mx-3">صندوق پیام های خصوصی شما خالی است.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>فرستنده</th>
                                <th>تاریخ ارسال</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($messages as $message)
                            <tr class="{{ empty($message->read_at) ? 'bg-success font-weight-bold text-white' : '' }}">
                                <td>{{ $loop->iteration }}</td>
                                <td class="eng-font">
                                    <a href="{{ route('users.profile', $message->userFrom->username) }}">{{ $message->userFrom->username }}</a>
                                </td>
                                <td class="eng-font">{{ $message->created_at }}</td>
                                <td class="eng-font">
                                    <a href="{{ route('messages.view', $message->id) }}"><i class="fas fa-envelope-open-text fa-lg"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($messages->links()->paginator->hasPages())
                <div class="mt-4 row justify-content-center">
                    {{ $messages->links() }}
                </div>
                @endif
            @endif
            </div>
        </div>
    </div>
@endsection
