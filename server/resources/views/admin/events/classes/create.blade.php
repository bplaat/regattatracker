@extends('layout')

@section('title', __('admin/events.classes.create.title', ['event.name' => $event->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="#">@lang('admin/events.classes.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.events.classes.create', $event) }}">@lang('admin/events.classes.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/events.classes.create.header')</h1>

    <form method="POST" action="{{ route('admin.events.classes.store', $event) }}">
        @csrf

        <div class="field">
            <label class="label" for="flag">@lang('admin/events.classes.create.flag')</label>

            <div id="flag-container" class="box" style="display: none; background-color: #ccc;">
                <img id="flag-image" style="height: 100px">
            </div>

            <div class="control">
                <div class="select is-fullwidth">
                    <select id="flag" name="flag">
                        <option value="-" {{ '-' == old('flag', '-') ? 'selected' : '' }}>@lang('admin/events.classes.create.flag.none')</option>
                        {{$letter = 'A'}}
                        @for ($i=0; $i < 26; $i++)
                            <option value="{{ $letter }}" {{ $letter == old('flag', '-') ? 'selected' : '' }}>{{ $letter }}</option>
                            {{$letter++}}
                        @endfor
                    </select>
                </div>
            </div>

            <script>
            const flagContainer = document.getElementById("flag-container");
            const flagImage = document.getElementById("flag-image");
            const flagInput = document.getElementById("flag");
            flagInput.addEventListener('change', () => {
                if (flagInput.value != '-') {
                    flagContainer.style.display = 'inline-block';
                    flagImage.src = '/images/flags/' + flagInput.value + '.svg';
                    flagImage.alt = flagInput.value + ' flag';
                } else {
                    flagContainer.style.display = 'none';
                }
            });
            </script>
        </div>

        <div class="field">
            <label class="label" for="name">@lang('admin/events.classes.create.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name"
                       name="name" value="{{ old('name') }}" required>
            </div>

            @error('name')
            <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/events.classes.create.create_button')</button>
            </div>
        </div>
    </form>
@endsection
