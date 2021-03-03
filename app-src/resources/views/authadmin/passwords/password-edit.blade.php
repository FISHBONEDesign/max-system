@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Change Password</div>

        <div class="card-body">
            <form method="POST" action="{{ route('auth.admin.passwords.update') }}">
                @csrf
                @method('patch')

                <div class="form-group row">
                    <label for="password"
                        class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

                    <div class="col-md-4">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm"
                        class="col-md-2 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                    <div class="col-md-4">
                        <input id="password-confirm" type="password" class="form-control"
                            name="password_confirmation" required autocomplete="new-password">
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
