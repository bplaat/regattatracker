@extends('layout')

@section('title', __('admin/boats.edit.title', ['boat.name' => $boat->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="/">RegattaTracker</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.index') }}">@lang('admin/boats.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.boats.edit', $boat) }}">@lang('admin/boats.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/boats.edit.header')</h1>

    <form method="POST" action="{{ route('admin.boats.update', $boat) }}">
        @csrf

        <div class="field">
            <label class="label" for="name">@lang('admin/boats.edit.name')</label>

            <div class="control">
                <input class="input @error('name') is-danger @enderror" type="text" id="name" name="name" value="{{ old('name', $boat->name) }}" required>
            </div>

            @error('name')
                <p class="help is-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="description">@lang('admin/boats.edit.description')</label>

            <div class="control">
                <textarea class="textarea @error('description') is-danger @enderror" id="description" name="description">{{ old('description', $boat->description) }}</textarea>
            </div>

            @error('description')
                <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="MMSI">@lang('admin/boats.edit.MMSI')</label>

            <div class="control">
                <input class="input @error('MMSI') is-danger @enderror" type="number" id="MMSI" name="MMSI" value="{{ old('MMSI', $boat->MMSI) }}" required>
            </div>

            @error('MMSI')
            <p class="help is-danger">{{ $errors->first('MMSI') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="LOA">@lang('admin/boats.edit.LOA')</label>

            <div class="control">
                <input class="input @error('LOA') is-danger @enderror" type="number" step="0.01" id="LOA" name="LOA" value="{{ old('LOA', $boat->LOA) }}" required>
            </div>

            @error('LOA')
            <p class="help is-danger">{{ $errors->first('LOA') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="BOA">@lang('admin/boats.edit.BOA')</label>

            <div class="control">
                <input class="input @error('BOA') is-danger @enderror" type="number" step="0.01" id="BOA" name="BOA" value="{{ old('BOA', $boat->BOA) }}" required>
            </div>

            @error('BOA')
            <p class="help is-danger">{{ $errors->first('BOA') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="weight">@lang('admin/boats.edit.weight')</label>

            <div class="control">
                <input class="input @error('weight') is-danger @enderror" type="number" step="0.01" id="weight" name="weight" value="{{ old('weight', $boat->weight) }}" required>
            </div>

            @error('weight')
            <p class="help is-danger">{{ $errors->first('weight') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="sail_number">@lang('admin/boats.edit.sail_number')</label>

            <div class="control">
                <input class="input @error('sail_number') is-danger @enderror" type="number" id="sail_number" name="sail_number" value="{{ old('sail_number', $boat->sail_number) }}" required>
            </div>

            @error('sail_number')
            <p class="help is-danger">{{ $errors->first('sail_number') }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="sail_area">@lang('admin/boats.edit.sail_area')</label>

            <div class="control">
                <input class="input @error('sail_area') is-danger @enderror" type="number" step="0.01" id="sail_area" name="sail_area" value="{{ old('sail_area', $boat->sail_area) }}" required>
            </div>

            @error('sail_area')
            <p class="help is-danger">{{ $errors->first('sail_area') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/boats.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
