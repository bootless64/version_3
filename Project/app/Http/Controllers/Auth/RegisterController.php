<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function validateRegisterData(Request $request)
    {
        $minLength = Setting::get('password_min_length', 8);
        $complexity = Setting::get('password_complexity', 'medium');

        $passwordRules = ['required', 'string', 'min:' . $minLength, 'confirmed'];

        if ($complexity === 'simple') {
            $passwordRules[] = 'regex:/^[a-zA-Z]+$|^[0-9]+$/';
        } elseif ($complexity === 'medium') {
            $passwordRules[] = 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/';
        } elseif ($complexity === 'complex') {
            $passwordRules[] = 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).+$/';
        }

        $request->validate([
            'name' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'mobile_number' => ['required', 'regex:/^09\d{9}$/', 'unique:users'],
            'password' => $passwordRules,
            'captcha' => ['required', 'captcha:flat'],
        ], [
            'password.regex' => $this->getPasswordErrorMessage($complexity),
            'password.min' => 'حداقل طول پسورد باید ' . $minLength . ' کاراکتر باشد.',
        ]);

        Session::put('register_data', $request->only('name', 'email', 'password', 'mobile_number'));
        Session::forget('mobile_verification_attempts');
        Session::put('mobile_verification_expires_at', now()->addMinutes(5));

        return $this->sendVerificationCode($request);
    }

    private function getPasswordErrorMessage($complexity)
    {
        $messages = [
            'simple' => 'پسورد باید فقط شامل حروف (a-z) یا فقط شامل اعداد (0-9) باشد.',
            'medium' => 'پسورد باید شامل حروف و اعداد باشد.',
            'complex' => 'پسورد باید شامل حروف کوچک، حروف بزرگ، اعداد و کاراکترهای خاص (!@#$%^&*) باشد.',
        ];

        return $messages[$complexity] ?? 'فرمت پسورد وارد شده صحیح نیست.';
    }

    public function sendVerificationCode(Request $request)
    {
        $result = $this->sendViaSms($request);

        if(! $result['status']) {
            return back()->withErrors(['mobile_number' => $result['message']]);
        }

        return redirect()->route('register.verify-mobile-number.index');
    }

    public function resendVerificationCode(Request $request)
    {
        $result = $this->sendViaSms($request);

        if(! $result['status']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }

    public function sendViaSms(Request $request)
    {
        $lastSent = Session::get('last_verification_code_sent_at');

        if($lastSent && now()->diffInSeconds($lastSent) < 120) {
            return ['status' => false, 'message' => 'کد لحظاتی پیش ارسال شده است، لطفا قبل از درخواست مجدد چند لحظه صبر کنید.'];
        }

        $code = rand(100000, 999999);

        Session::put('mobile_verification_code', $code);
        Session::put('last_verification_code_sent_at', now());

        session()->flash('debug', 'کد تایید شماره موبایل: '.$code);

        return ['status' => true, 'message' => 'کد پیامکی به موبایل شما ارسال شد.'];
    }

    public function verifyCode(Request $request)
    {
        if(now()->gt(Session::get('mobile_verification_expires_at'))) {
            return back()->withErrors(['code' => 'زمان وارد کردن کد به پایان رسیده است. لطفا دوباره فرم عضویت را پر کنید.']);
        }

        $attempts = Session::get('mobile_verification_attempts', 0);
        if($attempts >= 3) {
            return back()->withErrors(['code' => 'تعداد تلاش‌ها بیشتر از حد مجاز است. لطفا دوباره فرم عضویت را پر کنید.']);
        }

        $request->validate([
            'code' => 'required|digits:6',
        ]);

        if ($request->code != Session::get('mobile_verification_code')) {

            $attempts++;
            Session::put('mobile_verification_attempts', $attempts);

            if($attempts >= 3) {
                return back()->withErrors(['code' => 'تعداد تلاش‌ها بیشتر از حد مجاز است. لطفا دوباره فرم عضویت را پر کنید.']);
            }
            return back()->withErrors(['code' => 'کد وارد شده نادرست است.']);
        }

        $data = Session::get('register_data');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_number' => $data['mobile_number'],
            'password' => Hash::make($data['password']),
        ]);

        $user->syncRoles(['user']);

        auth()->login($user);

        Session::forget([
            'register_data',
            'mobile_verification_code',
            'last_verification_code_sent_at',
            'mobile_verification_expires_at',
            'mobile_verification_attempts',
        ]);

        return redirect('/dashboard');
    }
}