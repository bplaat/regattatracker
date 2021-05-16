@extends('layout')

@section('title', __('admin/classes.create.title', ['event.name' => $event->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li class="is-active"><a
                    href="{{ route('admin.events.classes.create', ['event' => $event]) }}">@lang('admin/classes.create.breadcrumb')</a>
            </li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/classes.create.header')</h1>
    <form method="POST" action="{{ route('admin.events.classes.store', [$event]) }}">
        @csrf
        <p>@lang('admin/classes.create.name')</p>
        <div class="control">
            <input class="input @error('name') is-danger @enderror" type="text" id="name"
                   name="name"
                   placeholder="@lang('admin/classes.create.name')"
                   value="{{old('name')}}" required>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link"
                        type="submit">@lang('admin/classes.create.button')</button>
            </div>
        </div>
    </form>
@endsection
