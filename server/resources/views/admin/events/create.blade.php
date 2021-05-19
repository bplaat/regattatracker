@extends('layout')

@section('title', __('admin/events.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.title')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li class="is-active"><a
                    href="{{ route('admin.events.create') }}">@lang('admin/events.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/events.create.header')</h1>

    <form method="POST" action="{{ route('admin.events.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/events.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name"
                       value="{{ old('name') }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="columns">
            <div class="column">
                <label class="label" for="start">@lang('admin/events.create.start')</label>
                <div class="field">
                    <div class="control">
                        <input class="input @error('start') is-danger @enderror" type="date"
                               id="start" name="start" value="{{ old('start') }}">
                    </div>

                    @error('start')
                        <p class="help is-danger">{{ $errors->first('start') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <label class="label" for="end">@lang('admin/events.create.end')</label>
                <div class="field">
                    <div class="control">
                        <input class="input @error('end') is-danger @enderror" type="date" id="end"
                               name="end" value="{{ old('end') }}">
                    </div>

                    @error('end')
                        <p class="help is-danger">{{ $errors->first('end') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="connected">@lang('admin/events.create.connected')</label>

            <div class="control">
                <div class="select is-fullwidth @error('connected') is-danger @enderror">
                    <select id="connected" name="connected" required>
                        <option value="{{ App\Models\Event::CONNECTED_TRUE }}" @if (App\Models\Event::CONNECTED_TRUE == old('connected', App\Models\Event::CONNECTED_TRUE)) selected @endif>
                            @lang('admin/events.create.connected_true')
                        </option>

                        <option value="{{ App\Models\Event::CONNECTED_FALSE }}" @if (App\Models\Event::CONNECTED_FALSE == old('connected', App\Models\Event::CONNECTED_TRUE)) selected @endif>
                            @lang('admin/events.create.connected_false')
                        </option>
                    </select>
                </div>
            </div>

            @error('connected')
                <p class="help is-danger">{{ $errors->first('connected') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/events.create.create_button')</button>
            </div>
        </div>
    </form>
@endsection
