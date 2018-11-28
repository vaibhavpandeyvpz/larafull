@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li class="nav-item">
                    <a aria-controls="tab-clients-content" aria-selected="true" class="nav-link active" data-toggle="tab" href="#tab-clients-content" id="tab-clients" role="tab">{{ __('Clients') }}</a>
                </li>
                <li class="nav-item">
                    <a aria-controls="tab-authorized-clients-content" aria-selected="true" class="nav-link" data-toggle="tab" href="#tab-authorized-clients-content" id="tab-authorized-clients" role="tab">{{ __('Authorized Clients') }}</a>
                </li>
                <li class="nav-item">
                    <a aria-controls="tab-personal-access-tokens-content" aria-selected="true" class="nav-link" data-toggle="tab" href="#tab-personal-access-tokens-content" id="tab-personal-access-tokens" role="tab">{{ __('Personal Access Tokens') }}</a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab-clients-content" role="tabpanel" aria-labelledby="tab-clients">
                <passport-clients></passport-clients>
            </div>
            <div class="tab-pane fade" id="tab-authorized-clients-content" role="tabpanel" aria-labelledby="tab-authorized-clients">
                <passport-authorized-clients></passport-authorized-clients>
            </div>
            <div class="tab-pane fade" id="tab-personal-access-tokens-content" role="tabpanel" aria-labelledby="tab-personal-access-tokens">
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
@endsection
