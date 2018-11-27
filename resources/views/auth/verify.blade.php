@extends('layouts.auth')

@section('meta')
    <title>{{ __('Verify') }} - {{ config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Verify') }}</h5>
                    <h6 class="card-subtitle text-muted">{{ __('Please verify your email address.') }}</h6>
                    <hr>
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here') }}</a> to request another or <a href="{{ route('logout') }}" onclick="logout(event)">{{ __('logout') }}</a>.
                </div>
            </div>
        </div>
    </div>
@endsection
