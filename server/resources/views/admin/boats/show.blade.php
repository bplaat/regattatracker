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

    <div class="content">
        <h2 class="title"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></h2>
        <p style="white-space: pre;">{{ $boat->description }}</a></p>
        <p>@lang('admin/boats.show.owner') <a href="{{ route('admin.users.show', $boat->user) }}">{{ $boat->user->firstname }} {{ $boat->user->lastname }}</a></p>
    </div>

    <div class="buttons">
        <a class="button is-link" href="{{ route('admin.boats.edit', $boat) }}">@lang('admin/boats.show.edit')</a>
        <a class="button is-danger" href="{{ route('admin.boats.delete', $boat) }}">@lang('admin/boats.show.delete')</a>
    </div>
@endsection
