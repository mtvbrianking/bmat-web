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

                                @if (session('status'))
                                    <div class="row">
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('password.email') }}" class="pt-4">

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

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-block btn-outline-info btn-lg font-weight-medium">
                                            {{ __('Send Reset Link') }}
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
