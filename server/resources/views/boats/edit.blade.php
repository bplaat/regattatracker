@extends('layout')

@section('title', __('boats.edit.title', [ 'boat.name' => $boat->name ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('boats.index') }}">@lang('boats.index.breadcrumb')</a></li>
            <li><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></li>
            <li class="is-active"><a href="{{ route('boats.edit', $boat) }}">@lang('boats.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('boats.edit.header')</h1>

    <form method="POST" action="{{ route('boats.update', $boat) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('boats.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $boat->name) }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="description">@lang('boats.edit.description')</label>

            <div class="control">
                <textarea class="textarea @error('description') is-danger @enderror" id="description" name="description" required>{{ old('description', $boat->description) }}</textarea>
            </div>

            @error('description')
                <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('boats.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
