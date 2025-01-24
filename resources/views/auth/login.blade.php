@extends('layouts.app')

@section('content')
    <br>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4 w-100" style="max-width: 400px;">
            <h2 class="text-center mb-4">Login</h2>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}"
                        required autofocus autocomplete="username">
                    @if ($errors->has('email'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none text-sm text-secondary" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    <input id="password" class="form-control" type="password" name="password" required
                        autocomplete="current-password">
                    @if ($errors->has('password'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="mb-3 form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label">{{ __('Remember me') }}</label>
                </div>

                <!-- Submit Button -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Log in') }}
                    </button>
                </div>

                <!-- Divider -->
                <div class="text-center my-3">
                    <hr class="my-2">
                    <span class="small text-muted">Don't have an account?</span>
                    <hr class="my-2">
                </div>

                <!-- Create Account -->
                <div class="text-center">
                    <a href="{{ route('register') }}" class="text-decoration-none">{{ __('Create account') }}</a>
                </div>
            </form>
        </div>
    </div>
@endsection
