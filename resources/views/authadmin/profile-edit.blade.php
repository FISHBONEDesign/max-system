@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Edit Profile</div>

        <div class="card-body">
            <form method="POST" action="{{ route('auth.admin.profile.update') }}">
                @csrf
                @method('patch')
                <div class="form-group row">
                    <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>

                    <div class="col-md-4">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div class="col-md-4">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <div class="form-control border-0">
                            <a class="btn-link" data-turbolinks="false" href="{{ route('auth.admin.passwords.show') }}">Change Password</a>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-2">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                        <a href="{{ route('auth.admin.profile') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
