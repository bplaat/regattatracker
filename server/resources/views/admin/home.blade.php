@extends('layout')

@section('title', __('admin/home.title'))

@section('content')
<div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li class="is-active"><a href="{{ route('admin.home') }}">@lang('admin/home.title')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/home.title')</h1>
    </div>

    <div class="buttons">
        <a class="button" href="{{ route('admin.users.index') }}">@lang('admin/home.users')</a>
        <a class="button" href="{{ route('admin.boats.index') }}">@lang('admin/home.boats')</a>
    </div>
@endsection
