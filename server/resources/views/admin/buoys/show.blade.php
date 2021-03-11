@extends('layout')

@section('title', __('admin/buoys.show.title', [ 'buoy.name' => $buoy->name ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.buoys.index') }}">@lang('admin/buoys.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.buoys.show', $buoy) }}">{{ $buoy->name }}</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 class="title"><a href="{{ route('admin.buoys.show', $buoy) }}">{{ $buoy->name }}</a></h2>
        @if ($buoy->description != null)
            <p style="white-space: pre-wrap;">{{ $buoy->description }}</a></p>
        @endif
    </div>

    <div class="buttons">
        <a class="button is-link" href="{{ route('admin.buoys.edit', $buoy) }}">@lang('admin/buoys.show.edit')</a>
        <a class="button is-danger" href="{{ route('admin.buoys.delete', $buoy) }}">@lang('admin/buoys.show.delete')</a>
    </div>
@endsection
