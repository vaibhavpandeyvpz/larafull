@extends('layouts.auth')

@section('meta')
    <title>{{ __('Register') }} - {{ config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Register') }}</h5>
                    <h6 class="card-subtitle text-muted">{{ __('Enter your basic details below to register.') }}</h6>
                    <hr>
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="register-name">{{ __('Name') }}</label>
                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="register-name" name="name"  value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <div class="invalid-feedback" role="alert">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="register-email">{{ __('E-mail address') }}</label>
                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="register-email" name="email" type="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback" role="alert">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="register-password">{{ __('Password') }}</label>
                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="register-password" name="password" type="password" required>
                            @if ($errors->has('password'))
                                <div class="invalid-feedback" role="alert">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="register-password-confirmation">{{ __('Password confirmation') }}</label>
                            <input class="form-control" id="register-password-confirmation" name="password_confirmation" type="password" required>
                        </div>
                        <div class="form-group mb-0">
                            <button class="btn btn-primary">{{ __('Register') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
