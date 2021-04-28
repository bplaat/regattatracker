@extends('layout')

@section('title', __('admin/competitions.show.title', ['competition.name' => $competition->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.competitions.index') }}">@lang('admin/competitions.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.competitions.show', $competition) }}">{{ $competition->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $competition->name }}</h1>

        <h2 class="subtitle is-5">@lang('admin/competitions.show.dates')</h2>

        @if ($competition->start != null)
            <p>@lang('admin/competitions.show.start'): {{ $competition->start }}</p>
        @else
            <p><i>@lang('admin/competitions.show.start_empty')</i></p>
        @endif

        @if ($competition->end != null)
            <p>@lang('admin/competitions.show.end'): {{ $competition->end }}</p>
        @else
            <p><i>@lang('admin/competitions.show.end_empty')</i></p>
        @endif

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.competitions.edit', $competition) }}">@lang('admin/competitions.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.competitions.delete', $competition) }}">@lang('admin/competitions.show.delete')</a>
        </div>
    </div>


@endsection
