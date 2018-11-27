@extends('layouts.base')

@section('body')
    <main class="container">
        <nav class="navbar navbar-expand-sm navbar-light">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}" data-target="#navbar-main" data-toggle="collapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-main">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbar-dropdown-user" href="#" role="button">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-dropdown-user">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="logout(event)">{{ __('Logout') }}</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        @yield('content')
    </main>
@endsection
