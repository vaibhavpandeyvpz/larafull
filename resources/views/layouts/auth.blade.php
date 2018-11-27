@extends('layouts.base', [
    'html_class' => 'w-100 h-100',
    'body_class' => 'w-100 h-100 d-flex',
])

@section('body')
    <main class="container my-auto">
        @yield('content')
    </main>
@endsection
