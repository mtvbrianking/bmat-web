@extends('layouts.app-min')

@section('content')
    <div class="row">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth">
            <div class="row w-100">
                <div class="col-lg-8 mx-auto">
                    <div class="row">
                        <div class="col-lg-6 bg-white">
                            <div class="auth-form-light text-left p-5">
                                <h1 class="font-weight-medium">REGISTER</h1>
                                <h4 class="font-weight-light">to continue...</h4>

                                <form method="POST" action="{{ route('register') }}" class="pt-4">

                                    @csrf

                                    <div class="form-group">
                                        <label for="name">{{ __('Full name') }}</label>
                                        <input type="text" class="form-control" id="name"
                                               name="name" value="{{ old('name') }}" required autofocus>
                                        <i class="mdi mdi-account"></i>

                                        @if ($errors->has('name'))
                                            <small class="form-text text-danger">
                                                {{ $errors->first('name') }}
                                            </small>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="email">{{ __('E-Mail Address') }}</label>
                                        <input type="email" class="form-control" id="email"
                                               name="email" value="{{ old('email') }}" required>
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
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                    <div class="mt-4">
                                        <div class="text-center">
                                            <a href="{{ route('login') }}" class="auth-link text-black">
                                                <span class="font-weight-medium">
                                                    Already have an account? {{ __('Login...') }}
                                                </span>
                                            </a>
                                        </div>
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