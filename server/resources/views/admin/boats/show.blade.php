@extends('layout')

@section('title', __('admin/boats.show.title', ['boat.name' => $boat->name]))

@section('head')
    <link rel="stylesheet" href="/css/mapbox-gl.min.css"/>
    <script src="/js/mapbox-gl.min.js"></script>
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
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

        @if ($boat->image != null)
            <div class="box" style="display: inline-block; padding: 0; background-color: #191a1a; overflow: hidden; margin-bottom: 16px;">
                <img style="display: block;" src="/storage/boats/{{ $boat->image }}" alt="@lang('boats.show.image_alt', [ 'boat.name' => $boat->name ])">
            </div>
        @endif

        <h2 class="subtitle is-5">@lang('boats.show.boat_info')</h2>
        <p>@lang('boats.show.mmsi') {{ $boat->mmsi }}</p>
        <p>@lang('boats.show.length') {{ round($boat->length, 2) }} m</p>
        <p>@lang('boats.show.breadth') {{ round($boat->breadth, 2) }} m</p>
        <p>@lang('boats.show.weight') {{ round($boat->weight / 1000, 2) }} tons</p>

        <h2 class="subtitle is-5">@lang('boats.show.sail_info')</h2>
        <p>@lang('boats.show.sail_number') {{ $boat->sail_number != null ? $boat->sail_number : '?' }}</p>
        <p>@lang('boats.show.sail_area') {{ round($boat->sail_area, 2) }} m<sup>2</sup></p>

        <h2 class="subtitle is-5">@lang('boats.show.handicap_info')</h2>
        <p>@lang('boats.show.klipperrace_rating') {{ round($boat->klipperraceRating, 2) }}</p>

        <div class="buttons">
            <a class="button is-warning" href="{{ route('admin.boats.track', $boat) }}">@lang('admin/boats.show.track_button')</a>
            <a class="button is-link" href="{{ route('admin.boats.edit', $boat) }}">@lang('admin/boats.show.edit_button')</a>
            <a class="button is-danger" href="{{ route('admin.boats.delete', $boat) }}">@lang('admin/boats.show.delete_button')</a>
        </div>
    </div>

    <!-- Boat positions -->
    <div class="box content">
        <h2 class="tile is-4">@lang('admin/boats.show.positions')</h2>

        @if (count($boatPositions) > 0)
            <div class="box" style="position: relative; padding-top: 45%; background-color: #191a1a; overflow: hidden;">
                <div id="map-container" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
            </div>

            <script>
                window.data = {
                    type: 'boat',
                    mapboxAccessToken: @json(config('mapbox.access_token')),
                    item: @json($boat),
                    positions: @json($boatPositions),
                    links: {
                        itemPositionsEdit: @json(rawRoute('admin.boats.positions.edit')).replace('{boat}', '{item}').replace('{boatPosition}', '{itemPosition}'),
                        itemPositionsDelete: @json(rawRoute('admin.boats.positions.delete')).replace('{boat}', '{item}').replace('{boatPosition}', '{itemPosition}')
                    },
                    strings: {
                        name: @json(__('admin/boats.show.positions_map_name')),
                        current: @json(__('admin/boats.show.positions_map_current')),
                        latitude: @json(__('admin/boats.show.positions_map_latitude')),
                        longitude: @json(__('admin/boats.show.positions_map_longitude')),
                        time: @json(__('admin/boats.show.positions_map_time')),
                        edit_button: @json(__('admin/boats.show.positions_map_edit_button')),
                        delete_button: @json(__('admin/boats.show.positions_map_delete_button')),
                    }
                };
            </script>
            <script src="/js/item_positions_map.js"></script>
        @else
            <p><i>@lang('admin/boats.show.positions_empty')</i></p>
        @endif

        <div class="columns">
            <div class="column">
                @if ($boat->positionsByDay($time - 24 * 60 * 60)->count() > 0)
                    <div class="buttons is-left">
                        <a class="button" href="?day={{ date('Y-m-d', $time - 24 * 60 * 60) }}">@lang('admin/boats.show.positions_previous_button')</a>
                    </div>
                @endif
            </div>

            <div class="column">
                <div class="buttons is-centered">
                    <a class="button is-disabled" href="?day={{ date('Y-m-d') }}">@lang('admin/boats.show.positions_today_button')</a>
                </div>
            </div>

            <div class="column">
                @if ($boat->positionsByDay($time + 24 * 60 * 60)->count() > 0)
                    <div class="buttons is-right">
                        <a class="button" href="?day={{ date('Y-m-d', $time + 24 * 60 * 60) }}">@lang('admin/boats.show.positions_next_button')</a>
                    </div>
                @endif
            </div>
        </div>

        @if (date('Y-m-d', $time) == date('Y-m-d'))
            <form method="POST" action="{{ route('admin.boats.positions.store', $boat) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <input class="input @error('latitude') is-danger @enderror" type="text" id="latitude" name="latitude"
                            placeholder="@lang('admin/boats.show.positions_latitude_placeholder')"
                            value="{{ old('latitude', count($boatPositions) > 0 ? $boatPositions[0]->latitude : '') }}" required>
                    </div>

                    <div class="control">
                        <input class="input @error('longitude') is-danger @enderror" type="text" id="longitude" name="longitude"
                            placeholder="@lang('admin/boats.show.positions_longitude_placeholder')"
                            value="{{ old('longitude', count($boatPositions) > 0 ? $boatPositions[0]->longitude : '') }}" required>
                    </div>

                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/boats.show.positions_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
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
                                <a class="button is-danger is-light is-small" href="{{ route('admin.boats.boat_types.delete', [$boat, $boatType]) }}">@lang('admin/boats.show.boat_types_remove_button')</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boatBoatTypes->links() }}
        @else
            <p><i>@lang('admin/boats.show.boat_types_empty')</i></p>
        @endif

        @if ($boat->boatTypes->count() != $boatTypes->count())
            <form method="POST" action="{{ route('admin.boats.boat_types.store', $boat) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <div class="select @error('boat_type_id') is-danger @enderror">
                            <select id="boat_type_id" name="boat_type_id" required>
                                <option selected disabled>
                                    @lang('admin/boats.show.boat_types_placeholder')
                                </option>

                                @foreach ($boatTypes as $boatType)
                                    @if (!$boatBoatTypes->pluck('id')->contains($boatType->id))
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
                                <a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a>

                                @if ($user->pivot->role == App\Models\BoatUser::ROLE_CREW)
                                    <span class="tag is-pulled-right is-success">@lang('admin/boats.show.users_role_crew')</span>
                                @endif

                                @if ($user->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                                    <span class="tag is-pulled-right is-link">@lang('admin/boats.show.users_role_captain')</span>
                                @endif

                                @if ($user->pivot->role == App\Models\BoatUser::ROLE_OWNER)
                                    <span class="tag is-pulled-right is-warning">@lang('admin/boats.show.users_role_owner')</span>
                                @endif
                            </h3>

                            @if ($user->pivot->role == App\Models\BoatUser::ROLE_CREW || $boatNotCrew->count() > 1)
                                <div class="buttons">
                                    @if ($user->pivot->role == App\Models\BoatUser::ROLE_OWNER)
                                        <a class="button is-link is-light is-small" href="{{ route('admin.boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_CAPTAIN }}">
                                            @lang('admin/boats.show.users_make_captain_button')
                                        </a>
                                        <a class="button is-success is-light is-small" href="{{ route('admin.boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_CREW }}">
                                            @lang('admin/boats.show.users_make_crew_button')
                                        </a>
                                    @elseif ($user->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                                        <a class="button is-warning is-light is-small" href="{{ route('admin.boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_OWNER }}">
                                            @lang('admin/boats.show.users_make_owner_button')
                                        </a>
                                        <a class="button is-success is-light is-small" href="{{ route('admin.boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_CREW }}">
                                            @lang('admin/boats.show.users_make_crew_button')
                                        </a>
                                    @else
                                        <a class="button is-warning is-light is-small" href="{{ route('admin.boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_OWNER }}">
                                            @lang('admin/boats.show.users_make_owner_button')
                                        </a>
                                        <a class="button is-link is-light is-small" href="{{ route('admin.boats.users.update', [$boat, $user]) }}?role={{ App\Models\BoatUser::ROLE_CAPTAIN }}">
                                            @lang('admin/boats.show.users_make_captain_button')
                                        </a>
                                    @endif

                                    <a class="button is-danger is-light is-small" href="{{ route('admin.boats.users.delete', [$boat, $user]) }}">
                                        @lang('admin/boats.show.users_remove_button')
                                    </a>
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

        @if ($boat->users->count() != $users->count())
            <form method="POST" action="{{ route('admin.boats.users.store', $boat) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <div class="select @error('user_id') is-danger @enderror">
                            <select id="user_id" name="user_id" required>
                                <option selected disabled>
                                    @lang('admin/boats.show.users_placeholder')
                                </option>

                                @foreach ($users as $user)
                                    @if (!$boatUsers->pluck('id')->contains($user->id))
                                        <option value="{{ $user->id }}"  @if ($user->id == old('user_id')) selected @endif>
                                            {{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <div class="select is-fullwidth @error('role') is-danger @enderror">
                            <select id="role" name="role" required>
                                <option value="{{ App\Models\BoatUser::ROLE_CREW }}"
                                    @if (App\Models\BoatUser::ROLE_CREW == old('role', App\Models\BoatUser::ROLE_CREW)) selected @endif>
                                    @lang('admin/boats.show.users_role_crew_placeholder')
                                </option>

                                <option value="{{ App\Models\BoatUser::ROLE_CAPTAIN }}"
                                    @if (App\Models\BoatUser::ROLE_CAPTAIN == old('role', App\Models\BoatUser::ROLE_CREW)) selected @endif>
                                    @lang('admin/boats.show.users_role_captain_placeholder')
                                </option>

                                <option value="{{ App\Models\BoatUser::ROLE_OWNER }}"
                                    @if (App\Models\BoatUser::ROLE_OWNER == old('role', App\Models\BoatUser::ROLE_CREW)) selected @endif>
                                    @lang('admin/boats.show.users_role_owner_placeholder')
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

    <!-- Boat guests -->
    <div class="box content">
        <h2 class="title is-4">@lang('boats.show.guests')</h2>

        @if ($boatGuests->count() > 0)
            {{ $boatGuests->links() }}

            <div class="columns is-multiline">
                @foreach ($boatGuests as $guest)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4">
                                {{ $guest->name }}

                                <span class="tag is-pulled-right is-success">@lang('boats.show.guests_role_crew')</span>
                            </h3>

                            @canany(['update_boat_user', 'delete_boat_user'], $boat)
                                <div class="buttons">
                                    @can('update_boat_user', $boat)
                                        <a class="button is-link is-light is-small" href="{{ route('admin.boats.guests.edit', [$boat, $guest]) }}">
                                            @lang('boats.show.guest_edit_button')
                                        </a>
                                    @endcan
                                    @can('delete_boat_user', $boat)
                                        <a class="button is-danger is-light is-small" href="{{ route('admin.boats.guests.delete', [$boat, $guest]) }}">
                                            @lang('boats.show.guests_remove_button')
                                        </a>
                                    @endcan
                                </div>
                            @endcanany
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boatGuests->links() }}
        @else
            <p><i>@lang('boats.show.guests_empty')</i></p>
        @endif

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.boats.guests.create', [$boat]) }}">@lang('boats.show.guests_create_button')</a>
        </div>
    </div>
@endsection
