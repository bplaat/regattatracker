@extends('layout')

@section('title', __('admin/buoys.index.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.buoys.index') }}">@lang('admin/buoys.index.breadcrumb')</a></li>
        </ul>
    </div>

    <div class="content">
        <h1 class="title">@lang('admin/buoys.index.header')</h1>

        @if (count($buoys) > 0)
            {{ $buoys->links() }}

            @foreach ($buoys as $buoy)
                <div class="box">
                    <h2 class="title"><a href="{{ route('admin.buoys.show', $buoy) }}">{{ $buoy->name }}</a></h2>
                    @if ($buoy->description != null)
                        <p>{{ Str::limit($buoy->description, 64) }}</a></p>
                    @endif
                </div>
            @endforeach

            {{ $buoys->links() }}
        @else
            <p><i>@lang('admin/buoys.index.empty')</i></p>
        @endif
    </div>

    <div class="buttons">
        <a class="button is-link" href="{{ route('admin.buoys.create') }}">@lang('admin/buoys.index.create')</a>
    </div>
@endsection
