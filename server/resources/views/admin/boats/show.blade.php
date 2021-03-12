@extends('layout')

@section('title', __('admin/boats.show.title', [ 'boat.name' => $boat->name ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
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

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.boats.edit', $boat) }}">@lang('admin/boats.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.boats.delete', $boat) }}">@lang('admin/boats.show.delete')</a>
        </div>
    </div>

    <!-- Boat boat types -->
    <div class="box content">
        <h2 class="title is-4">@lang('admin/boats.show.boat_types')</h2>

        @if ($boatBoatTypes->count() > 0)
            {{ $boatBoatTypes->links() }}

            @foreach ($boatBoatTypes as $boatType)
                <div class="box">
                    <h3 class="title is-4"><a href="{{ route('admin.boat_types.show', $boatType) }}">{{ $boatType->name }}</a></h3>
                    @if ($boatType->description != null)
                        <p>{{ Str::limit($boatType->description, 64) }}</a></p>
                    @endif

                    <div class="buttons">
                        <a class="button is-danger" href="{{ route('admin.boats.boat_types.delete', [ $boat, $boatType ]) }}">@lang('admin/boats.show.boat_types_remove_button')</a>
                    </div>
                </div>
            @endforeach

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
                                    @if (!in_array($boatType->name, $boatBoatTypes->pluck('name')->toArray()))
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

            @foreach ($boatUsers as $user)
                <div class="box">
                    <h3 class="title is-4">
                        <a href="{{ route('admin.users.show', $user) }}">{{ $user->firstname }} {{ $user->lastname }}</a>

                        @if ($user->pivot->role == App\Models\BoatUser::ROLE_CREW)
                            <span class="tag is-pulled-right is-success">@lang('admin/boats.show.users_role_crew')</span>
                        @endif

                        @if ($user->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                            <span class="tag is-pulled-right is-info">@lang('admin/boats.show.users_role_captain')</span>
                        @endif
                    </h3>

                    @if ($user->pivot->role != App\Models\BoatUser::ROLE_CAPTAIN || $boatCaptains->count() > 1)
                        <div class="buttons">
                            <a class="button is-danger" href="{{ route('admin.boats.users.delete', [ $boat, $user ]) }}">@lang('admin/boats.show.users_remove_button')</a>
                        </div>
                    @endif
                </div>
            @endforeach

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
                                    @if (!in_array($user->id, $boatUsers->pluck('id')->toArray()))
                                        <option value="{{ $user->id }}"  @if ($user->id == old('user_id')) selected @endif>
                                            {{ $user->firstname }} {{ $user->lastname }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <div class="select @error('role') is-danger @enderror">
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
