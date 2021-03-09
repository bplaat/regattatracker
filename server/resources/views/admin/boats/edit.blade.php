@extends('layout')

@section('title', __('admin/boats.edit.title', [ 'boat.name' => $boat->name ]))

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
            <label class="label" for="user_id">@lang('admin/boats.create.user')</label>

            <div class="control">
                <div class="select @error('user_id') is-danger @enderror">
                    <select id="user_id" name="user_id" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if ($user->id == old('user_id', $boat->user_id)) selected @endif>
                                {{ $user->id }}. {{ $user->firstname }} {{ $user->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            @error('user_id')
                <p class="help is-danger">{{ $errors->first('user_id') }}</p>
            @enderror
        </div>

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
                <textarea class="textarea @error('description') is-danger @enderror" id="description" name="description" required>{{ old('description', $boat->description) }}</textarea>
            </div>

            @error('description')
                <p class="help is-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">@lang('admin/boats.edit.button')</button>
            </div>
        </div>
    </form>
@endsection
