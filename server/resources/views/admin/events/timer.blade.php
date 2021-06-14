@extends('layout')

@section('title', __('admin/events.timer.title', ['event.name' => $event->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.events.timer', $event) }}">@lang('admin/events.timer.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-4">@lang('admin/events.timer.header')</h1>
        <p>@lang('admin/events.timer.info_message')</p>

        <form id="time_form">
            <div class="field">
                <label class="label" for="time_type">@lang('admin/events.timer.time_type')</label>

                <div class="control">
                    <div class="select is-fullwidth">
                        <select id="time_type" required>
                            <option value="started_at" selected>Start time</option>
                            <option value="finished_at">Finish time</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label" for="boat_thing">@lang('admin/events.timer.boat_thing')</label>

                        <div class="control">
                            <input class="input" type="text" id="boat_thing" autofocus required>
                        </div>

                        <p class="help">@lang('admin/events.timer.boat_thing_message')</p>
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="time" id="time_label">@lang('admin/events.timer.started_at')</label>

                        <div class="control">
                            <input class="input" type="text" id="time" minlength="6" maxlength="6" required>
                        </div>

                        <p class="help">@lang('admin/events.timer.time_message')</p>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link" type="submit">@lang('admin/events.timer.save_button')</button>
                </div>
            </div>
        </form>
    </div>

    <div class="box content">
        <h1 class="title is-4">@lang('admin/events.timer.times_header')</h1>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('admin/events.timer.name')</th>
                    <th>@lang('admin/events.timer.mmsi')</th>
                    <th>@lang('admin/events.timer.sail_number')</th>
                    <th>@lang('admin/events.timer.started_at')</th>
                    <th>@lang('admin/events.timer.finished_at')</th>
                    <th>@lang('admin/events.timer.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eventClassFleetBoats as $boat)
                    <tr id="boat_row_{{ $boat->id }}">
                        <td>{{ $boat->id }}</td>
                        <td>{{ $boat->name }}</td>
                        <td>{{ $boat->mmsi }}</td>
                        <td>{{ $boat->sail_number }}</td>
                        <td>{{ $boat->pivot->started_at != null ? $boat->pivot->started_at->format('Y-m-d H:i:s') : '-' }}</td>
                        <td>{{ $boat->pivot->finished_at != null ? $boat->pivot->finished_at->format('Y-m-d H:i:s') : '-' }}</td>
                        <td><a href="{{ route('admin.events.classes.fleets.boats.edit', [$event, $boat->pivot->event_class_id, $boat->pivot->event_class_fleet_id, $boat]) }}">@lang('admin/events.timer.edit_button')</a>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        window.data = {
            csrfToken: @json(csrf_token()),
            apiKey: @json(App\Models\ApiKey::where('name', 'Website')->first()->key),
            apiToken: @json(Auth::user()->apiToken()),
            event: @json($event),
            eventClassFleetBoats: @json($eventClassFleetBoats),
            links: {
                apiEventClassFleetBoatsUpdate: @json(rawRoute('api.events.classes.fleets.boats.update'))
            },
            strings: {
                started_at: @json(__('admin/events.timer.started_at')),
                finished_at: @json(__('admin/events.timer.finished_at'))
            }
        };
    </script>
    <script src="/js/event_timer_page.js"></script>
@endsection
