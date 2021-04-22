@extends('layout')

@section('title', __('admin/competitions.edit.title', ['competition.name' => $competition->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.competitions.index') }}">@lang('admin/competitions.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.competitions.show', $competition) }}">{{ $competition->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.competitions.edit', $competition) }}">@lang('admin/competitions.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/competitions.edit.header')</h1>

    <form method="POST" action="{{ route('admin.competitions.update', $competition) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/competitions.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $competition->name) }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="columns">
            <div class="column">
                <label class="label" for="start_date">@lang('admin/competitions.edit.start')</label>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('start_date') is-danger @enderror" type="date" id="start_date"
                                       name="start_date" value="{{ old('start_date', $competition->start == null ? '' : date('Y-m-d', strtotime($competition->start))) }}">
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
                                       name="start_time" value="{{ old('start_time', $competition->start == null ? '' : date('H:i', strtotime($competition->start))) }}">
                            </div>

                            @error('start_time')
                                <p class="help is-danger">{{ $errors->first('start_time') }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="column">
                <label class="label" for="end_date">@lang('admin/competitions.edit.end')</label>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('end_date') is-danger @enderror" type="date" id="end_date"
                                       name="end_date" value="{{ old('end_date', $competition->end == null ? '' : date('Y-m-d', strtotime($competition->end))) }}">
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
                                       name="end_time" value="{{ old('end_time', $competition->end == null ? '' : date('H:i', strtotime($competition->end))) }}">
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
                <button class="button is-link" type="submit">@lang('admin/competitions.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
