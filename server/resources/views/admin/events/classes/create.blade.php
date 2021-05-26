@extends('layout')

@section('title', __('admin/events.classes.create.title', ['event.name' => $event->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="#">@lang('admin/events.classes.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.events.classes.create', $event) }}">@lang('admin/events.classes.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/events.classes.create.header')</h1>

    <form method="POST" action="{{ route('admin.events.classes.store', $event) }}">
        @csrf

        <div class="field">
            <label class="label" for="flag">@lang('admin/events.classes.create.flag')</label>

            <div class="control">
                <div class="select">
                    <select id="flag" name="flag">
                        <option {{'None' == old('flag', 'None') ? 'selected' : '' }} value="-">@lang('admin/events.classes.create.flag.none')</option>
                        {{$letter = 'A'}}
                        @for ($i=0; $i < 26; $i++)
                            <option
                                {{ $letter == old('flag', 'None') ? 'selected' : '' }} value="{{ $letter }}">{{ $letter }}</option>
                            {{$letter++}}
                        @endfor
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="name">@lang('admin/events.classes.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name"
                       name="name" value="{{ old('name') }}" required>
            </div>

            @error('name')
            <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/events.classes.create.create_button')</button>
            </div>
        </div>
    </form>
@endsection
