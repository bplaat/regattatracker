@extends('layout')

@section('title', __('admin/api_keys.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.api_keys.index') }}">@lang('admin/api_keys.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/api_keys.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.api_keys.create') }}">@lang('admin/api_keys.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/api_keys.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/api_keys.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($apiKeys->count() > 0)
            {{ $apiKeys->links() }}

            <div class="columns is-multiline">
                @foreach ($apiKeys as $apiKey)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title">
                                <a href="{{ route('admin.api_keys.show', $apiKey) }}">{{ $apiKey->name }}</a>

                                @if ($apiKey->level == App\Models\ApiKey::LEVEL_REQUIRE_AUTH)
                                    <span class="tag is-pulled-right is-success">@lang('admin/api_keys.index.level_require_auth')</span>
                                @endif

                                @if ($apiKey->level == App\Models\ApiKey::LEVEL_NO_AUTH)
                                    <span class="tag is-pulled-right is-danger">@lang('admin/api_keys.index.level_no_auth')</span>
                                @endif
                            </h2>
                            <p>@lang('admin/api_keys.index.key') <code>{{ $apiKey->key }}</code></p>
                            <p>@lang('admin/api_keys.index.requests') <strong>{{ $apiKey->requests }}</strong></p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $apiKeys->links() }}
        @else
            <p><i>@lang('admin/api_keys.index.empty')</i></p>
        @endif
    </div>
@endsection
