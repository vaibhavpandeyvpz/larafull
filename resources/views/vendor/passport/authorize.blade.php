@extends('layouts.auth')

@section('meta')
    <title>{{ __('Authorize') }} - {{ config('app.name', 'Laravel') }}</title>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card border-0">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Authorize') }}</h5>
                    <h6 class="card-subtitle text-muted">{{ __('Allow or deny account/data access.') }}</h6>
                    <hr>
                    <p class="card-text text-center"><strong>{{ $client->name }}</strong> is requesting permission to access your account.</p>
                    @if (count($scopes) > 0)
                        <p class="card-text"><strong>This application will be able to:</strong></p>
                        <ul>
                            @foreach ($scopes as $scope)
                                <li>{{ $scope->description }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="row justify-content-center">
                        <div class="col-5">
                            <form method="post" action="{{ url('/oauth/authorize') }}">
                                @csrf
                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button class="btn btn-success btn-block">{{ __('Allow') }}</button>
                            </form>
                        </div>
                        <div class="col-5">
                            <form method="post" action="{{ url('/oauth/authorize') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button class="btn btn-danger btn-block">{{ __('Deny') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
