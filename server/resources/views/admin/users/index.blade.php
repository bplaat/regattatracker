@extends('layout')

@section('title', __('admin/users.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.users.index') }}">@lang('admin/users.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/users.index.header')</h1>

        @forelse ($users as $user)
            <div class="box">
                <h2 class="title">
                    <a href="{{ route('admin.users.show', $user) }}">{{ $user->firstname }} {{ $user->lastname }}</a>
                    @if ($user->role == App\Models\User::ROLE_NORMAL)
                        <span class="tag is-pulled-right is-success">@lang('admin/users.index.role_normal')</span>
                    @endif
                    @if ($user->role == App\Models\User::ROLE_ADMIN)
                        <span class="tag is-pulled-right is-danger">@lang('admin/users.index.role_admin')</span>
                    @endif
                </h2>
                <p><a class="tag" href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
            </div>
        @empty
            <p><i>@lang('admin/users.index.empty')</i></p>
        @endforelse
    </div>

    <div class="buttons">
        <a class="button is-link" href="{{ route('admin.users.create') }}">@lang('admin/users.index.create')</a>
    </div>
@endsection
