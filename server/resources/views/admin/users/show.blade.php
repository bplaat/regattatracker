@extends('layout')

@section('title', __('admin/users.show.title', ['user.name' => $user->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.users.index') }}">@lang('admin/users.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">
            {{ $user->name }}

            @if ($user->role == App\Models\User::ROLE_NORMAL)
                <span class="tag is-pulled-right is-success">@lang('admin/users.show.role_normal')</span>
            @endif

            @if ($user->role == App\Models\User::ROLE_ADMIN)
                <span class="tag is-pulled-right is-danger">@lang('admin/users.show.role_admin')</span>
            @endif
        </h1>

        @if ($user->avatar != null)
            <h2 class="subtitle is-5">@lang('admin/users.show.avatar')</h2>
            <div class="box" style="display: inline-block; background-color: #ccc;">
                <img src="/storage/avatars/{{ $user->avatar }}" alt="@lang('settings.avatar_alt', [ 'user.name' => $user->name ])">
            </div>
        @endif

        <h2 class="subtitle is-5">@lang('admin/users.show.personal_info')</h2>
        @if ($user->gender == App\Models\User::GENDER_MALE)
            <p>@lang('admin/users.show.gender') @lang('admin/users.show.gender_male')</p>
        @endif
        @if ($user->gender == App\Models\User::GENDER_FEMALE)
            <p>@lang('admin/users.show.gender') @lang('admin/users.show.gender_female')</p>
        @endif
        @if ($user->gender == App\Models\User::GENDER_OTHER)
            <p>@lang('admin/users.show.gender') @lang('admin/users.show.gender_other')</p>
        @endif
        <p>@lang('admin/users.show.birthday') {{ $user->birthday->format('Y-m-d') }}</p>

        <h2 class="subtitle is-5">@lang('admin/users.show.contact_info')</h2>
        <p>@lang('admin/users.show.email') <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
        @if ($user->phone != null)
            <p>@lang('admin/users.show.phone') <a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></p>
        @else
            <p>@lang('admin/users.show.phone') ?</p>
        @endif

        <h2 class="subtitle is-5">@lang('admin/users.show.address_info')</h2>
        <p>{{ $user->address }}</p>
        <p>{{ $user->postcode }}, {{ $user->city }} {{ $user->country }}</p>

        <div class="buttons">
            @if ($user->id != Auth::id())
                <a class="button is-black" href="{{ route('admin.users.hijack', $user) }}">@lang('admin/users.show.hijack_button')</a>
            @endif
            <a class="button is-link" href="{{ route('admin.users.edit', $user) }}">@lang('admin/users.show.edit_button')</a>
            <a class="button is-danger" href="{{ route('admin.users.delete', $user) }}">@lang('admin/users.show.delete_button')</a>
        </div>
    </div>

    <!-- User boats -->
    <div class="box content">
        <h2 class="title is-4">@lang('admin/users.show.boats')</h2>

        @if ($boats->count() > 0)
            {{ $boats->links() }}

            <div class="columns is-multiline">
                @foreach ($boats as $boat)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4">
                                <a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a>

                                @if ($boat->pivot->role == App\Models\BoatUser::ROLE_CREW)
                                    <span class="tag is-pulled-right is-success">@lang('admin/users.show.boats_role_crew')</span>
                                @endif

                                @if ($boat->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                                    <span class="tag is-pulled-right is-info">@lang('admin/users.show.boats_role_captain')</span>
                                @endif
                            </h3>

                            @if ($boat->description != null)
                                <p>{{ Str::limit($boat->description, 64) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boats->links() }}
        @else
            <p><i>@lang('admin/users.show.boats_empty')</i></p>
        @endif
    </div>
@endsection
