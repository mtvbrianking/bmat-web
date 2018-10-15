@extends('layouts.app-min')

@section('content')
    <div class="row">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth">
            <div class="row w-100">
                <div class="col-lg-8 mx-auto">
                    <div class="row">
                        <div class="col-lg-6 bg-white">
                            <div class="auth-form-light text-left p-5">
                                <h1 class="font-weight-medium">{{ __('Reset Password') }}</h1>

                                <div class="row">
                                    <div class="col-sm-12">
                                        @include('flash::message')
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('password.update') }}" class="pt-4">

                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group">
                                        <label for="email">{{ __('E-Mail Address') }}</label>
                                        <input type="email" class="form-control" id="email"
                                               name="email" value="{{ old('email') }}" required autofocus>
                                        <i class="mdi mdi-email"></i>

                                        @if ($errors->has('email'))
                                            <small class="form-text text-danger">
                                                {{ $errors->first('email') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password">{{ __('Password') }}</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <i class="mdi mdi-eye"></i>
                                        @if ($errors->has('password'))
                                            <small class="form-text text-danger">
                                                {{ $errors->first('password') }}
                                            </small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="password">{{ __('Confirm Password') }}</label>
                                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                                        <i class="mdi mdi-eye"></i>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-block btn-outline-info btn-lg font-weight-medium">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
