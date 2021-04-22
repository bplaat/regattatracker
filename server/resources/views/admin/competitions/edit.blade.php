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
                <label class="label" for="end">@lang('admin/competitions.edit.start')</label>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('start') is-danger @enderror" type="date" id="start"
                                       name="start" value="{{ old('start', $competition->start) }}">
                            </div>

                            @error('start')
                            <p class="help is-danger">{{ $errors->first('start') }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('start') is-danger @enderror" type="time" step="1" id="starttime"
                                       name="starttime" value="{{ old('starttime', $competition->startTime()) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="column">
                <label class="label" for="end">@lang('admin/competitions.edit.end')</label>
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('end') is-danger @enderror" type="date" id="end"
                                       name="end" value="{{ old('end', $competition->end) }}">
                            </div>

                            @error('end')
                            <p class="help is-danger">{{ $errors->first('end') }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input class="input @error('end') is-danger @enderror" type="time" step="1" id="endtime"
                                       name="endtime" value="{{ old('endtime', $competition->endTime()) }}">
                            </div>
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
