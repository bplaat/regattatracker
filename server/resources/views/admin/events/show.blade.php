@extends('layout')

@section('title', __('admin/events.show.title', ['event.name' => $event->name]))

@section('head')
    <link rel="stylesheet" href="/css/mapbox-gl.css"/>
    <script src="/js/mapbox-gl.js"></script>
@endsection

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">{{ $event->name }}</h1>

        <h2 class="subtitle is-5">@lang('admin/events.show.dates')</h2>

        @if ($event->start != null)
            <p>@lang('admin/events.show.start') {{ $event->start }}</p>
        @else
            <p><i>@lang('admin/events.show.start_empty')</i></p>
        @endif

        @if ($event->end != null)
            <p>@lang('admin/events.show.end') {{ $event->end }}</p>
        @else
            <p><i>@lang('admin/events.show.end_empty')</i></p>
        @endif

        <div class="buttons">
            <a class="button is-link"
               href="{{ route('admin.events.edit', $event) }}">@lang('admin/events.show.edit')</a>
            <a class="button is-danger"
               href="{{ route('admin.events.delete', $event) }}">@lang('admin/events.show.delete')</a>
        </div>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">@lang('admin/events.show.map')</h1>

        <div class="box" style="position: relative; padding-top: 50%; background-color: #191a1a; overflow: hidden;">
            <div id="map-container" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;"></div>
        </div>

        <script>
            window.data = {
                csrfToken: @json(csrf_token()),
                apiKey: @json(App\Models\ApiKey::where('name', 'Website')->first()->key),
                apiToken: @json(Auth::user()->apiToken()),
                mapboxAccessToken: @json(config('mapbox.access_token')),
                event: @json($event),
                link: @json(route('api.events.update', $event)),
                strings: {
                    add_point_button: @json(__('admin/events.show.add_point_button')),
                    add_finish_button: @json(__('admin/events.show.add_finish_button')),
                    save_button: @json(__('admin/events.show.save_button')),
                    latitude: @json(__('admin/events.show.latitude')),
                    longitude: @json(__('admin/events.show.longitude')),
                    delete_button: @json(__('admin/events.show.delete_button'))
                }
            };
        </script>
        <script src="/js/event_map.js"></script>
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">@lang('admin/events.show.finishes')</h1>
        @if ($event->finishes->count() > 0)
            @foreach ($event->finishes as $finish)
                <div class="box content">
                    <h1 class="title is-spaced is-4">@lang('admin/events.show.finishes.finish', ['finish.id' => $finish->id])</h1>
                    <p>@lang('admin/events.show.finishes.create.point_a'): {{$finish->latitude_a}},{{$finish->longitude_a}}</p>
                    <p>@lang('admin/events.show.finishes.create.point_b'): {{$finish->latitude_b}},{{$finish->longitude_b}}</p>
                    <div class="buttons">
                        <a class="button is-link"
                           href="{{ route('admin.events.finishes.edit', ['event' => $event, 'finish' => $finish]) }}">@lang('admin/events.show.finishes.edit')</a>
                        <a class="button is-danger"
                           href="{{ route('admin.events.finishes.delete', ['event' => $event, 'finish' => $finish]) }}">@lang('admin/events.show.finishes.delete')</a>
                    </div>
                </div>
            @endforeach
        @elseif ($event->finishes->count() == 0)
            @lang('admin/events.show.finishes.empty')
        @endif
    </div>

    <div class="box content">
        <h1 class="title is-spaced is-4">@lang('admin/events.show.finishes.create')</h1>
        <form method="POST" action="{{ route('admin.events.finishes.create', $event) }}">
            @csrf

            <p>@lang('admin/events.show.finishes.create.point_a')</p>
            <div class="field has-addons">
                <div class="control">
                    <input class="input @error('latitude_a') is-danger @enderror" type="text" id="latitude_a"
                           name="latitude_a"
                           placeholder="@lang('admin/events.show.finishes.create.latitude_a_field')"
                           value="{{ old('latitude_a') }}" required>
                </div>

                <div class="control">
                    <input class="input @error('longitude_a') is-danger @enderror" type="text" id="longitude_a"
                           name="longitude_a"
                           placeholder="@lang('admin/events.show.finishes.create.longitude_a_field')"
                           value="{{ old('longitude_a') }}" required>
                </div>
            </div>

            <p>@lang('admin/events.show.finishes.create.point_b')</p>
            <div class="field has-addons">
                <div class="control">
                    <input class="input @error('latitude_b') is-danger @enderror" type="text" id="latitude_b"
                           name="latitude_b"
                           placeholder="@lang('admin/events.show.finishes.create.latitude_b_field')"
                           value="{{ old('latitude_b') }}" required>
                </div>

                <div class="control">
                    <input class="input @error('longitude_b') is-danger @enderror" type="text" id="longitude_b"
                           name="longitude_b"
                           placeholder="@lang('admin/events.show.finishes.create.longitude_b_field')"
                           value="{{ old('longitude_b') }}" required>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link"
                            type="submit">@lang('admin/events.show.finishes.create.button')</button>
                </div>
            </div>
        </form>
    </div>
@endsection
