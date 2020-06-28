@extends('layouts.app')

@section('title', 'تیم های اضافه شده')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">تیم های اضافه شده</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        @foreach($teams as $team)
                            <tr>
                                <td>{{ $team->name_en }}</td>
                                <td><a href="{{ route('teams.edit', $team->id) }}" class="mr-2"><i class="fas fa-lg fa-pen-square"></i></a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="mt-5 row justify-content-center">
                    {{ $teams->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
