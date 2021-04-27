@extends('layout')

@section('title', __('admin/buoys.positions.edit.title', ['buoy.name' => $buoy->name, 'buoy_position.name' => __('admin/buoys.positions.show.breadcrumb') . ' #' . $buoyPosition->id]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.buoys.index') }}">@lang('admin/buoys.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.buoys.show', $buoy) }}">{{ $buoy->name }}</a></li>
            <li><a href="#">@lang('admin/buoys.positions.index.breadcrumb')</a></li>
            <li><a href="#">@lang('admin/buoys.positions.show.breadcrumb') #{{ $buoyPosition->id }}</a></li>
            <li class="is-active"><a href="{{ route('admin.buoys.positions.edit', [$buoy, $buoyPosition]) }}">@lang('admin/buoys.positions.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/buoys.positions.edit.header')</h1>

    <form method="POST" action="{{ route('admin.buoys.positions.update', [$buoy, $buoyPosition]) }}">
        @csrf

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="latitude">@lang('admin/buoys.positions.edit.latitude')</label>

                    <div class="control">
                        <input class="input @error('latitude') is-danger @enderror" type="text" id="latitude" name="latitude" value="{{ old('latitude', $buoyPosition->latitude) }}" required>
                    </div>

                    @error('latitude')
                        <p class="help is-danger">{{ $errors->first('latitude') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="longitude">@lang('admin/buoys.positions.edit.longitude')</label>

                    <div class="control">
                        <input class="input @error('longitude') is-danger @enderror" type="text" id="longitude" name="longitude" value="{{ old('longitude', $buoyPosition->longitude) }}" required>
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
                    <label class="label" for="created_at_date">@lang('admin/buoys.positions.edit.created_at_date')</label>

                    <div class="control">
                        <input class="input @error('created_at_date') is-danger @enderror" type="date" id="created_at_date" name="created_at_date" value="{{ old('created_at_date', date('Y-m-d', strtotime($buoyPosition->created_at))) }}" required>
                    </div>

                    @error('created_at_date')
                        <p class="help is-danger">{{ $errors->first('created_at_date') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="created_at_time">@lang('admin/buoys.positions.edit.created_at_time')</label>

                    <div class="control">
                        <input class="input @error('created_at_time') is-danger @enderror" type="time" step="1" id="created_at_time" name="created_at_time" value="{{ old('created_at_time', date('H:i:s', strtotime($buoyPosition->created_at))) }}" required>
                    </div>

                    @error('created_at_time')
                        <p class="help is-danger">{{ $errors->first('created_at_time') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/buoys.positions.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
