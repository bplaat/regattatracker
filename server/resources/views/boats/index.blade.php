@extends('layout')

@section('title', __('boats.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">RegattaTracker</a></li>
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

        @if ($boats->count() > 0)
            {{ $boats->links() }}

            <div class="columns is-multiline">
                @foreach ($boats as $boat)
                    <div class="column is-one-third">
                        <div class="box content" style="height: 100%">
                            <h2 class="title is-4">
                                <a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a>

                                @if ($boat->pivot->role == App\Models\BoatUser::ROLE_CREW)
                                    <span class="tag is-pulled-right is-success">@lang('boats.index.role_crew')</span>
                                @endif

                                @if ($boat->pivot->role == App\Models\BoatUser::ROLE_CAPTAIN)
                                    <span class="tag is-pulled-right is-info">@lang('boats.index.role_captain')</span>
                                @endif
                            </h2>

                            @if ($boat->description != null)
                                <p>{{ Str::limit($boat->description, 64) }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $boats->links() }}
        @else
            <p><i>@lang('boats.index.empty')</i></p>
        @endif
    </div>
@endsection
