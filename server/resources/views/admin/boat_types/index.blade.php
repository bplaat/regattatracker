@extends('layout')

@section('title', __('admin/boat_types.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.boat_types.index') }}">@lang('admin/boat_types.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/boat_types.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('admin.boat_types.create') }}">@lang('admin/boat_types.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('admin/boat_types.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('admin/boat_types.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if ($boatTypes->count() > 0)
            {{ $boatTypes->links() }}

            @foreach ($boatTypes as $boatType)
                <div class="box">
                    <h2 class="title"><a href="{{ route('admin.boat_types.show', $boatType) }}">{{ $boatType->name }}</a></h2>
                    @if ($boatType->description != null)
                        <p>{{ Str::limit($boatType->description, 64) }}</p>
                    @endif
                </div>
            @endforeach

            {{ $boatTypes->links() }}
        @else
            <p><i>@lang('admin/boat_types.index.empty')</i></p>
        @endif
    </div>
@endsection
