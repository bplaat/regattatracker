<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title') - RagettaTracker</title>
    <link rel="stylesheet" href="/css/bulma.min.css">
</head>
<body>
    <div class="navbar is-light is-fixed-top">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-weight-bold" href="{{ route('home') }}">RegattaTracker</a>
                <a class="navbar-burger burger"><span></span><span></span><span></span></a>
            </div>
            <div class="navbar-menu">
                @auth
                    <div class="navbar-start">
                        @if (count(Auth::user()->boats) > 0)
                            <div class="navbar-item has-dropdown is-hoverable">
                                <a class="navbar-link is-arrowless" href="{{ route('boats.index') }}">@lang('layout.boats')</a>
                                <div class="navbar-dropdown">
                                    @foreach (Auth::user()->boats as $boat)
                                        <a class="navbar-item" href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a class="navbar-item" href="{{ route('boats.index') }}">@lang('layout.boats')</a>
                        @endif
                    </div>

                    <div class="navbar-end">
                        <div class="navbar-item" style="display: flex; align-items: center;">
                            <img style="border-radius: 50%; margin-right: 10px;" src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?s=48&d=mp" alt="{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}'s avatar">
                            <span>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                        </div>
                        <div class="navbar-item">
                            <div class="buttons">
                                <a class="button is-link" href="{{ route('settings') }}">@lang('layout.settings')</a>
                                <a class="button" href="{{ route('auth.logout') }}">@lang('layout.logout')</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="navbar-end">
                        <div class="navbar-item">
                            <div class="buttons">
                                <a class="button is-link" href="{{ route('auth.login') }}">@lang('layout.login')</a>
                                <a class="button" href="{{ route('auth.register') }}">@lang('layout.register')</a>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <div class="footer">
        <div class="content has-text-centered">
            <p>@lang('layout.footer_made_by')</p>
            <p>@lang('layout.footer_source')</p>
        </div>
    </div>

    <script src="/js/script.js"></script>
</body>
</html>