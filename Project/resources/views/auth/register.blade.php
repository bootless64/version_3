@extends('layouts.app')

@section('title')
    <title>عضویت</title>
@endsection

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">

                        <div class="mb-4">
                            <strong>لطفا موارد زیر را در نظر داشته باشید:</strong>
                            <br>
                            <span>رمز عبور انتخابی باید شرایط زیر را داشته باشد:</span>
                            <ul class="mb-0">
                                <li>شامل حداقل 8 کاراکتر باشد.</li>
                                <li>شامل حداقل یک حرف بزرگ باشد.</li>
                            </ul>
                            <span>برای نهایی شدن عضویت، پس از تکمیل فرم، نیاز به ورود کد 6 رقمی پیامک شده می‌باشد.</span>
                        </div>

                        <form method="POST" action="{{ route('register.validate-register-data') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-3 col-form-label">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="mobile_number"
                                    class="col-md-3 col-form-label">{{ __('Mobile Number') }}</label>

                                <div class="col-md-6">
                                    <input id="mobile_number" type="tel" placeholder="09..."
                                        class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number"
                                        value="{{ old('mobile_number') }}" autocomplete="mobile_number">

                                    @error('mobile_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-3 col-form-label">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-3 col-form-label">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-3 col-form-label">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-3 d-flex">
                                <label for="captcha" class="form-label col-md-3 col-form-label">کد امنیتی</label>

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

                                <div class="d-flex col-md-6 align-items-center justify-content-center mx-auto mt-2 gap-2">
                                  <img src="{{ captcha_src('flat') }}" id="captcha-img" alt="captcha">
                                  <button type="button" class="btn btn-outline-secondary btn-sm" id="reload-captcha">
                                    ↻
                                  </button>
                                </div>
                            </div>

                            <script>
                                document.getElementById('reload-captcha').addEventListener('click', function () {
                                    const captchaImage = document.getElementById('captcha-img');
                                    captchaImage.src = '{{ url("captcha/flat") }}?r=' + Date.now();
                                });
                            </script>

                            <div class="row mb-0">
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
