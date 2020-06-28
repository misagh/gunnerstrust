@extends('layouts.app')

@section('title', 'منوی بازی ها')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    @csrf
                    <div class="form-row eng-font">
                        <div class="form-group col-4">
                            <select name="team1_id" class="form-control">
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ $team->id === ($fixture->team1_id ?? null) ? 'selected' : '' }}>{{ $team->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <input type="number" name="score1" class="form-control" value="{{ $fixture->score1 ?? '' }}">
                        </div>
                        <div class="form-group col-2">
                            <input type="number" name="score2" class="form-control" value="{{ $fixture->score2 ?? '' }}">
                        </div>
                        <div class="form-group col-4">
                            <select name="team2_id" class="form-control">
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ $team->id === ($fixture->team2_id ?? null) ? 'selected' : '' }}>{{ $team->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row eng-font">
                        <div class="form-group col-4">
                            <select name="stadium_id" class="form-control">
                                @foreach($stadiums as $stadium)
                                    <option value="{{ $stadium->id }}" {{ $stadium->id === ($fixture->stadium_id ?? null) ? 'selected' : '' }}>{{ $stadium->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <input type="number" name="season" class="form-control" value="{{ $fixture->season ?? date('Y') }}">
                        </div>
                        <div class="form-group col-2">
                            <input type="number" name="matchday" class="form-control" value="{{ $fixture->matchday ?? '' }}">
                        </div>
                        <div class="form-group col-4">
                            <select name="competition_id" class="form-control">
                                @foreach($competitions as $competition)
                                    <option value="{{ $competition->id }}" {{ $competition->id === ($fixture->competition_id ?? null) ? 'selected' : '' }}>{{ $competition->name_en }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group eng-font">
                        <input type="text" name="played_at" class="form-control" value="{{ $fixture->played_at ?? now() }}" required>
                    </div>
                    <div class="form-group">
                        <textarea id="summernote" name="body" class="form-control">{{ $fixture->body ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
