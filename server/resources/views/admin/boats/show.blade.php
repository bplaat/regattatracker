@extends('layout')

@section('title', __('admin/boats.show.title', [ 'boat.name' => $boat->name ]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.index') }}">@lang('admin/boats.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></li>
        </ul>
    </div>

    <div class="content">
        <h2 class="title"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></h2>
        <p>@lang('admin/boats.show.owner') <a href="{{ route('admin.users.show', $boat->user) }}">{{ $boat->user->firstname }} {{ $boat->user->lastname }}</a></p>

        @if ($boat->description != null)
            <p style="white-space: pre-wrap;">{{ $boat->description }}</a></p>
        @else
            <p><i>@lang('admin/boats.show.description_empty')</i></p>
        @endif

        <div class="buttons">
            <a class="button is-link" href="{{ route('admin.boats.edit', $boat) }}">@lang('admin/boats.show.edit')</a>
            <a class="button is-danger" href="{{ route('admin.boats.delete', $boat) }}">@lang('admin/boats.show.delete')</a>
        </div>
    </div>

    <div class="content">
        <h3 class="subtitle">@lang('admin/boats.show.boat_types')</h3>
        @if (count($boat->boatTypes) > 0)
            <ul class="list">
                @foreach ($boat->boatTypes as $boatType)
                    <li>
                        @if ($boatType->description != null)
                            <a href="{{ route('admin.boat_types.show', $boatType) }}"><b>{{ $boatType->name }}</b></a>: {{ Str::limit($boatType->description, 64) }}
                        @else
                            <a href="{{ route('admin.boat_types.show', $boatType) }}"><b>{{ $boatType->name }}</b></a>
                        @endif
                        <a href="{{ route('admin.boats.boat_types.delete', [ $boat, $boatType ]) }}">@lang('admin/boats.show.boat_types_remove_button')</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p><i>@lang('admin/boats.show.boat_types_empty')</i></p>
        @endif

        @if (count($boat->boatTypes) != count($boatTypes))
            <form method="POST" action="{{ route('admin.boats.boat_types.create', $boat) }}">
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
                        <button class="button is-link" type="submit">@lang('admin/boats.show.boat_types_add_button')</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection
