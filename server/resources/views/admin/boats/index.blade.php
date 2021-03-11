@extends('layout')

@section('title', __('admin/boats.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.boats.index') }}">@lang('admin/boats.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/boats.index.header')</h1>

        @if (count($boats) > 0)
            {{ $boats->links() }}

            @foreach ($boats as $boat)
                <div class="box">
                    <h2 class="title"><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></h2>
                    @if ($boat->description != null)
                        <p>{{ Str::limit($boat->description, 64) }}</a></p>
                    @endif
                    <p>@lang('admin/boats.index.owner') <a href="{{ route('admin.users.show', $boat->user) }}">{{ $boat->user->firstname }} {{ $boat->user->lastname }}</a></p>
                </div>
            @endforeach

            {{ $boats->links() }}
        @else
            <p><i>@lang('admin/boats.index.empty')</i></p>
        @endif
    </div>

    <div class="buttons">
        <a class="button is-link" href="{{ route('admin.boats.create') }}">@lang('admin/boats.index.create')</a>
    </div>
@endsection
