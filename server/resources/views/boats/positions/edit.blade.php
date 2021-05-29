@extends('layout')

@section('title', __('boats.positions.edit.title', ['boat.name' => $boat->name, 'boat_position.id' => $boatPosition->id]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('boats.index') }}">@lang('boats.index.breadcrumb')</a></li>
            <li><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></li>
            <li><a href="#">@lang('boats.positions.index.breadcrumb')</a></li>
            <li><a href="#">@lang('boats.positions.show.breadcrumb', ['boat_position.id' => $boatPosition->id])</a></li>
            <li class="is-active"><a href="{{ route('boats.positions.edit', [$boat, $boatPosition]) }}">@lang('boats.positions.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('boats.positions.edit.header')</h1>

    <form method="POST" action="{{ route('boats.positions.update', [$boat, $boatPosition]) }}">
        @csrf

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="latitude">@lang('boats.positions.edit.latitude')</label>

                    <div class="control">
                        <input class="input @error('latitude') is-danger @enderror" type="text" id="latitude" name="latitude" value="{{ old('latitude', $boatPosition->latitude) }}" required>
                    </div>

                    @error('latitude')
                        <p class="help is-danger">{{ $errors->first('latitude') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="longitude">@lang('boats.positions.edit.longitude')</label>

                    <div class="control">
                        <input class="input @error('longitude') is-danger @enderror" type="text" id="longitude" name="longitude" value="{{ old('longitude', $boatPosition->longitude) }}" required>
                    </div>

                    @error('latitulongitudede')
                        <p class="help is-danger">{{ $errors->first('longitude') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="created_at_date">@lang('boats.positions.edit.created_at_date')</label>

                    <div class="control">
                        <input class="input @error('created_at_date') is-danger @enderror" type="date" id="created_at_date" name="created_at_date" value="{{ old('created_at_date', $boatPosition->created_at->format('Y-m-d')) }}" required>
                    </div>

                    @error('created_at_date')
                        <p class="help is-danger">{{ $errors->first('created_at_date') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="created_at_time">@lang('boats.positions.edit.created_at_time')</label>

                    <div class="control">
                        <input class="input @error('created_at_time') is-danger @enderror" type="time" step="1" id="created_at_time" name="created_at_time" value="{{ old('created_at_time', $boatPosition->created_at->format('H:i:s')) }}" required>
                    </div>

                    @error('created_at_time')
                        <p class="help is-danger">{{ $errors->first('created_at_time') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('boats.positions.edit.edit_button')</button>
            </div>
        </div>
    </form>
@endsection
