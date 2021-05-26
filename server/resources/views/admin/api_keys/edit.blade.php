@extends('layout')

@section('title', __('admin/api_keys.edit.title', ['api_key.name' => $apiKey->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.api_keys.index') }}">@lang('admin/api_keys.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.api_keys.show', $apiKey) }}">{{ $apiKey->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.api_keys.edit', $apiKey) }}">@lang('admin/api_keys.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/api_keys.edit.header')</h1>

    <form method="POST" action="{{ route('admin.api_keys.update', $apiKey) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/api_keys.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $apiKey->name) }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="key">@lang('admin/api_keys.edit.key')</label>

            <div class="control">
                <input class="input" type="text" id="key" value="{{ $apiKey->key }}" disabled required>
            </div>
        </div>

        <div class="field">
            <label class="label" for="level">@lang('admin/api_keys.edit.level')</label>

            <div class="control">
                <div class="select is-fullwidth @error('level') is-danger @enderror">
                    <select id="level" name="level" required>
                        <option value="{{ App\Models\ApiKey::LEVEL_REQUIRE_AUTH }}" @if (App\Models\ApiKey::LEVEL_REQUIRE_AUTH == old('level', $apiKey->level)) selected @endif>
                            @lang('admin/api_keys.edit.level_require_auth')
                        </option>

                        <option value="{{ App\Models\ApiKey::LEVEL_NO_AUTH }}" @if (App\Models\ApiKey::LEVEL_NO_AUTH == old('level', $apiKey->level)) selected @endif>
                            @lang('admin/api_keys.edit.level_no_auth')
                        </option>
                    </select>
                </div>
            </div>

            @error('level')
                <p class="help is-danger">{{ $errors->first('level') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="requests">@lang('admin/api_keys.edit.requests')</label>

            <div class="control">
                <input class="input" type="text" id="requests" value="{{ $apiKey->requests }}" disabled required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/api_keys.edit.edit_button')</button>
            </div>
        </div>
    </form>
@endsection
