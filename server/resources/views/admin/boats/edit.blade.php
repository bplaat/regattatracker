@extends('layout')

@section('title', __('admin/boats.edit.title', ['boat.name' => $boat->name]))

@section('content')
    <div class="breadcrumb">
        <ul>
            <li><a href="{{ route('home') }}">{{ config('app.name') }}</a></li>
            <li><a href="{{ route('admin.home') }}">@lang('admin/home.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.index') }}">@lang('admin/boats.index.breadcrumb')</a></li>
            <li><a href="{{ route('admin.boats.show', $boat) }}">{{ $boat->name }}</a></li>
            <li class="is-active"><a href="{{ route('admin.boats.edit', $boat) }}">@lang('admin/boats.edit.breadcrumb')</a></li>
        </ul>
    </div>

    <h1 class="title">@lang('admin/boats.edit.header')</h1>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.boats.update', $boat) }}">
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
            <label class="label" for="image">@lang('boats.edit.image')</label>

            <div class="control">
                <input class="input @error('image') is-danger @enderror" type="file" accept=".jpg,.jpeg,.png" id="image" name="image">
            </div>

            @error('image')
                <p class="help is-danger">{{ $errors->first('image') }}</p>
            @else
                <p class="help">@lang('boats.edit.image_message')</p>
            @enderror
        </div>

        @if ($boat->image != null)
            <div class="buttons">
                <a class="button is-danger" href="{{ route('admin.boats.delete_image', $boat) }}">@lang('admin/boats.edit.delete_image_button')</a>
            </div>
        @endif

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label" for="mmsi">@lang('boats.create.mmsi')</label>

                    <div class="control">
                        <input class="input @error('mmsi') is-danger @enderror" type="number" id="mmsi" name="mmsi" value="{{ old('mmsi', $boat->mmsi) }}" required>
                    </div>

                    @error('mmsi')
                        <p class="help is-danger">{{ $errors->first('mmsi') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="length">@lang('boats.create.length')</label>

                    <div class="control">
                        <input class="input @error('length') is-danger @enderror" type="number" step="0.01" id="length" name="length" value="{{ old('length', $boat->length) }}" required>
                    </div>

                    @error('length')
                        <p class="help is-danger">{{ $errors->first('length') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="breadth">@lang('boats.create.breadth')</label>

                    <div class="control">
                        <input class="input @error('breadth') is-danger @enderror" type="number" step="0.01" id="breadth" name="breadth" value="{{ old('breadth', $boat->breadth) }}" required>
                    </div>

                    @error('breadth')
                        <p class="help is-danger">{{ $errors->first('breadth') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="weight">@lang('boats.create.weight')</label>

                    <div class="control">
                        <input class="input @error('weight') is-danger @enderror" type="number" step="0.01" id="weight" name="weight" value="{{ old('weight', $boat->weight) }}" required>
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
                    <label class="label" for="sail_number">@lang('boats.create.sail_number')</label>

                    <div class="control">
                        <input class="input @error('sail_number') is-danger @enderror" type="text" id="sail_number" name="sail_number" value="{{ old('sail_number', $boat->sail_number) }}" required>
                    </div>

                    @error('sail_number')
                        <p class="help is-danger">{{ $errors->first('sail_number') }}</p>
                    @enderror
                </div>
            </div>

            <div class="column">
                <div class="field">
                    <label class="label" for="sail_area">@lang('boats.create.sail_area')</label>

                    <div class="control">
                        <input class="input @error('sail_area') is-danger @enderror" type="number" step="0.01" id="sail_area" name="sail_area" value="{{ old('sail_area', $boat->sail_area) }}" required>
                    </div>

                    @error('sail_area')
                        <p class="help is-danger">{{ $errors->first('sail_area') }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/boats.edit.edit_button')</button>
            </div>
        </div>
    </form>
@endsection
