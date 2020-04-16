@extends('layouts.app')

@section('title', 'اطلاعیه ها')

@section('content')
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                @if ($notifications->isEmpty())
                    <div class="alert alert-info mb-0">شما در حال حاضر اطلاعیه ای ندارید.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <tbody>
                            @foreach($notifications as $notification)
                                <tr class="{{ in_array($notification->id, $unreads) ? 'bg-info text-white' : '' }}">
                                    <td class="eng-font font-weight-bold">{{ $loop->iteration }}</td>
                                    <td><a href="{{ $notification->data['url'] }}">{{ $notification->data['message'] }}</a></td>
                                    <td>{{ $notification->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
