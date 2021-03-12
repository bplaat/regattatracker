@extends('layout')

@section('title', __('auth.register.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li class="is-active"><a href="{{ route('auth.register') }}">@lang('auth.register.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('auth.register.header')</h1>

    <form method="POST">
        @csrf

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="firstname">@lang('auth.register.firstname')</label>

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
                    <label class="label" for="insertion">@lang('auth.register.insertion')</label><div class="control">
                        <input class="input @error('insertion') is-danger @enderror" type="text" id="insertion" name="insertion" value="{{ old('insertion') }}"></div>@error('insertion')<p class="help is-danger">{{ $errors->first('insertion') }}</p>@enderror</div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="lastname">@lang('auth.register.lastname')</label>

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
            <label class="label" for="gender">@lang('auth.register.gender')</label>

            <div class="control">
                <select class="input @error('gender') is-danger @enderror" type="value" id="gender" name="gender" required>
                    @for($i = 0; $i < count($genders); $i++)
                        <option {{(strcmp(old('gender'), $i) === 0) ? 'selected' : ''}} value={{$i}}>{{$genders[$i]}}</option>
                    @endfor
                </select>
            </div>

            @error('gender')
            <p class="help is-danger">{{ $errors->first('gender') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="birthday">@lang('auth.register.birthday')</label>

            <div class="control">
                <input class="input @error('birthday') is-danger @enderror" type="date" id="birthday" name="birthday" value="{{ old('birthday') }}" placeholder="DD-MM-YYYY" required>
            </div>

            @error('birthday')
            <p class="help is-danger">{{ $errors->first('birthday') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="country">@lang('auth.register.country')</label>

            <div class="control">
                <select class="input @error('country') is-danger @enderror" type="text" id="country" name="country" required>
                    @foreach($countries as $country)
                        <option {{(strcmp(old('country'), $country) === 0) ? 'selected' : ''}} value="{{$country}}">{{$country}}</option>
                    @endforeach
                </select>
            </div>

            @error('country')
            <p class="help is-danger">{{ $errors->first('country') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="city">@lang('auth.register.city')</label>

            <div class="control">
                <input class="input @error('city') is-danger @enderror" type="text" id="city" name="city" value="{{ old('city') }}" required>
            </div>

            @error('city')
            <p class="help is-danger">{{ $errors->first('city') }}</p>
            @enderror
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="street">@lang('auth.register.street')</label>

                    <div class="control">
                        <input class="input @error('street') is-danger @enderror" type="text" id="street" name="street"
                               value="{{ old('street') }}" required>
                    </div>

                    @error('street')
                    <p class="help is-danger">{{ $errors->first('street') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="zipcode">@lang('auth.register.zipcode')</label>

                    <div class="control">
                        <input class="input @error('zipcode') is-danger @enderror" type="text" id="zipcode"
                               name="zipcode" value="{{ old('zipcode') }}" required>
                    </div>

                    @error('zipcode')
                    <p class="help is-danger">{{ $errors->first('zipcode') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label" for="phone">@lang('auth.register.phone')</label>

            <div class="control">
                <input class="input @error('phone') is-danger @enderror" type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
            </div>

            @error('phone')
            <p class="help is-danger">{{ $errors->first('phone') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="email">@lang('auth.register.email')</label>

            <div class="control">
                <input class="input @error('email') is-danger @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            @error('email')
                <p class="help is-danger">{{ $errors->first('email') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password">@lang('auth.register.password')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password" name="password" required>
            </div>

            @error('password')
                <p class="help is-danger">{{ $errors->first('password') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password_confirmation">@lang('auth.register.password_confirmation')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('auth.register.button')</button>
            </div>
        </div>
    </form>
@endsection
