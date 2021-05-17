@extends('layout')

@section('title', __('boats.show.title', ['boat.name' => $boat->name]))

@section('head')
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css"/>
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('boats.index') }}">@lang('boats.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-4">{{ $boat->name }}</h1>
        @if ($boat->description != null)
            <p style="white-space: pre-wrap;">{{ $boat->description }}</p>
        @else
            <p><i>@lang('boats.show.description_empty')</i></p>
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
        <p>@lang('boats.show.klipperrace_rating'): {{ round($boat->klipperraceRating, 2) }}</p>

        @canany(['track', 'update', 'delete'], $boat)
            <div class="buttons">
                @can('track', $boat)
                    <a class="button is-warning" href="{{ route('boats.track', $boat) }}">@lang('boats.show.track')</a>
                @endcan
                @can('update', $boat)
                    <a class="button is-link" href="{{ route('boats.edit', $boat) }}">@lang('boats.show.edit')</a>
                @endcan
                @can('delete', $boat)
                    <a class="button is-danger" href="{{ route('boats.delete', $boat) }}">@lang('boats.show.delete')</a>
                @endcan
            </div>
        @endcanany
    </div>

    <!-- Boat positions -->
    <div class="box content">
        <h2 class="tile is-4">@lang('boats.show.positions')</h2>

        @if (count($boatPositions) > 0)
            <div class="box" style="position: relative; padding-top: 45%; background-color: #191a1a; overflow: hidden;">
                <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
            </div>

            <script>
                window.data = {
                    type: 'boat',
                    mapboxAccessToken: @json(config('mapbox.access_token')),
                    positions: @json($boatPositions),
                    link: @json(route('boats.positions.store', $boat)),
                    strings: {
                        title: @json(__('boats.show.positions_map_title')),
                        current: @json(__('boats.show.positions_map_current')),
                        latitude: @json(__('boats.show.positions_map_latitude')),
                        longitude: @json(__('boats.show.positions_map_longitude')),
                        time: @json(__('boats.show.positions_map_time')),
                        edit: @json(__('boats.show.positions_map_edit')),
                        delete: @json(__('boats.show.positions_map_delete')),
                    }
                };
            </script>
            <script src="/js/item_positions_map.js"></script>
        @else
            <p><i>@lang('boats.show.positions_empty')</i></p>
        @endif

        <div class="columns">
            <div class="column">
                @if ($boat->positionsByDay($time - 24 * 60 * 60)->count() > 0)
                    <div class="buttons is-left">
                        <a class="button" href="?day={{ date('Y-m-d', $time - 24 * 60 * 60) }}">@lang('boats.show.positions_previous')</a>
                    </div>
                @endif
            </div>

            <div class="column">
                <div class="buttons is-centered">
                    <a class="button is-disabled" href="?day={{ date('Y-m-d') }}">@lang('boats.show.positions_today')</a>
                </div>
            </div>

            <div class="column">
                @if ($boat->positionsByDay($time + 24 * 60 * 60)->count() > 0)
                    <div class="buttons is-right">
                        <a class="button" href="?day={{ date('Y-m-d', $time + 24 * 60 * 60) }}">@lang('boats.show.positions_next')</a>
                    </div>
                @endif
            </div>
        </div>

        @if (date('Y-m-d', $time) == date('Y-m-d'))
            @can('create_boat_position', $boat)
                <form method="POST" action="{{ route('boats.positions.store', $boat) }}">
                    @csrf

                    <div class="field has-addons">
                        <div class="control">
                            <input class="input @error('latitude') is-danger @enderror" type="text" id="latitude" name="latitude"
                                placeholder="@lang('boats.show.positions_latitude_field')"
                                value="{{ old('latitude', $boatPositions->count() > 0 ? $boatPositions[0]->latitude : '') }}" required>
                        </div>

                        <div class="control">
                            <input class="input @error('longitude') is-danger @enderror" type="text" id="longitude" name="longitude"
                                placeholder="@lang('boats.show.positions_longitude_field')"
                                value="{{ old('longitude', $boatPositions->count() > 0 ? $boatPositions[0]->longitude : '') }}" required>
                        </div>

                        <div class="control">
                            <button class="button is-link" type="submit">@lang('boats.show.positions_add_button')</button>
                        </div>
                    </div>
                </form>
            @endcan
        @endif
    </div>

    <!-- Boat boat types -->
    <div class="box content">
        <h2 class="title is-4">@lang('boats.show.boat_types')</h2>

        @if ($boatBoatTypes->count() > 0)
            {{ $boatBoatTypes->links() }}

            <div class="columns is-multiline">
                @foreach ($boatBoatTypes as $boatType)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4">{{ $boatType->name }}</h3>
                            @if ($boatType->description != null)
                                <p>{{ Str::limit($boatType->description, 64) }}</p>
                            @endif

                            @can('delete_boat_boat_type', $boat)
                                <div class="buttons">
                                    <a class="button is-danger is-light is-small" href="{{ route('boats.boat_types.delete', [$boat, $boatType]) }}">
                                        @lang('boats.show.boat_types_remove_button')
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boatBoatTypes->links() }}
        @else
            <p><i>@lang('boats.show.boat_types_empty')</i></p>
        @endif

        @can('create_boat_boat_type', $boat)
            @if ($boatBoatTypes->count() != $boatTypes->count())
                <form method="POST" action="{{ route('boats.boat_types.store', $boat) }}">
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
                                            <option value="{{ $boatType->id }}"
                                                    @if ($boatType->id == old('boat_type_id')) selected @endif>
                                                {{ $boatType->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="control">
                            <button class="button is-link" type="submit">
                                @lang('boats.show.boat_types_add_button')
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        @endcan
    </div>

    <!-- Boat users -->
    <div class="box content">
        <h2 class="title is-4">@lang('boats.show.users')</h2>

        @if ($boatUsers->count() > 0)
            {{ $boatUsers->links() }}

            <div class="columns is-multiline">
                @foreach ($boatUsers as $user)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4">
                                {{ $user->name }}

                                @if ($user->pivot->role == App\Models\BoatUser::ROLE_CREW)
                                    <span class="tag is-pulled-right is-success">@lang('boats.show.users_role_crew')</span>
                                @endif

                                @if ($user->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                                    <span class="tag is-pulled-right is-info">@lang('boats.show.users_role_captain')</span>
                                @endif
                            </h3>

                            @canany(['update_boat_user', 'delete_boat_user'], $boat)
                                @if ($user->pivot->role != App\Models\BoatUser::ROLE_CAPTAIN || $boatCaptains->count() > 1)
                                    <div class="buttons">
                                        @can('update_boat_user', $boat)
                                            @if ($user->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                                                <a class="button is-success is-light is-small" href="{{ route('boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_CREW }}">
                                                    @lang('boats.show.users_make_crew_button')
                                                </a>
                                            @else
                                                <a class="button is-info is-light is-small" href="{{ route('boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_CAPTAIN }}">
                                                    @lang('boats.show.users_make_captain_button')
                                                </a>
                                            @endif
                                        @endcan

                                        @can('delete_boat_user', $boat)
                                            <a class="button is-danger is-light is-small" href="{{ route('boats.users.delete', [$boat, $user]) }}">
                                                @lang('boats.show.users_remove_button')
                                            </a>
                                        @endcan
                                    </div>
                                @endif
                            @endcanany
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boatUsers->links() }}
        @else
            <p><i>@lang('boats.show.users_empty')</i></p>
        @endif

        @can('create_boat_user', $boat)
            @if ($boatUsers->count() != $users->count())
                <form method="POST" action="{{ route('boats.users.store', $boat) }}">
                    @csrf

                    <div class="field has-addons">
                        <div class="control">
                            <div class="select @error('user_id') is-danger @enderror">
                                <select id="user_id" name="user_id" required>
                                    <option selected disabled>
                                        @lang('boats.show.users_field')
                                    </option>

                                    @foreach ($users as $user)
                                        @if (!$boatUsers->pluck('id')->contains($user->id))
                                            <option value="{{ $user->id }}"
                                                    @if ($user->id == old('user_id')) selected @endif>
                                                {{ $user->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="control">
                            <div class="select @error('role') is-danger @enderror">
                                <select id="role" name="role" required>
                                    <option value="{{ App\Models\BoatUser::ROLE_CREW }}"
                                            @if (App\Models\BoatUser::ROLE_CREW == old('role', App\Models\BoatUser::ROLE_CREW)) selected @endif>
                                        @lang('boats.show.users_role_field_crew')
                                    </option>

                                    <option value="{{ App\Models\BoatUser::ROLE_CAPTAIN }}"
                                            @if (App\Models\BoatUser::ROLE_CAPTAIN == old('role', App\Models\BoatUser::ROLE_CREW)) selected @endif>
                                        @lang('boats.show.users_role_field_captain')
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="control">
                            <button class="button is-link" type="submit">@lang('boats.show.users_add_button')</button>
                        </div>
                    </div>
                </form>
            @endif
        @endcan
    </div>
@endsection
