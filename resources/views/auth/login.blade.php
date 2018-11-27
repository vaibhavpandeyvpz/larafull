@extends('layouts.auth')

@section('meta')
    <title>{{ __('Login') }} - {{ config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Login') }}</h5>
                    <h6 class="card-subtitle text-muted">{{ __('Enter your credentials below to login.') }}</h6>
                    <hr>
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="login-email">{{ __('E-mail address') }}</label>
                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="login-email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback" role="alert">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="login-password">{{ __('Password') }}</label>
                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="login-password" name="password" type="password" value="{{ old('password') }}" required>
                            @if ($errors->has('password'))
                                <div class="invalid-feedback" role="alert">{{ $errors->first('password') }}</div>
                            @endif
                            <p class="text-right mt-1 mb-0">
                                <a href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
                            </p>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" id="login-remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="login-remember">{{ __('Remember next time?') }}</label>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <button class="btn btn-primary">{{ __('Login') }}</button>
                            @if (config('services.google.client_id'))
                                <a class="btn btn-outline-danger" href="{{ route('login.socialite', ['provider' => 'google']) }}">{{ __('Login w/ Google+') }}</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
