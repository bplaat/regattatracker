@extends('layout')

@section('title', __('admin/events.classes.fleets.boats.guests.edit.title', ['event.name' => $event->name, 'event_class.name' => $eventClass->name, 'event_class_fleet.name' => $eventClassFleet->name, 'boat.name' => $boat->name, 'event_class_fleet_boat_guest.name' => $eventClassFleetBoatGuest->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.index') }}">@lang('admin/events.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.events.show', $event) }}">{{ $event->name }}</a></li>
            <li><a href="#">@lang('admin/events.classes.index.breadcrumb')</a></li>
            <li><a href="#">{{ $eventClass->name }}</a></li>
            <li><a href="#">@lang('admin/events.classes.fleets.index.breadcrumb')</a></li>
            <li><a href="#">{{ $eventClassFleet->name }}</a></li>
            <li><a href="{{ route('admin.events.classes.fleets.boats.index', [$event, $eventClass, $eventClassFleet]) }}">@lang('admin/events.classes.fleets.boats.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></li>
            <li><a href="{{ route('admin.events.classes.fleets.boats.users.index', [$event, $eventClass, $eventClassFleet, $boat]) }}">@lang('admin/events.classes.fleets.boats.guests.index.breadcrumb')</a></li>
            <li><a href="#">{{ $eventClassFleetBoatGuest->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.events.classes.fleets.boats.guests.edit', [$event, $eventClass, $eventClassFleet, $boat, $eventClassFleetBoatGuest]) }}">@lang('admin/events.classes.fleets.boats.guests.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/events.classes.fleets.boats.guests.edit.header')</h1>

    <form method="POST" action="{{ route('admin.events.classes.fleets.boats.guests.update', [$event, $eventClass, $eventClassFleet, $boat, $eventClassFleetBoatGuest]) }}">
        @csrf

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="firstname">@lang('admin/events.classes.fleets.boats.guests.edit.firstname')</label>

                    <div class="control">
                        <input class="input @error('firstname') is-danger @enderror" type="text" id="firstname" name="firstname" value="{{ old('firstname', $eventClassFleetBoatGuest->firstname) }}" autofocus required>
                    </div>

                    @error('firstname')
                        <p class="help is-danger">{{ $errors->first('firstname') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="insertion">@lang('admin/events.classes.fleets.boats.guests.edit.insertion')</label>

                    <div class="control">
                        <input class="input @error('insertion') is-danger @enderror" type="text" id="insertion" name="insertion" value="{{ old('insertion', $eventClassFleetBoatGuest->insertion) }}">
                    </div>

                    @error('insertion')
                        <p class="help is-danger">{{ $errors->first('insertion') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="lastname">@lang('admin/events.classes.fleets.boats.guests.edit.lastname')</label>

                    <div class="control">
                        <input class="input @error('lastname') is-danger @enderror" type="text" id="lastname" name="lastname" value="{{ old('lastname', $eventClassFleetBoatGuest->lastname) }}" required>
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
                    <label class="label" for="gender">@lang('admin/events.classes.fleets.boats.guests.edit.gender')</label>

                    <div class="control">
                        <div class="select is-fullwidth @error('gender') is-danger @enderror">
                            <select id="gender" name="gender">
                                <option value="{{ App\Models\User::GENDER_MALE }}" @if (App\Models\User::GENDER_MALE == old('gender', $eventClassFleetBoatGuest->gender)) selected @endif>
                                    @lang('admin/events.classes.fleets.boats.guests.edit.gender_male')
                                </option>

                                <option value="{{ App\Models\User::GENDER_FEMALE }}" @if (App\Models\User::GENDER_FEMALE == old('gender', $eventClassFleetBoatGuest->gender)) selected @endif>
                                    @lang('admin/events.classes.fleets.boats.guests.edit.gender_female')
                                </option>

                                <option value="{{ App\Models\User::GENDER_OTHER }}" @if (App\Models\User::GENDER_OTHER == old('gender', $eventClassFleetBoatGuest->gender)) selected @endif>
                                    @lang('admin/events.classes.fleets.boats.guests.edit.gender_other')
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
                    <label class="label" for="birthday">@lang('admin/events.classes.fleets.boats.guests.edit.birthday')</label>

                    <div class="control">
                        <input class="input @error('birthday') is-danger @enderror" type="date" id="birthday" name="birthday" value="{{ old('birthday', $eventClassFleetBoatGuest->birthday != null ? $eventClassFleetBoatGuest->birthday->format('Y-m-d') : '') }}">
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
                    <label class="label" for="email">@lang('admin/events.classes.fleets.boats.guests.edit.email')</label>

                    <div class="control">
                        <input class="input @error('email') is-danger @enderror" type="email" id="email" name="email" value="{{ old('email', $eventClassFleetBoatGuest->email) }}">
                    </div>

                    @error('email')
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="phone">@lang('admin/events.classes.fleets.boats.guests.edit.phone')</label>

                    <div class="control">
                        <input class="input @error('phone') is-danger @enderror" type="tel" id="phone" name="phone" value="{{ old('phone', $eventClassFleetBoatGuest->phone) }}">
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
                    <label class="label" for="address">@lang('admin/events.classes.fleets.boats.guests.edit.address')</label>

                    <div class="control">
                        <input class="input @error('address') is-danger @enderror" type="text" id="address" name="address" value="{{ old('address', $eventClassFleetBoatGuest->address) }}">
                    </div>

                    @error('address')
                        <p class="help is-danger">{{ $errors->first('address') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="postcode">@lang('admin/events.classes.fleets.boats.guests.edit.postcode')</label>

                    <div class="control">
                        <input class="input @error('postcode') is-danger @enderror" type="text" id="postcode" name="postcode" value="{{ old('postcode', $eventClassFleetBoatGuest->postcode) }}">
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
                    <label class="label" for="city">@lang('admin/events.classes.fleets.boats.guests.edit.city')</label>

                    <div class="control">
                        <input class="input @error('city') is-danger @enderror" type="text" id="city" name="city" value="{{ old('city', $eventClassFleetBoatGuest->city) }}">
                    </div>

                    @error('city')
                        <p class="help is-danger">{{ $errors->first('city') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="country">@lang('admin/events.classes.fleets.boats.guests.edit.country')</label>

                    <div class="control">
                        <div class="select is-fullwidth @error('country') is-danger @enderror">
                            <select id="country" name="country">
                                @foreach (\App\Models\User::COUNTRIES as $country)
                                    <option {{ $country == old('country', $eventClassFleetBoatGuest->country) ? 'selected' : '' }} value="{{ $country }}">{{ $country }}</option>
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
                <button class="button is-link" type="submit">@lang('admin/events.classes.fleets.boats.guests.edit.create_button')</button>
            </div>
        </div>
    </form>
@endsection
