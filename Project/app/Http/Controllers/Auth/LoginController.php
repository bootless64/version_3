<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    const MAX_ATTEMPTS = 5;
    const LOCK_MINUTES = 15;

    protected function redirectTo()
    {
        $intended = session()->pull('url.intended');
        return $intended ?: $this->redirectTo;
    }

    public function showLoginForm(Request $request)
    {
        if (! $request->has('redirect_to')) {
            session()->forget('url.intended');
        }
        return view('auth.login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password'        => 'required|string',
            'captcha'         => 'required|captcha:flat',
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->locked_until && now()->lessThan($user->locked_until)) {
                $remaining = now()->diffInMinutes($user->locked_until) + 1;

                app(LoggingService::class)->logAuthenticationAttempt(
                    $request->email, false, 'account_locked'
                );

                throw ValidationException::withMessages([
                    $this->username() => [
                        "حساب شما به دلیل تلاش‌های ناموفق متوالی به مدت {$remaining} دقیقه دیگر قفل است."
                    ],
                ]);
            }

            if ($user->locked_until && now()->greaterThanOrEqualTo($user->locked_until)) {
                $user->login_attempts = 0;
                $user->locked_until   = null;
                $user->save();
            }
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated(Request $request, $user)
    {
        $user->login_attempts = 0;
        $user->locked_until   = null;
        $user->save();

        app(LoggingService::class)->logAuthenticationResult($user, true, 'email_password');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        app(LoggingService::class)->logAuthenticationAttempt(
            $request->email, false, 'invalid credentials'
        );

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->login_attempts += 1;

            if ($user->login_attempts >= self::MAX_ATTEMPTS) {
                $user->locked_until   = now()->addMinutes(self::LOCK_MINUTES);
                $user->login_attempts = 0;

                app(LoggingService::class)->logSecurityFeatureFailed(
                    'login_lock',
                    "حساب {$user->email} بعد از " . self::MAX_ATTEMPTS . " تلاش ناموفق قفل شد.",
                    $user->id
                );

                $user->save();

                throw ValidationException::withMessages([
                    $this->username() => [
                        'حساب شما به دلیل ' . self::MAX_ATTEMPTS . ' بار تلاش ناموفق به مدت ' . self::LOCK_MINUTES . ' دقیقه قفل شد.'
                    ],
                ]);
            }

            $user->save();

            $remaining = self::MAX_ATTEMPTS - $user->login_attempts;

            throw ValidationException::withMessages([
                $this->username() => [
                    trans('auth.failed') . " ({$remaining} تلاش دیگر قبل از قفل شدن حساب)"
                ],
            ]);
        }

        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function loggedOut(Request $request)
    {
        app(LoggingService::class)->logSessionTerminated(
            optional(auth()->user())->id,
            'user',
            'manual logout'
        );
    }
}
