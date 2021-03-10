@extends('layout')

@section('title', __('settings.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li class="is-active"><a href="{{ route('settings') }}">@lang('settings.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('settings.title')</h1>

    @if (session('message'))
        <div class="notification is-success">
            <button class="delete"></button>
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <!-- Change details form -->
    <form class="box" method="POST" action="{{ route('settings.change_details') }}">
        @csrf

        <h2 class="title is-4">@lang('settings.change_details_title')</h2>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="firstname">@lang('settings.firstname')</label>

                    <div class="control">
                        <input class="input @error('firstname') is-danger @enderror" type="text" id="firstname" name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}" autofocus required>
                    </div>

                    @error('firstname')
                        <p class="help is-danger">{{ $errors->first('firstname') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="lastname">@lang('settings.lastname')</label>

                    <div class="control">
                        <input class="input @error('lastname') is-danger @enderror" type="text" id="lastname" name="lastname" value="{{ old('lastname', Auth::user()->lastname) }}" required>
                    </div>

                    @error('lastname')
                        <p class="help is-danger">{{ $errors->first('lastname') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="email">@lang('settings.email')</label>

            <div class="control">
                <input class="input @error('email') is-danger @enderror" type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
            </div>

            @error('email')
                <p class="help is-danger">{{ $errors->first('email') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('settings.change_details_button')</button>
            </div>
        </div>
    </form>

    <!-- Change password form -->
    <form class="box" method="POST" action="{{ route('settings.change_password') }}">
        @csrf

        <h2 class="title is-4">@lang('settings.change_password_title')</h2>

        <div class="field">
            <label class="label" for="current_password">@lang('settings.current_password')</label>

            <div class="control">
                <input class="input @error('current_password') is-danger @enderror" type="password" id="current_password" name="current_password" required>
            </div>

            @error('current_password')
                <p class="help is-danger">{{ $errors->first('current_password') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password">@lang('settings.password')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password" name="password" required>
            </div>

            @error('password')
                <p class="help is-danger">{{ $errors->first('password') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password_confirmation">@lang('settings.password_confirmation')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('settings.change_password_button')</button>
            </div>
        </div>
    </form>
@endsection
