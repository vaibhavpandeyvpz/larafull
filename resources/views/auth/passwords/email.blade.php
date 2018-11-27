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
                    <h6 class="card-subtitle text-muted">{{ __('Enter your email below to receive link.') }}</h6>
                    <hr>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('password.email') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="reset-email">{{ __('E-mail address') }}</label>
                            <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="reset-email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback" role="alert">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="form-group mb-0">
                            <button class="btn btn-primary">{{ __('Send Link') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

