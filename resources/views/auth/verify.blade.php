@extends('layouts.app-min')

@section('content')
    <div class="row">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth">
            <div class="row w-100">
                <div class="col-lg-8 mx-auto">
                    <div class="row">
                        <div class="col-lg-7 bg-white">
                            <div class="auth-form-light text-left p-5">
                                <h1 class="font-weight-medium">{{ __('Verify Your Email Address') }}</h1>

                                @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                @endif

                                <hr>

                                <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>

                                <p>{{ __('If you did not receive the email') }},
                                    <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
