@extends('layouts.app')

@section('title', 'استادیوم های اضافه شده')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">استادیوم های اضافه شده</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        @foreach($stadiums as $stadium)
                            <tr>
                                <td>{{ $stadium->name_en }}</td>
                                <td><a href="{{ route('stadiums.edit', $stadium->id) }}" class="mr-2"><i class="fas fa-lg fa-pen-square"></i></a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="mt-5 row justify-content-center">
                    {{ $stadiums->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
