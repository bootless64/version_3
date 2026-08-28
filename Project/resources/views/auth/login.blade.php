@extends('layouts.app')

@section('title')
    <title>ورود</title>
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>

                                    <input class="form-check-input border-dark me-3" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>

                                </div>
                            </div>

                            <div class="row mb-3 d-flex">
                                <label for="captcha" class="form-label col-md-4 col-form-label text-md-end">کد
                                    امنیتی</label>

                                <div class="col-md-6">
                                    <input id="captcha" type="text" name="captcha"
                                        class="form-control @error('captcha') is-invalid @enderror"
                                        placeholder="کد را وارد کنید">
                                    @error('captcha')
                                        <span class="invalid-feedback mt-2" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="d-flex col-md-4 align-items-center mx-auto mt-2 gap-2">
                                    <img src="{{ captcha_src('flat') }}" id="captcha-img" alt="captcha">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="reload-captcha">
                                        <span>↻</span>
                                    </button>
                                </div>
                            </div>

                            <script>
                                document.getElementById('reload-captcha').addEventListener('click', function() {
                                    const captchaImage = document.getElementById('captcha-img');
                                    captchaImage.src = '{{ url('captcha/flat') }}?r=' + Date.now();
                                });
                            </script>

                            <div class="row mb-0">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link m-2" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
