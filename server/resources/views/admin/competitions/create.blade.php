@extends('layout')

@section('title', __('admin/competitions.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.title')</a></li>
            <li><a href="{{ route('admin.competitions.index') }}">@lang('admin/competitions.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.competitions.create') }}">@lang('admin/competitions.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/competitions.create.header')</h1>

    <form method="POST" action="{{ route('admin.competitions.store') }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/competitions.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="columns">
            <div class="column">
                <label class="label" for="start_date">@lang('admin/competitions.create.start')</label>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('start_date') is-danger @enderror" type="date" id="start_date"
                                       name="start_date" value="{{ old('start_date') }}">
                            </div>

                            @error('start_date')
                                <p class="help is-danger">{{ $errors->first('start_date') }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('start_time') is-danger @enderror" type="time" id="start_time"
                                       name="start_time" value="{{ old('start_time') }}">
                            </div>

                            @error('start_time')
                                <p class="help is-danger">{{ $errors->first('start_time') }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="column">
                <label class="label" for="end_date">@lang('admin/competitions.create.end')</label>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('end_date') is-danger @enderror" type="date" id="end_date"
                                       name="end_date" value="{{ old('end_date') }}">
                            </div>

                            @error('end_date')
                                <p class="help is-danger">{{ $errors->first('end_date') }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('end_time') is-danger @enderror" type="time" id="end_time"
                                       name="end_time" value="{{ old('end_time') }}">
                            </div>

                            @error('end_time')
                                <p class="help is-danger">{{ $errors->first('end_time') }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/competitions.create.button')</button>
            </div>
        </div>
    </form>
@endsection
