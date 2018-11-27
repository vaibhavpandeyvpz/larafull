<!doctype html>
<html class="{{ isset($html_class) ? $html_class : '' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('meta')
        <title>{{ config('app.name', 'Laravel') }}</title>
    @show
    @section('styles')
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @show
    @auth
        <script>
            function logout(e) {
                e.preventDefault();
                document.forms['logout-form'].submit()
            }
        </script>
    @endauth
</head>
<body class="{{ isset($body_class) ? $body_class : '' }}">
@auth
    <form action="{{ route('logout') }}" id="logout-form" method="post" style="display: none;">
        @csrf
    </form>
@endauth
@yield('body')
@section('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@show
</body>
</html>
