@extends('layout')

@section('title', __('boats.guest.edit.title', ['boat.name' => $boat->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('boats.index') }}">@lang('boats.index.breadcrumb')</a></li>
            <li><a href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a></li>
            <li><a href="#">{{ $boatGuest->name }}</a></li>
            <li class="is-active"><a href="{{ route('boats.guests.edit', [$boat, $boatGuest]) }}">@lang('boats.guests.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('boats.guests.edit.header')</h1>

    <form method="POST" action="{{ route('boats.guests.update', [$boat, $boatGuest]) }}">
        @csrf


        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="firstname">@lang('boats.guests.edit.firstname')</label>

                    <div class="control">
                        <input class="input @error('firstname') is-danger @enderror" type="text" id="firstname" name="firstname" value="{{ old('firstname', $boatGuest->firstname) }}" autofocus required>
                    </div>

                    @error('firstname')
                        <p class="help is-danger">{{ $errors->first('firstname') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="insertion">@lang('boats.guests.edit.insertion')</label>

                    <div class="control">
                        <input class="input @error('insertion') is-danger @enderror" type="text" id="insertion" name="insertion" value="{{ old('insertion', $boatGuest->insertion) }}">
                    </div>

                    @error('insertion')
                        <p class="help is-danger">{{ $errors->first('insertion') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="lastname">@lang('boats.guests.edit.lastname')</label>

                    <div class="control">
                        <input class="input @error('lastname') is-danger @enderror" type="text" id="lastname" name="lastname" value="{{ old('lastname', $boatGuest->lastname) }}" required>
                    </div>

                    @error('lastname')
                        <p class="help is-danger">{{ $errors->first('lastname') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="gender">@lang('boats.guests.edit.gender')</label>

                    <div class="control">
                        <div class="select is-fullwidth @error('gender') is-danger @enderror">
                            <select id="gender" name="gender">
                                <option value="{{ App\Models\User::GENDER_MALE }}" @if (App\Models\User::GENDER_MALE == old('gender', $boatGuest->gender)) selected @endif>
                                    @lang('boats.guests.edit.gender_male')
                                </option>

                                <option value="{{ App\Models\User::GENDER_FEMALE }}" @if (App\Models\User::GENDER_FEMALE == old('gender', $boatGuest->gender)) selected @endif>
                                    @lang('boats.guests.edit.gender_female')
                                </option>

                                <option value="{{ App\Models\User::GENDER_OTHER }}" @if (App\Models\User::GENDER_OTHER == old('gender', $boatGuest->gender)) selected @endif>
                                    @lang('boats.guests.edit.gender_other')
                                </option>
                            </select>
                        </div>
                    </div>

                    @error('gender')
                        <p class="help is-danger">{{ $errors->first('gender') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="birthday">@lang('boats.guests.edit.birthday')</label>

                    <div class="control">
                        <input class="input @error('birthday') is-danger @enderror" type="date" id="birthday" name="birthday" value="{{ old('birthday', $boatGuest->birthday != '' ? $boatGuest->birthday->format('Y-m-d') : '') }}">
                    </div>

                    @error('birthday')
                        <p class="help is-danger">{{ $errors->first('birthday') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="email">@lang('boats.guests.edit.email')</label>

                    <div class="control">
                        <input class="input @error('email') is-danger @enderror" type="email" id="email" name="email" value="{{ old('email', $boatGuest->email) }}">
                    </div>

                    @error('email')
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="phone">@lang('boats.guests.edit.phone')</label>

                    <div class="control">
                        <input class="input @error('phone') is-danger @enderror" type="tel" id="phone" name="phone" value="{{ old('phone', $boatGuest->phone) }}">
                    </div>

                    @error('phone')
                        <p class="help is-danger">{{ $errors->first('phone') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="address">@lang('boats.guests.edit.address')</label>

                    <div class="control">
                        <input class="input @error('address') is-danger @enderror" type="text" id="address" name="address" value="{{ old('address', $boatGuest->address) }}">
                    </div>

                    @error('address')
                        <p class="help is-danger">{{ $errors->first('address') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="postcode">@lang('boats.guests.edit.postcode')</label>

                    <div class="control">
                        <input class="input @error('postcode') is-danger @enderror" type="text" id="postcode" name="postcode" value="{{ old('postcode', $boatGuest->postcode) }}">
                    </div>

                    @error('postcode')
                        <p class="help is-danger">{{ $errors->first('postcode') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="city">@lang('boats.guests.edit.city')</label>

                    <div class="control">
                        <input class="input @error('city') is-danger @enderror" type="text" id="city" name="city" value="{{ old('city', $boatGuest->city) }}">
                    </div>

                    @error('city')
                        <p class="help is-danger">{{ $errors->first('city') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="country">@lang('boats.guests.edit.country')</label>

                    <div class="control">
                        <div class="select is-fullwidth @error('country') is-danger @enderror">
                            <select id="country" name="country">
                                @foreach (\App\Models\User::COUNTRIES as $country)
                                    <option {{ $country == old('country', $boatGuest->country) ? 'selected' : '' }} value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @error('country')
                        <p class="help is-danger">{{ $errors->first('country') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('boats.guests.edit.create_button')</button>
            </div>
        </div>
    </form>
@endsection
