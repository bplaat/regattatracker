@extends('layout')

@section('title', __('admin/classes.edit.title', ['event.name' => $event->name, 'class.name' => $class->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="#">@lang('admin/classes.edit.breadcrumb') {{ $class->name }}</a></li>
            <li class="is-active"><a
                    href="{{ route('admin.events.classes.edit', [$event, $class]) }}">@lang('admin/classes.edit.breadcrumb')</a>
            </li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/finishes.edit.header')</h1>
    <form method="POST" action="{{ route('admin.events.classes.update', [$event, $class]) }}">
    @csrf
        <p>@lang('admin/classes.edit.name')</p>
        <div class="control">
            <input class="input @error('name') is-danger @enderror" type="text" id="name"
                   name="name"
                   placeholder="@lang('admin/classes.edit.name')"
                   value="{{old('name', $class->name)}}" required>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link"
                        type="submit">@lang('admin/classes.edit.button')</button>
            </div>
        </div>
    </form>
