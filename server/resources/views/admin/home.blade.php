@extends('layout')

@section('title', __('admin/home.title'))

@section('content')
<div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li class="is-active"><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/home.header')</h1>
    </div>

    <div class="buttons">
        <a class="button" href="{{ route('admin.users.index') }}">@lang('admin/home.users')</a>
        <a class="button" href="{{ route('admin.boats.index') }}">@lang('admin/home.boats')</a>
        <a class="button" href="{{ route('admin.boat_types.index') }}">@lang('admin/home.boat_types')</a>
    </div>
@endsection
