@extends('layout')

@section('title', __('admin/fleets.edit.title', ['event.name' => $event->name, 'class.name' => $class->name, 'fleet.name' => $fleet->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $class->name }}</a></li>
            <li><a href="#">@lang('admin/fleets.edit.breadcrumb') {{$fleet->name}}</a></li>
            <li class="is-active"><a
                    href="{{ route('admin.events.classes.fleets.edit', [$event, $class, $fleet]) }}">@lang('admin/fleets.edit.breadcrumb')</a>
            </li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/fleets.edit.header')</h1>
    <form method="POST" action="{{ route('admin.events.classes.fleets.update', [$event, $class, $fleet]) }}">
        @csrf
        <p>@lang('admin/fleets.edit.name')</p>
        <div class="control">
            <input class="input @error('name') is-danger @enderror" type="text" id="name"
                   name="name"
                   placeholder="@lang('admin/fleets.edit.name')"
                   value="{{old('name', $fleet->name)}}" required>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link"
                        type="submit">@lang('admin/fleets.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
