@extends('layout')

@section('title', __('boats.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li class="is-active"><a href="{{ route('boats.index') }}">@lang('boats.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('boats.index.header')</h1>

        @forelse ($boats as $boat)
            <div class="box">
                <h2 class="title"><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></h2>
                @if ($boat->description != null)
                    <p>{{ Str::limit($boat->description, 64) }}</a></p>
                @endif
            </div>
        @empty
            <p><i>@lang('boats.index.empty')</i></p>
        @endforelse
    </div>

    <div class="buttons">
        <a class="button is-link" href="{{ route('boats.create') }}">@lang('boats.index.create')</a>
    </div>
@endsection
