@extends('layouts.auth')

@section('meta')
    <title>{{ __('Reset Password') }} - {{ config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Reset Password') }}</h5>
                    <h6 class="card-subtitle text-muted">{{ __('Enter your email & new password below to reset.') }}</h6>
                    <hr>
                    <form action="{{ route('password.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="reset-email">{{ __('E-mail address') }}</label>
                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="reset-email" name="email" type="email" value="{{ $email ?? old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback" role="alert">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="reset-password">{{ __('Password') }}</label>
                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="reset-password" name="password" type="password" required>
                            @if ($errors->has('password'))
                                <div class="invalid-feedback" role="alert">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="reset-password-confirmation">{{ __('Password confirmation') }}</label>
                            <input class="form-control" id="reset-password-confirmation" name="password_confirmation" type="password" required>
                        </div>
                        <div class="form-group mb-0">
                            <button class="btn btn-primary">{{ __('Reset Password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
