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
                            <h2 class="title"><a href="{{ route('admin.api_keys.show', $apiKey) }}">{{ $apiKey->name }}</a></h2>
                            <p><code>{{ $apiKey->key }}</code></p>
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
