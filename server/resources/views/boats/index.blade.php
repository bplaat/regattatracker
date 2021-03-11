@extends('layout')

@section('title', __('boats.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li class="is-active"><a href="{{ route('boats.index') }}">@lang('boats.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('boats.index.header')</h1>

        <div class="columns">
            <div class="column">
                <div class="buttons">
                    <a class="button is-link" href="{{ route('boats.create') }}">@lang('boats.index.create')</a>
                </div>
            </div>

            <form class="column" method="GET">
                <div class="field has-addons">
                    <div class="control" style="width: 100%;">
                        <input class="input" type="text" id="q" name="q" placeholder="@lang('boats.index.search_field')" value="{{ request('q') }}">
                    </div>
                    <div class="control">
                        <button class="button is-link" type="submit">@lang('boats.index.search_button')</button>
                    </div>
                </div>
            </form>
        </div>

        @if (count($boats) > 0)
            {{ $boats->links() }}

            @foreach ($boats as $boat)
                <div class="box">
                    <h2 class="title is-4"><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></h2>
                    @if ($boat->description != null)
                        <p>{{ Str::limit($boat->description, 64) }}</a></p>
                    @endif
                </div>
            @endforeach

            {{ $boats->links() }}
        @else
            <p><i>@lang('boats.index.empty')</i></p>
        @endif
    </div>
@endsection
