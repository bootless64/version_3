<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\LoggingService;

class SettingController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function index()
    {
        $passwordMinLength = Setting::get('password_min_length', 8);
        $passwordComplexity = Setting::get('password_complexity', 'medium');

        return view('dashboard.settings', compact('passwordMinLength', 'passwordComplexity'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'password_min_length' => 'required|integer|min:4|max:20',
            'password_complexity' => 'required|in:simple,medium,complex',
        ]);

        $oldPasswordMinLength = Setting::get('password_min_length', 8);
        $oldPasswordComplexity = Setting::get('password_complexity', 'medium');

        Setting::set('password_min_length', $validated['password_min_length']);
        Setting::set('password_complexity', $validated['password_complexity']);

        $this->logger->logConfigurationChanged('password_min_length', $oldPasswordMinLength, $validated['password_min_length'], auth()->id());
        $this->logger->logConfigurationChanged('password_complexity', $oldPasswordComplexity, $validated['password_complexity'], auth()->id());

        return back()->with('success', 'تنظیمات با موفقیت ذخیره شد.');
    }
}