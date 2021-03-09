@extends('layout')

@section('title', __('admin/users/show.title', [ 'user.firstname' => $user->firstname, 'user.lastname' => $user->lastname ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.title')</a></li>
            <li><a href="{{ route('admin.users.index') }}">@lang('admin/users/index.short')</a></li>
            <li class="is-active"><a href="{{ route('admin.users.show', $user) }}">{{ $user->firstname }} {{ $user->lastname }}</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 class="title"><a href="{{ route('admin.users.show', $user) }}">{{ $user->firstname }} {{ $user->lastname }}</a></h2>
        <p>
            @if ($user->role == App\Models\User::ROLE_NORMAL)
                <span class="tag is-success">@lang('admin/users/show.role_normal')</span>
            @endif
            @if ($user->role == App\Models\User::ROLE_ADMIN)
                <span class="tag is-danger">@lang('admin/users/show.role_admin')</span>
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

    <div class="buttons">
        <a class="button is-link" href="{{ route('admin.users.edit', $user) }}">@lang('admin/users/show.edit')</a>
        <a class="button is-danger" href="{{ route('admin.users.delete', $user) }}">@lang('admin/users/show.delete')</a>
    </div>
@endsection
