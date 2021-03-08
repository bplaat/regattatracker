@extends('layout')

@section('title', __('auth/register.title'))

@section('content')
    <h1 class="title">@lang('auth/register.title')</h1>

    <form method="POST">
        @csrf

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="firstname">@lang('auth/register.firstname')</label>

                    <div class="control">
                        <input class="input @error('firstname') is-danger @enderror" type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" autofocus required>
                    </div>

                    @error('firstname')
                        <p class="help is-danger">{{ $errors->first('firstname') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="lastname">@lang('auth/register.lastname')</label>

                    <div class="control">
                        <input class="input @error('lastname') is-danger @enderror" type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" required>
                    </div>

                    @error('lastname')
                        <p class="help is-danger">{{ $errors->first('lastname') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="email">@lang('auth/register.email')</label>

            <div class="control">
                <input class="input @error('email') is-danger @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            @error('email')
                <p class="help is-danger">{{ $errors->first('email') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password">@lang('auth/register.password')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password" name="password" required>
            </div>

            @error('password')
                <p class="help is-danger">{{ $errors->first('password') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password_confirmation">@lang('auth/register.password_confirmation')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('auth/register.button')</button>
            </div>
        </div>
    </form>
@endsection
