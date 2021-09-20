@extends('layout')

@section('title', __('admin/users.create_complete.title'))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.users.index') }}">@lang('admin/users.index.breadcrumb')</a></li>
            <li class="is-active"><a href="{{ route('admin.users.create') }}">@lang('admin/users.create_complete.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/users.create_complete.header')</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.users.store_complete') }}">
        @csrf

        <div class="box">
            <h2 class="title is-5">@lang('admin/users.create_complete.user_info')</h2>

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
                            <input class="input @error('insertion') is-danger @enderror" type="text" id="insertion" name="insertion" value="{{ old('insertion') }}">
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

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label" for="gender">@lang('admin/users.create.gender')</label>

                        <div class="control">
                            <div class="select is-fullwidth @error('gender') is-danger @enderror">
                                <select id="gender" name="gender" required>
                                    <option value="{{ App\Models\User::GENDER_MALE }}" @if (App\Models\User::GENDER_MALE == old('gender', App\Models\User::GENDER_MALE)) selected @endif>
                                        @lang('admin/users.create.gender_male')
                                    </option>

                                    <option value="{{ App\Models\User::GENDER_FEMALE }}" @if (App\Models\User::GENDER_FEMALE == old('gender', App\Models\User::GENDER_MALE)) selected @endif>
                                        @lang('admin/users.create.gender_female')
                                    </option>

                                    <option value="{{ App\Models\User::GENDER_OTHER }}" @if (App\Models\User::GENDER_OTHER == old('gender', App\Models\User::GENDER_MALE)) selected @endif>
                                        @lang('admin/users.create.gender_other')
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
                        <label class="label" for="birthday">@lang('admin/users.create.birthday')</label>

                        <div class="control">
                            <input class="input @error('birthday') is-danger @enderror" type="date" id="birthday" name="birthday" value="{{ old('birthday') }}" required>
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
                        <label class="label" for="email">@lang('admin/users.create.email')</label>

                        <div class="control">
                            <input class="input @error('email') is-danger @enderror" type="email" id="email" name="email" value="{{ old('email') }}" required>
                        </div>

                        @error('email')
                            <p class="help is-danger">{{ $errors->first('email') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="phone">@lang('admin/users.create.phone')</label>

                        <div class="control">
                            <input class="input @error('phone') is-danger @enderror" type="tel" id="phone" name="phone" value="{{ old('phone') }}">
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
                        <label class="label" for="address">@lang('admin/users.create.address')</label>

                        <div class="control">
                            <input class="input @error('address') is-danger @enderror" type="text" id="address" name="address" value="{{ old('address') }}" required>
                        </div>

                        @error('address')
                            <p class="help is-danger">{{ $errors->first('address') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="postcode">@lang('admin/users.create.postcode')</label>

                        <div class="control">
                            <input class="input @error('postcode') is-danger @enderror" type="text" id="postcode" name="postcode" value="{{ old('postcode') }}" required>
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
                        <label class="label" for="city">@lang('admin/users.create.city')</label>

                        <div class="control">
                            <input class="input @error('city') is-danger @enderror" type="text" id="city" name="city" value="{{ old('city') }}" required>
                        </div>

                        @error('city')
                            <p class="help is-danger">{{ $errors->first('city') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="country">@lang('admin/users.create.country')</label>

                        <div class="control">
                            <div class="select is-fullwidth @error('country') is-danger @enderror">
                                <select id="country" name="country" required>
                                    @foreach (\App\Models\User::COUNTRIES as $country)
                                        <option {{ $country == old('country', 'Netherlands') ? 'selected' : '' }} value="{{ $country }}">{{ $country }}</option>
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
        </div>

        <div class="box">
            <h2 class="title is-5">@lang('admin/users.create_complete.boat_info')</h2>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label" for="name">@lang('admin/boats.create.name')</label>

                        <div class="control">
                            <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name') }}" required>
                        </div>

                        @error('name')
                            <p class="help is-danger">{{ $errors->first('name') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="website">@lang('admin/users.create_complete.website')</label>

                        <div class="control">
                            <input class="input @error('website') is-danger @enderror" type="text" id="website" name="website" value="{{ old('website') }}" required>
                        </div>

                        @error('website')
                            <p class="help is-danger">{{ $errors->first('website') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="boat_type">@lang('admin/users.create_complete.boat_type')</label>

                        <div class="control">
                            <input class="input @error('boat_type') is-danger @enderror" type="text" id="boat_type" name="boat_type" value="{{ old('boat_type') }}" required>
                        </div>

                        @error('boat_type')
                            <p class="help is-danger">{{ $errors->first('boat_type') }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label" for="mmsi">@lang('admin/boats.create.mmsi')</label>

                        <div class="control">
                            <input class="input @error('mmsi') is-danger @enderror" type="number" id="mmsi" name="mmsi" value="{{ old('mmsi') }}" required>
                        </div>

                        @error('mmsi')
                            <p class="help is-danger">{{ $errors->first('mmsi') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="length">@lang('admin/boats.create.length')</label>

                        <div class="control">
                            <input class="input @error('length') is-danger @enderror" type="number" step="0.01" id="length" name="length" value="{{ old('length') }}" required>
                        </div>

                        @error('length')
                            <p class="help is-danger">{{ $errors->first('length') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="breadth">@lang('admin/boats.create.breadth')</label>

                        <div class="control">
                            <input class="input @error('breadth') is-danger @enderror" type="number" step="0.01" id="breadth" name="breadth" value="{{ old('breadth') }}" required>
                        </div>

                        @error('breadth')
                            <p class="help is-danger">{{ $errors->first('breadth') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="weight">@lang('admin/users.create_complete.weight')</label>

                        <div class="control">
                            <input class="input @error('weight') is-danger @enderror" type="number" step="0.01" id="weight" name="weight" value="{{ old('weight') }}" required>
                        </div>

                        @error('weight')
                            <p class="help is-danger">{{ $errors->first('weight') }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label" for="sail_number">@lang('admin/boats.create.sail_number')</label>

                        <div class="control">
                            <input class="input @error('sail_number') is-danger @enderror" type="text" id="sail_number" name="sail_number" value="{{ old('sail_number') }}" required>
                        </div>

                        @error('sail_number')
                            <p class="help is-danger">{{ $errors->first('sail_number') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column">
                    <div class="field">
                        <label class="label" for="sail_area">@lang('admin/boats.create.sail_area')</label>

                        <div class="control">
                            <input class="input @error('sail_area') is-danger @enderror" type="number" step="0.01" id="sail_area" name="sail_area" value="{{ old('sail_area') }}" required>
                        </div>

                        @error('sail_area')
                            <p class="help is-danger">{{ $errors->first('sail_area') }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/users.create_complete.create_button')</button>
            </div>
        </div>
    </form>
@endsection
