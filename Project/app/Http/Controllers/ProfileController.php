<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function index()
    {
        return view('dashboard.my-profile');
    }

    public function updateName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'update_name')->with('open_form', 'update_name');
        }

        $validated = $validator->validated();

        /** @var User|null */
        $user = Auth::user();
        $oldName = $user->name;
        $user->name = $validated['name'];
        $user->save();

        $this->logger->logDataUpdate('users', $user->id, [
            'old_name' => $oldName
        ], [
            'new_name' => $validated['name']
        ], auth()->id());

        return back()->with('success', 'نام شما با موفقیت بروزرسانی شد.')->with('open_form', 'update_name');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|regex:/[A-Z]/|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'update_password')->with('open_form', 'update_password');
        }

        $validated = $validator->validated();

        /** @var User|null */
        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            $this->logger->logPasswordTest($user->email, false);
            return back()->withErrors(['current_password' => 'رمز فعلی صحیح نیست.'])->with('open_form', 'update_password');
        }
        if (Hash::check($validated['new_password'], $user->password)) {
            return back()->withErrors(['new_password' => 'رمز جدید با رمز فعلی یکسان است.'])->with('open_form', 'update_password');
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        $this->logger->logSecurityAttributeChanged($user->email, 'password', '***', '***', auth()->id());

        return back()->with('success', 'رمز عبور شما با موفقیت تغییر کرد.')->with('open_form', 'update_password');
    }

    public function updateAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator, 'update_avatar')->with('open_form', 'update_avatar');
        }

        $validated = $validator->validated();

        /** @var User|null */
        $user = Auth::user();

        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        $filename = uniqid() . '.' . $validated['avatar']->getClientOriginalExtension();
        $validated['avatar']->storeAs('public/avatars', $filename);

        $user->avatar = $filename;
        $user->save();

        return back()->with('success', 'عکس پروفایل با موفقیت بروزرسانی شد.')->with('open_form', 'update_avatar');
    }

    public function deleteAvatar()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
            $user->avatar = null;
            $user->save();
            return back()->with('success', 'عکس پروفایل حذف شد.')->with('open_form', 'update_avatar');
        }
    }

    public function deleteAccount(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if ($user->hasRole('admin') && User::role('admin')->count() <= 2) {
            return back()->with('error', 'حداقل دو مدیر باید در سیستم بمانند.')->with('open_form', 'delete_account');
        }

        $this->logger->logDataDelete('users', $user->id, [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'deleted_by_self' => true
        ], auth()->id());

        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        auth()->logout();

        $user->delete();
        return redirect('/')->with('success','حساب کاربری شما حذف شد.');
    }

}
