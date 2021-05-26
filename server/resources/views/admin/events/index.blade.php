@extends('layout')

@section('title', __('admin/events.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/events.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.events.create') }}">@lang('admin/events.index.create_button')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/events.index.query_placeholder')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/events.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($events->count() > 0)
            {{ $events->links() }}

            <div class="columns is-multiline">
                @foreach ($events as $event)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a>
                            </h2>

                            @if ($event->start != null)
                                <p>@lang('admin/events.index.start') {{ $event->start }}</p>
                            @else
                                <p><i>@lang('admin/events.index.start_empty')</i></p>
                            @endif

                            @if ($event->end != null)
                                <p>@lang('admin/events.index.end') {{ $event->end }}</p>
                            @else
                                <p><i>@lang('admin/events.index.end_empty')</i></p>
                            @endif

                            <p>
                                @lang('admin/events.index.connected')
                                @if ($event->connected == App\Models\Event::CONNECTED_TRUE)
                                    @lang('admin/events.index.connected_true')
                                @else
                                    @lang('admin/events.index.connected_false')
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $events->links() }}
        @else
            <p><i>@lang('admin/events.index.empty')</i></p>
        @endif
    </div>
@endsection
