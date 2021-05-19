<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="has-navbar-fixed-top">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="@lang('layout.description')">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/apple-touch-icon.png">
    <link rel="mask-icon" href="/images/safari-pinned-tab.svg" color="#276cda">
    <meta name="theme-color" content="#f5f5f5">
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" href="/css/bulma.min.css">
    @hasSection('head')
        @yield('head')
    @endif
</head>
<body>
    @hasSection('navbar')
        @yield('navbar')
    @else
        <div class="navbar is-light is-fixed-top">
            <div class="container">
                <div class="navbar-brand">
                    <a class="navbar-item has-text-weight-bold" href="{{ route('home') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px; margin-right: 10px;" viewBox="0 0 24 24">
                            <path fill="#111" d="M7,17L10.2,10.2L17,7L13.8,13.8L7,17M12,11.1A0.9,0.9 0 0,0 11.1,12A0.9,0.9 0 0,0 12,12.9A0.9,0.9 0 0,0 12.9,12A0.9,0.9 0 0,0 12,11.1M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4Z" />
                        </svg>
                        {{ config('app.name') }}
                    </a>
                    <a class="navbar-burger burger"><span></span><span></span><span></span></a>
                </div>
                <div class="navbar-menu">
                    @auth
                        <div class="navbar-start">
                            @if (Auth::user()->boats->count() > 0)
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link is-arrowless" href="{{ route('boats.index') }}">@lang('layout.header.boats')</a>
                                    <div class="navbar-dropdown">
                                        @foreach (Auth::user()->boats->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->sortByDesc('pivot.role')->take(10) as $boat)
                                            <a class="navbar-item" href="{{ route('boats.show', $boat) }}">{{ $boat->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a class="navbar-item" href="{{ route('boats.index') }}">@lang('layout.header.boats')</a>
                            @endif

                            @if (Auth::user()->role == App\Models\User::ROLE_ADMIN)
                                <div class="navbar-item has-dropdown is-hoverable">
                                    <a class="navbar-link is-arrowless" href="{{ route('admin.home') }}">@lang('layout.header.admin_home')</a>
                                    <div class="navbar-dropdown">
                                        <a class="navbar-item" href="{{ route('admin.users.index') }}">@lang('layout.header.admin_users')</a>
                                        <a class="navbar-item" href="{{ route('admin.api_keys.index') }}">@lang('layout.header.admin_api_keys')</a>
                                        <a class="navbar-item" href="{{ route('admin.boats.index') }}">@lang('layout.header.admin_boats')</a>
                                        <a class="navbar-item" href="{{ route('admin.boat_types.index') }}">@lang('layout.header.admin_boat_types')</a>
                                        <a class="navbar-item" href="{{ route('admin.buoys.index') }}">@lang('layout.header.admin_buoys')</a>
                                        <a class="navbar-item" href="{{ route('admin.events.index') }}">@lang('layout.header.admin_events')</a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="navbar-end">
                            <div class="navbar-item" style="display: flex; align-items: center;">
                                <img style="border-radius: 50%; margin-right: 10px;" src="https://www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}?s=48&d=mp" alt="{{ Auth::user()->name }}'s avatar">
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <div class="navbar-item">
                                <div class="buttons">
                                    <a class="button is-link" href="{{ route('settings') }}">@lang('layout.header.settings')</a>
                                    <a class="button" href="{{ route('auth.logout') }}">@lang('layout.header.logout')</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="navbar-end">
                            <div class="navbar-item">
                                <div class="buttons">
                                    <a class="button is-link" href="{{ route('auth.login') }}">@lang('layout.header.login')</a>
                                    <a class="button" href="{{ route('auth.register') }}">@lang('layout.header.register')</a>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    @endif

    <div class="section">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <div class="footer">
        <div class="content has-text-centered">
            <p>@lang('layout.footer.authors')</p>
            <p>@lang('layout.footer.source')</p>
        </div>
    </div>

    <script src="/js/script.js"></script>
</body>
</html>
