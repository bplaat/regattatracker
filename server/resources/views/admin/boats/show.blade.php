@extends('layout')

@section('title', __('admin/boats.show.title', ['boat.name' => $boat->name]))

@section('head')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css"/>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.index') }}">@lang('admin/boats.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-4">{{ $boat->name }}</h1>

        @if ($boat->description != null)
            <p style="white-space: pre-wrap;">{{ $boat->description }}</a></p>
        @else
            <p><i>@lang('admin/boats.show.description_empty')</i></p>
        @endif

        <h2 class="subtitle is-5">@lang('boats.show.boat_info')</h2>
        <p>@lang('boats.show.mmsi'): {{ $boat->mmsi }}</p>
        <p>@lang('boats.show.length'): {{ round($boat->length, 2) }} m</p>
        <p>@lang('boats.show.breadth'): {{ round($boat->breadth, 2) }} m</p>
        <p>@lang('boats.show.weight'): {{ round($boat->weight, 2) }} kg</p>

        <h2 class="subtitle is-5">@lang('boats.show.sail_info')</h2>
        <p>@lang('boats.show.sail_number'): {{ $boat->sail_number }}</p>
        <p>@lang('boats.show.sail_area'): {{ round($boat->sail_area, 2) }} m<sup>2</sup></p>

        <h2 class="subtitle is-5">@lang('boats.show.klipperrace_info')</h2>
        <p>@lang('boats.show.klipperrace_rating'): {{ round($boat->klipperraceRating(), 2) }}</p>

        <div class="buttons">
            <a class="button is-warning" href="{{ route('admin.boats.track', $boat) }}">@lang('admin/boats.show.track')</a>
            <a class="button is-link" href="{{ route('admin.boats.edit', $boat) }}">@lang('admin/boats.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.boats.delete', $boat) }}">@lang('admin/boats.show.delete')</a>
        </div>
    </div>

    <!-- Boat positions -->
    <div class="box content">
        <h2 class="tile is-4">@lang('admin/boats.show.positions')</h2>

        @if (count($boatPositions) > 0)
            <div class="box" style="position: relative; padding-top: 45%; background-color: #191a1a; overflow: hidden;">
                <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
            </div>

            <script>
                mapboxgl.accessToken = @json(config('mapbox.access_token'));

                var boatPositions = @json($boatPositions);

                var latestPosition = [
                    parseFloat(boatPositions[boatPositions.length - 1].longitude),
                    parseFloat(boatPositions[boatPositions.length - 1].latitude)
                ];

                var map = new mapboxgl.Map({
                    container: 'map-container',
                    style: 'mapbox://styles/mapbox/dark-v10',
                    center: latestPosition,
                    zoom: 9
                });

                map.on('load', function () {
                    if (boatPositions.length > 1) {
                        var lineCoordinates = [];
                        for (var i = 0; i < boatPositions.length; i++) {
                            lineCoordinates.push([
                                boatPositions[i].longitude,
                                boatPositions[i].latitude
                            ]);
                        }
                        map.addSource('route', {
                            'type': 'geojson',
                            'data': {
                                'type': 'Feature',
                                'properties': {},
                                'geometry': {
                                    'type': 'LineString',
                                    'coordinates': lineCoordinates
                                }
                            }
                        });

                        map.addLayer({
                            'id': 'route',
                            'type': 'line',
                            'source': 'route',
                            'layout': {
                                'line-join': 'round',
                                'line-cap': 'round'
                            },
                            'paint': {
                                'line-color': '#a2a2a2',
                                'line-width': 8
                            }
                        });
                    }

                    new mapboxgl.Marker().setLngLat(latestPosition).addTo(map);
                });
            </script>
        @else
            <p><i>@lang('admin/boats.show.positions_empty')</i></p>
        @endif

        <form method="POST" action="{{ route('admin.boats.positions.create', $boat) }}">
            @csrf

            <div class="field has-addons">
                <div class="control">
                    <input class="input @error('latitude') is-danger @enderror" type="text" id="latitude" name="latitude"
                        placeholder="@lang('admin/boats.show.positions_latitude_field')"
                        value="{{ old('latitude', count($boatPositions) >= 1 ? $boatPositions[count($boatPositions) - 1]->latitude : '') }}" required>
                </div>

                <div class="control">
                    <input class="input @error('longitude') is-danger @enderror" type="text" id="longitude" name="longitude"
                        placeholder="@lang('admin/boats.show.positions_longitude_field')"
                        value="{{ old('longitude', count($boatPositions) >= 1 ? $boatPositions[count($boatPositions) - 1]->longitude : '') }}" required>
                </div>

                <div class="control">
                    <button class="button is-link" type="submit">@lang('admin/boats.show.positions_add_button')</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Boat boat types -->
    <div class="box content">
        <h2 class="title is-4">@lang('admin/boats.show.boat_types')</h2>

        @if ($boatBoatTypes->count() > 0)
            {{ $boatBoatTypes->links() }}

            <div class="columns is-multiline">
                @foreach ($boatBoatTypes as $boatType)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4"><a href="{{ route('admin.boat_types.show', $boatType) }}">{{ $boatType->name }}</a></h3>
                            @if ($boatType->description != null)
                                <p>{{ Str::limit($boatType->description, 64) }}</a></p>
                            @endif

                            <div class="buttons">
                                <a class="button is-danger" href="{{ route('admin.boats.boat_types.delete', [$boat, $boatType]) }}">@lang('admin/boats.show.boat_types_remove_button')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boatBoatTypes->links() }}
        @else
            <p><i>@lang('admin/boats.show.boat_types_empty')</i></p>
        @endif

        @if ($boatBoatTypes->count() != $boatTypes->count())
            <form method="POST" action="{{ route('admin.boats.boat_types.create', $boat) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <div class="select @error('boat_type_id') is-danger @enderror">
                            <select id="boat_type_id" name="boat_type_id" required>
                                <option selected disabled>
                                    @lang('admin/boats.show.boat_types_field')
                                </option>

                                @foreach ($boatTypes as $boatType)
                                    @if (!$boatBoatTypes->pluck('name')->contains($boatType->name))
                                        <option value="{{ $boatType->id }}" @if ($boatType->id == old('boat_type_id')) selected @endif>
                                            {{ $boatType->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/boats.show.boat_types_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <!-- Boat users -->
    <div class="box content">
        <h2 class="title is-4">@lang('admin/boats.show.users')</h2>

        @if ($boatUsers->count() > 0)
            {{ $boatUsers->links() }}

            <div class="columns is-multiline">
                @foreach ($boatUsers as $user)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4">
                                <a href="{{ route('admin.users.show', $user) }}">{{ $user->name() }}</a>

                                @if ($user->pivot->role == App\Models\BoatUser::ROLE_CREW)
                                    <span class="tag is-pulled-right is-success">@lang('admin/boats.show.users_role_crew')</span>
                                @endif

                                @if ($user->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                                    <span class="tag is-pulled-right is-info">@lang('admin/boats.show.users_role_captain')</span>
                                @endif
                            </h3>

                            @if ($user->pivot->role != App\Models\BoatUser::ROLE_CAPTAIN || $boatCaptains->count() > 1)
                                <div class="buttons">
                                    @if ($user->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                                        <a class="button is-success" href="{{ route('admin.boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_CREW }}">@lang('admin/boats.show.users_make_crew_button')</a>
                                    @else
                                        <a class="button is-info" href="{{ route('admin.boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_CAPTAIN }}">@lang('admin/boats.show.users_make_captain_button')</a>
                                    @endif

                                    <a class="button is-danger" href="{{ route('admin.boats.users.delete', [$boat, $user]) }}">@lang('admin/boats.show.users_remove_button')</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boatUsers->links() }}
        @else
            <p><i>@lang('admin/boats.show.users_empty')</i></p>
        @endif

        @if ($boatUsers->count() != $users->count())
            <form method="POST" action="{{ route('admin.boats.users.create', $boat) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <div class="select @error('user_id') is-danger @enderror">
                            <select id="user_id" name="user_id" required>
                                <option selected disabled>
                                    @lang('admin/boats.show.users_field')
                                </option>

                                @foreach ($users as $user)
                                    @if (!$boatUsers->pluck('id')->contains($user->id))
                                        <option value="{{ $user->id }}"  @if ($user->id == old('user_id')) selected @endif>
                                            {{ $user->name() }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <div class="select is-fullwidth @error('role') is-danger @enderror">
                            <select id="role" name="role" required>
                                <option value="{{ App\Models\BoatUser::ROLE_CREW }}" @if (App\Models\BoatUser::ROLE_CREW == old('role', App\Models\BoatUser::ROLE_CREW)) selected @endif>
                                    @lang('admin/boats.show.users_role_field_crew')
                                </option>

                                <option value="{{ App\Models\BoatUser::ROLE_CAPTAIN }}" @if (App\Models\BoatUser::ROLE_CAPTAIN == old('role', App\Models\BoatUser::ROLE_CREW)) selected @endif>
                                    @lang('admin/boats.show.users_role_field_captain')
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/boats.show.users_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
