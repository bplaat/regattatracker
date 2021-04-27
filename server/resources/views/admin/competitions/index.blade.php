@extends('layout')

@section('title', __('admin/competitions.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.competitions.index') }}">@lang('admin/competitions.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/competitions.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.competitions.create') }}">@lang('admin/competitions.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/competitions.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/competitions.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($competitions->count() > 0)
            {{ $competitions->links() }}

            <div class="columns is-multiline">
                @foreach ($competitions as $competition)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('admin.competitions.show', $competition) }}">{{ $competition->name }}</a>
                            </h2>

                            @if ($competition->start != null)
                                <p>@lang('admin/competitions.index.start'): {{ $competition->start }}</p>
                            @else
                                <p><i>@lang('admin/competitions.index.start_empty')</i></p>
                            @endif

                            @if ($competition->end != null)
                                <p>@lang('admin/competitions.index.end'): {{ $competition->end }}</p>
                            @else
                                <p><i>@lang('admin/competitions.index.end_empty')</i></p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $competitions->links() }}
        @else
            <p><i>@lang('admin/competitions.index.empty')</i></p>
        @endif
    </div>
@endsection
