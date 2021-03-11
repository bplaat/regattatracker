@extends('layout')

@section('title', __('boats.show.title', [ 'boat.name' => $boat->name ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('boats.index') }}">@lang('boats.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></li>
        </ul>
    </div>

    <div class="box content">
        <h1 class="title is-4">{{ $boat->name }}</h1>
        @if ($boat->description != null)
            <p style="white-space: pre-wrap;">{{ $boat->description }}</a></p>
        @else
            <p><i>@lang('boats.show.description_empty')</i></p>
        @endif

        <div class="buttons">
            <a class="button is-link" href="{{ route('boats.edit', $boat) }}">@lang('boats.show.edit')</a>
            <a class="button is-danger" href="{{ route('boats.delete', $boat) }}">@lang('boats.show.delete')</a>
        </div>
    </div>

    <div class="box content">
        <h2 class="title is-4">@lang('boats.show.boat_types')</h2>

        @if (count($boat->boatTypes) > 0)
            <ul>
                @foreach ($boat->boatTypes as $boatType)
                    <li>
                        @if ($boatType->description != null)
                            <b>{{ $boatType->name }}</b>: {{ Str::limit($boatType->description, 64) }}
                        @else
                            <b>{{ $boatType->name }}</b>
                        @endif
                        <a href="{{ route('boats.boat_types.delete', [ $boat, $boatType ]) }}">@lang('boats.show.boat_types_remove_button')</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p><i>@lang('boats.show.boat_types_empty')</i></p>
        @endif

        @if (count($boat->boatTypes) != count($boatTypes))
            <form method="POST" action="{{ route('boats.boat_types.create', $boat) }}">
                @csrf

                <div class="field has-addons">
                    <div class="control">
                        <div class="select @error('boat_type_id') is-danger @enderror">
                            <select id="boat_type_id" name="boat_type_id" required>
                                @foreach ($boatTypes as $boatType)
                                    @if (!in_array($boatType->name, $boat->boatTypes->pluck('name')->toArray()))
                                        <option value="{{ $boatType->id }}">{{ $boatType->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="control">
                        <button class="button is-link" type="submit">@lang('boats.show.boat_types_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
