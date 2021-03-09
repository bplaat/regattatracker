@extends('layout')

@section('title', __('boats.show.title', [ 'boat.name' => $boat->name ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('boats.index') }}">@lang('boats.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 class="title"><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></h2>
        <p style="white-space: pre;">{{ $boat->description }}</a></p>
    </div>

    <div class="buttons">
        <a class="button is-link" href="{{ route('boats.edit', $boat) }}">@lang('boats.show.edit')</a>
        <a class="button is-danger" href="{{ route('boats.delete', $boat) }}">@lang('boats.show.delete')</a>
    </div>
@endsection
