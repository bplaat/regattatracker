@extends('layout')

@section('title', __('admin/users/show.title', [ 'user_firstname' => $user->firstname, 'user_lastname' => $user->lastname ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.title')</a></li>
            <li><a href="{{ route('admin.users.index') }}">@lang('admin/users/index.title')</a></li>
            <li class="is-active"><a href="{{ route('admin.users.show', $user) }}">{{ $user->firstname }} {{ $user->lastname }}</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 class="title"><a href="{{ route('admin.users.show', $user) }}">{{ $user->firstname }} {{ $user->lastname }}</a></h2>
        <p>
            @if ($user->role == App\Models\User::ROLE_NORMAL)
                <span class="tag is-success">NORMAL</span>
            @endif
            @if ($user->role == App\Models\User::ROLE_ADMIN)
                <span class="tag is-danger">ADMIN</span>
            @endif
        </p>
        <p><a class="tag" href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>

        <h2 class="title is-3">@lang('admin/users/show.boats_title')</h1>

        @forelse ($user->boats as $boat)
            <div class="box">
                <h2 class="title"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></h2>
                <p>{{ Str::limit($boat->description, 64) }}</a></p>
            </div>
        @empty
            <p><i>@lang('admin/users/show.boats_empty')</i></p>
        @endforelse
    </div>
@endsection
