@extends('layouts.app')

@section('title', 'برنامه بازی ها')

@section('content')
    <div class="container">
        <div class="card shadow mb-4">
            <div class="card-header font-weight-bold">لیست بازی ها</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>تیم ها</th>
                            <th>تاریخ</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fixtures as $fixture)
                            <tr class="eng-font">
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="{{ route('fixtures.view', $fixture->slug) }}">{{ fixture_title($fixture) }}</a></td>
                                <td>{{ $fixture->played_at->format('Y/m/d - H:i') }}</td>
                                <td><a href="{{ route('fixtures.edit', $fixture->id) }}"><i class="fas fa-envelope-open-text fa-lg"></i></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-3">{{ $fixtures->links() }}</div>
        </div>
    </div>
@endsection
