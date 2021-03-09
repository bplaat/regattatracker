@extends('layout')

@section('title', __('admin/boat_types.show.title', [ 'boat_type.name' => $boatType->name ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boat_types.index') }}">@lang('admin/boat_types.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.boat_types.show', $boatType) }}">{{ $boatType->name }}</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 class="title"><a href="{{ route('admin.boat_types.show', $boatType) }}">{{ $boatType->name }}</a></h2>
        @if ($boatType->description != null)
            <p style="white-space: pre-wrap;">{{ $boatType->description }}</a></p>
        @endif
    </div>

    <div class="buttons">
        <a class="button is-link" href="{{ route('admin.boat_types.edit', $boatType) }}">@lang('admin/boat_types.show.edit')</a>
        <a class="button is-danger" href="{{ route('admin.boat_types.delete', $boatType) }}">@lang('admin/boat_types.show.delete')</a>
    </div>
@endsection
