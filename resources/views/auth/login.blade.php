@extends('layouts.app-min')

@section('content')
    <div class="row">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth">
            <div class="row w-100">
                <div class="col-lg-8 mx-auto">
                    <div class="row">
                        <div class="col-lg-6 bg-white">
                            <div class="auth-form-light text-left p-5">
                                <h1 class="font-weight-medium">SIGN IN</h1>
                                {{--<h4 class="font-weight-light">to continue...</h4>--}}

                                @if (session('status'))
                                    <div class="row">
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="pt-4">

                                    @csrf

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
                                    </div>

                                    <div class="mt-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" id="remember"
                                                       name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-block btn-outline-info btn-lg font-weight-medium">
                                            {{ __('Login') }}
                                        </button>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="text-left col-md-6">
                                            <a href="{{ route('register') }}" class="auth-link text-black">
                                                <span class="font-weight-medium">{{ __('Create account...') }}</span>
                                            </a>
                                        </div>
                                        <div class="text-right col-md-6">
                                            <a href="{{ route('password.request') }}" class="auth-link text-black">
                                                <span class="font-weight-medium">{{ __('Forgot password?') }}</span>
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