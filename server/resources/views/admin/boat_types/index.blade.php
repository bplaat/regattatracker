@extends('layout')

@section('title', __('admin/boat_types.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.boat_types.index') }}">@lang('admin/boat_types.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/boat_types.index.header')</h1>

        @forelse ($boatTypes as $boatType)
            <div class="box">
                <h2 class="title"><a href="{{ route('admin.boat_types.show', $boatType) }}">{{ $boatType->name }}</a></h2>
                @if ($boatType->description != null)
                    <p>{{ Str::limit($boatType->description, 64) }}</a></p>
                @endif
            </div>
        @empty
            <p><i>@lang('admin/boat_types.index.empty')</i></p>
        @endforelse
    </div>

    <div class="buttons">
        <a class="button is-link" href="{{ route('admin.boat_types.create') }}">@lang('admin/boat_types.index.create')</a>
    </div>
@endsection
