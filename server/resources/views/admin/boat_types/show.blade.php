@extends('layout')

@section('title', __('admin/boat_types.show.title', ['boat_type.name' => $boatType->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boat_types.index') }}">@lang('admin/boat_types.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.boat_types.show', $boatType) }}">{{ $boatType->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-4">{{ $boatType->name }}</h1>
        @if ($boatType->description != null)
            <p style="white-space: pre-wrap;">{{ $boatType->description }}</p>
        @endif

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.boat_types.edit', $boatType) }}">@lang('admin/boat_types.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.boat_types.delete', $boatType) }}">@lang('admin/boat_types.show.delete')</a>
        </div>
    </div>

    <div class="box content">
        <h2 class="title is-4">@lang('admin/boat_types.show.boats_title')</h2>

        @if ($boats->count() > 0)
            {{ $boats->links() }}

            <div class="columns is-multiline">
                @foreach ($boats as $boat)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h3 class="title is-4"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></h3>
                            @if ($boat->description != null)
                                <p>{{ Str::limit($boat->description, 64) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boats->links() }}
        @else
            <p><i>@lang('admin/boat_types.show.boats_empty')</i></p>
        @endif
    </div>
@endsection
