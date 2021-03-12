@extends('layout')

@section('title', __('admin/users.create.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.users.index') }}">@lang('admin/users.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.users.create') }}">@lang('admin/users.create.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/users.create.header')</h1>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="firstname">@lang('admin/users.create.firstname')</label>

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
                    <label class="label" for="insertion">@lang('admin/users.create.insertion')</label>

                    <div class="control">
                        <input class="input @error('insertion') is-danger @enderror" type="text" id="insertion" name="insertion" value="{{ old('insertion') }}" autofocus required>
                    </div>

                    @error('insertion')
                    <p class="help is-danger">{{ $errors->first('insertion') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="lastname">@lang('admin/users.create.lastname')</label>

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
            <label class="label" for="gender">@lang('admin/users.create.gender')</label>

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
            <label class="label" for="birthday">@lang('admin/users.create.birthday')</label>

            <div class="control">
                <input class="input @error('birthday') is-danger @enderror" type="date" id="birthday" name="birthday" value="{{ old('birthday') }}" placeholder="DD-MM-YYYY" required>
            </div>

            @error('birthday')
            <p class="help is-danger">{{ $errors->first('birthday') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="country">@lang('admin/users.create.country')</label>

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
            <label class="label" for="city">@lang('admin/users.create.city')</label>

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
                    <label class="label" for="street">@lang('admin/users.create.street')</label>

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
                    <label class="label" for="zipcode">@lang('admin/users.create.zipcode')</label>

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
            <label class="label" for="phone">@lang('admin/users.create.phone')</label>

            <div class="control">
                <input class="input @error('phone') is-danger @enderror" type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
            </div>

            @error('phone')
            <p class="help is-danger">{{ $errors->first('phone') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="email">@lang('admin/users.create.email')</label>

            <div class="control">
                <input class="input @error('email') is-danger @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            @error('email')
                <p class="help is-danger">{{ $errors->first('email') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password">@lang('admin/users.create.password')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password" name="password" required>
            </div>

            @error('password')
                <p class="help is-danger">{{ $errors->first('password') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="password_confirmation">@lang('admin/users.create.password_confirmation')</label>

            <div class="control">
                <input class="input @error('password') is-danger @enderror" type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
        </div>

        <div class="field">
            <label class="label" for="role">@lang('admin/users.create.role')</label>

            <div class="control">
                <div class="select @error('role') is-danger @enderror">
                    <select id="role" name="role" required>
                        <option value="{{ App\Models\User::ROLE_NORMAL }}" @if (App\Models\User::ROLE_NORMAL == old('role', App\Models\User::ROLE_NORMAL)) selected @endif>
                            @lang('admin/users.create.role_normal')
                        </option>

                        <option value="{{ App\Models\User::ROLE_ADMIN }}" @if (App\Models\User::ROLE_ADMIN == old('role', App\Models\User::ROLE_NORMAL)) selected @endif>
                            @lang('admin/users.create.role_admin')
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/users.create.button')</button>
            </div>
        </div>
    </form>
@endsection
