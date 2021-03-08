@extends('layout')

@section('title', __('admin/boats/show.title', [ 'boat.name' => $boat->name ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.title')</a></li>
            <li><a href="{{ route('admin.boats.index') }}">@lang('admin/boats/index.title')</a></li>
            <li class="is-active"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 class="title"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></h2>
        <p style="white-space: pre;">{{ $boat->description }}</a></p>
        <p>@lang('admin/boats/index.owner') <a href="{{ route('admin.users.show', $boat->user) }}">{{ $boat->user->firstname }} {{ $boat->user->lastname }}</a></p>
    </div>
@endsection
