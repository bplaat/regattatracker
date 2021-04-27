@extends('layout')

@section('title', __('admin/buoys.show.title', ['buoy.name' => $buoy->name]))

@section('head')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css"/>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
    @if (config('app.debug'))
        <style>.mapboxgl-ctrl-bottom-left .mapboxgl-ctrl{display:none!important}</style>
    @endif
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.buoys.index') }}">@lang('admin/buoys.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.buoys.show', $buoy) }}">{{ $buoy->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-4">{{ $buoy->name }}</h1>
        @if ($buoy->description != null)
            <p style="white-space: pre-wrap;">{{ $buoy->description }}</p>
        @endif

        <div class="buttons">
            <a class="button is-warning" href="{{ route('admin.buoys.track', $buoy) }}">@lang('admin/buoys.show.track')</a>
            <a class="button is-link" href="{{ route('admin.buoys.edit', $buoy) }}">@lang('admin/buoys.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.buoys.delete', $buoy) }}">@lang('admin/buoys.show.delete')</a>
        </div>
    </div>

    <!-- Buoy positions -->
    <div class="box content">
        <h2 class="tile is-4">@lang('admin/buoys.show.positions')</h2>

        @if (count($buoyPositions) > 0)
            <div class="box" style="position: relative; padding-top: 45%; background-color: #191a1a; overflow: hidden;">
                <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
            </div>

            <script>
                window.data = {
                    type: 'buoy',
                    mapboxAccessToken: @json(config('mapbox.access_token')),
                    positions: @json($buoyPositions),
                    link: @json(route('admin.buoys.positions.store', $buoy)),
                    strings: {
                        title: @json(__('admin/buoys.show.positions_map_title')),
                        current: @json(__('admin/buoys.show.positions_map_current')),
                        latitude: @json(__('admin/buoys.show.positions_map_latitude')),
                        longitude: @json(__('admin/buoys.show.positions_map_longitude')),
                        time: @json(__('admin/buoys.show.positions_map_time')),
                        edit: @json(__('admin/buoys.show.positions_map_edit')),
                        delete: @json(__('admin/buoys.show.positions_map_delete')),
                    }
                };
            </script>
            <script src="/js/item_positions_map.js"></script>
        @else
            <p><i>@lang('admin/buoys.show.positions_empty')</i></p>
        @endif

        <div class="columns">
            <div class="column">
                @if ($buoy->positionsByDay($time - 24 * 60 * 60)->count() > 0)
                    <div class="buttons is-left">
                        <a class="button" href="?day={{ date('Y-m-d', $time - 24 * 60 * 60) }}">@lang('admin/buoys.show.positions_previous')</a>
                    </div>
                @endif
            </div>

            <div class="column">
                <div class="buttons is-centered">
                    <a class="button is-disabled" href="?day={{ date('Y-m-d') }}">@lang('admin/buoys.show.positions_today')</a>
                </div>
            </div>

            <div class="column">
                @if ($buoy->positionsByDay($time + 24 * 60 * 60)->count() > 0)
                    <div class="buttons is-right">
                        <a class="button" href="?day={{ date('Y-m-d', $time + 24 * 60 * 60) }}">@lang('admin/buoys.show.positions_next')</a>
                    </div>
                @endif
            </div>
        </div>

        @if (date('Y-m-d', $time) == date('Y-m-d'))
            <form method="POST" action="{{ route('admin.buoys.positions.store', $buoy) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <input class="input @error('latitude') is-danger @enderror" type="text" id="latitude" name="latitude"
                            placeholder="@lang('admin/buoys.show.positions_latitude_field')"
                            value="{{ old('latitude', count($buoyPositions) > 0 ? $buoyPositions[0]->latitude : '') }}" required>
                    </div>

                    <div class="control">
                        <input class="input @error('longitude') is-danger @enderror" type="text" id="longitude" name="longitude"
                            placeholder="@lang('admin/buoys.show.positions_longitude_field')"
                            value="{{ old('longitude', count($buoyPositions) > 0 ? $buoyPositions[0]->longitude : '') }}" required>
                    </div>

                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/buoys.show.positions_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
