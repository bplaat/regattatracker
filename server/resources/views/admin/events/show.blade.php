@extends('layout')

@section('title', __('admin/events.show.title', ['event.name' => $event->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $event->name }}</h1>

        <h2 class="subtitle is-5">@lang('admin/events.show.dates')</h2>

        @if ($event->start != null)
            <p>@lang('admin/events.show.start') {{ $event->start }}</p>
        @else
            <p><i>@lang('admin/events.show.start_empty')</i></p>
        @endif

        @if ($event->end != null)
            <p>@lang('admin/events.show.end') {{ $event->end }}</p>
        @else
            <p><i>@lang('admin/events.show.end_empty')</i></p>
        @endif

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.events.edit', $event) }}">@lang('admin/events.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.events.delete', $event) }}">@lang('admin/events.show.delete')</a>
        </div>
    </div>


@endsection
