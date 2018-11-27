@extends('layouts.app')

@section('content')
    <div class="card border-0">
        <div class="card-header">{{ __('Dashboard') }}</div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <p class="card-text">{{ __('You are logged in!') }}</p>
        </div>
    </div>
@endsection
