@extends('layout')

@section('title', __('admin/users.show.title', [ 'user.firstname' => $user->firstname, 'user.lastname' => $user->lastname ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.users.index') }}">@lang('admin/users.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.users.show', $user) }}">{{ $user->firstname }} {{ $user->lastname }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-4">
            {{ $user->firstname }} {{ $user->lastname }}

            @if ($user->role == App\Models\User::ROLE_NORMAL)
                <span class="tag is-pulled-right is-success">@lang('admin/users.show.role_normal')</span>
            @endif

            @if ($user->role == App\Models\User::ROLE_ADMIN)
                <span class="tag is-pulled-right is-danger">@lang('admin/users.show.role_admin')</span>
            @endif
        </h1>
        <p><a class="tag" href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>

        <div class="buttons">
            @if ($user->id != Auth::id())
                <a class="button is-black" href="{{ route('admin.users.hijack', $user) }}">@lang('admin/users.show.hijack')</a>
            @endif
            <a class="button is-link" href="{{ route('admin.users.edit', $user) }}">@lang('admin/users.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.users.delete', $user) }}">@lang('admin/users.show.delete')</a>
        </div>
    </div>

    <!-- User boats -->
    <div class="box content">
        <h2 class="title is-4">@lang('admin/users.show.boats_title')</h2>

        @if (count($boats) > 0)
            {{ $boats->links() }}

            @foreach ($boats as $boat)
                <div class="box">
                    <h3 class="title is-4"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></h3>
                    @if ($boat->description != null)
                        <p>{{ Str::limit($boat->description, 64) }}</a></p>
                    @endif
                </div>
            @endforeach

            {{ $boats->links() }}
        @else
            <p><i>@lang('admin/users.show.boats_empty')</i></p>
        @endif
    </div>

    <!-- User crew boats -->
    <div class="box content">
        <h2 class="title is-4">@lang('admin/users.show.crew_boats_title')</h2>

        @if (count($crewBoats) > 0)
            {{ $crewBoats->links() }}

            @foreach ($crewBoats as $crewBoat)
                <div class="box">
                    <h3 class="title is-4">
                        <a href="{{ route('admin.boats.show', $crewBoat) }}">{{ $crewBoat->name }}</a>

                        @if ($crewBoat->pivot->role == App\Models\BoatUser::ROLE_CREW)
                            <span class="tag is-pulled-right is-success">@lang('admin/users.show.crew_boats_role_crew')</span>
                        @endif

                        @if ($crewBoat->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                            <span class="tag is-pulled-right is-info">@lang('admin/users.show.crew_boats_role_captain')</span>
                        @endif
                    </h3>
                    @if ($crewBoat->description != null)
                        <p>{{ Str::limit($crewBoat->description, 64) }}</a></p>
                    @endif
                </div>
            @endforeach

            {{ $crewBoats->links() }}
        @else
            <p><i>@lang('admin/users.show.crew_boats_empty')</i></p>
        @endif
    </div>
@endsection
