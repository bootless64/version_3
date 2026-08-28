@extends('layouts.app')

@section('title')
    <title>تایید شماره موبایل</title>
@endsection

@section('content')

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">تایید شماره موبایل</div>

                    <div class="card-body">

                        @if (session('debug'))
                            <div class="alert alert-info">
                                {{ session('debug') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('register.verify-mobile-number.verify-code') }}">
                            @csrf
                            <div class="mb-3 row">
                                <label for="code" class="form-label col-form-label col-md-3">کد تایید پیامکی</label>

                                <div class="col-md-6">
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" required>

                                    @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">تایید</button>
                            </div>
                        </form>

                        @php
                            $expiresAt = session('mobile_verification_expires_at');
                            $attempts = session('mobile_verification_attempts');
                            $countdown = 120 - now()->diffInSeconds(session('last_verification_code_sent_at'));
                        @endphp

                        @if (now() < $expiresAt && $attempts < 3)
                            <div id="resend-countdown" class="d-flex justify-content-center m-4">
                                <span class="text-secondary">امکان درخواست ارسال مجدد کد تا</span>
                                <span id="countdown" class="text-secondary mx-1">{{ $countdown }}</span>
                                <span class="text-secondary">ثانیه</span>
                            </div>

                            <div id="resend-button" class="d-none justify-content-center m-4">
                                <form method="POST" action="{{ route('register.verify-mobile-number.resend-code') }}" id="resend-form" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-link">ارسال مجدد کد</button>
                                </form>
                            </div>

                        @else
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('register') }}" class="btn btn-link m-4">بازگشت به فرم عضویت</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        let countdown = {{ $countdown }};
        const countdownElement = document.getElementById('countdown');
        const resendCountdown = document.getElementById('resend-countdown');
        const resendButtonElement = document.getElementById('resend-button');

        if(countdown > 0)
        {
            const interval = setInterval(() => {
                countdown--;
                countdownElement.textContent = countdown;

                if (countdown <= 0) {
                    resendCountdown.classList.remove('d-flex');
                    resendCountdown.classList.add('d-none');

                    resendButtonElement.classList.remove('d-none');
                    resendButtonElement.classList.add('d-flex');

                    clearInterval(interval);
                }
            }, 1000);
        }
        else {
            resendCountdown.classList.remove('d-flex');
            resendCountdown.classList.add('d-none');

            resendButtonElement.classList.remove('d-none');
            resendButtonElement.classList.add('d-flex');
        }
    </script>
@endsection
