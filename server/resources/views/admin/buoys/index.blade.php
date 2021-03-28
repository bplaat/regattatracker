@extends('layout')

@section('title', __('admin/buoys.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.buoys.index') }}">@lang('admin/buoys.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/buoys.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.buoys.create') }}">@lang('admin/buoys.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/buoys.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/buoys.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($buoys->count() > 0)
            {{ $buoys->links() }}

            <div class="columns is-multiline">
                @foreach ($buoys as $buoy)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4"><a href="{{ route('admin.buoys.show', $buoy) }}">{{ $buoy->name }}</a></h2>
                            @if ($buoy->description != null)
                                <p>{{ Str::limit($buoy->description, 64) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $buoys->links() }}
        @else
            <p><i>@lang('admin/buoys.index.empty')</i></p>
        @endif
    </div>
@endsection
