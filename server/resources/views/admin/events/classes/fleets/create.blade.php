@extends('layout')

@section('title', __('admin/classes.create.title', ['event.name' => $event->name, 'class.name' => $class->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $class->name }}</a></li>
            <li class="is-active"><a
                    href="{{ route('admin.events.classes.fleets.create', [$event, $class]) }}">@lang('admin/classes.fleets.create.breadcrumb')</a>
            </li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/fleets.create.header')</h1>
    <form method="POST" action="{{ route('admin.events.classes.fleets.store', [$event, $class]) }}">
        @csrf
        <p>@lang('admin/fleets.create.name')</p>
        <div class="control">
            <input class="input @error('name') is-danger @enderror" type="text" id="name"
                   name="name"
                   placeholder="@lang('admin/fleets.create.name')"
                   value="{{old('name')}}" required>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link"
                        type="submit">@lang('admin/fleets.create.button')</button>
            </div>
        </div>
    </form>
@endsection
