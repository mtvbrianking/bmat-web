@extends('layouts.app')

@section('content')
    <div class="container-wrapper">
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12">
                @include('flash::message')
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Name</label>
                            <label class="col-sm-8 col-form-label">{{ title_case($user['name']) }}</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Email</label>
                            <label class="col-sm-8 col-form-label"><code>{{ $user['email'] }}</code></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <form action="{{ route('users.profile', $user['id']) }}" method="POST">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="row flex-grow">

                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row {{ $errors->has('current_password') ? 'has-error' : '' }}">
                                    <label class="col-sm-4 col-form-label">Current Password *</label>
                                    <div class="col-sm-8">
                                        <input name="current_password" type="password"
                                               value="{{ old('current_password')}}" class="form-control" required/>
                                        @if ($errors->has('current_password'))
                                            <small class="form-text text-danger">
                                                {{ $errors->first('current_password') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('new_password') ? 'has-error' : '' }}">
                                    <label class="col-sm-4 col-form-label">New Password *</label>
                                    <div class="col-sm-8">
                                        <input name="new_password"
                                               type="password"
                                               value="{{ old('new_password') }}" class="form-control"/>
                                        @if ($errors->has('new_password'))
                                            <small class="form-text text-danger">
                                                {{ $errors->first('new_password') }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row {{ $errors->has('new_password_confirmation') ? 'has-error' : '' }}">
                                    <label class="col-sm-4 col-form-label">Confirm Password *</label>
                                    <div class="col-sm-8">
                                        <input name="new_password_confirmation" type="password"
                                               value="{{ old('new_password_confirmation') }}" class="form-control"/>
                                    </div>
                                    @if ($errors->has('new_password_confirmation'))
                                        <small class="form-text text-danger">
                                            {{ $errors->first('new_password_confirmation') }}
                                        </small>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-warning mr-2">Change Password</button>
                                <a class="btn btn-light" href="{{ route('home') }}">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
