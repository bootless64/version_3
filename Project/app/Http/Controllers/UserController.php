<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\LoggingService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function generateFakeUser()
    {
        $user = \App\Models\User::factory()->create();
        $user->syncRoles(['user']);
        return response()->json($user);
    }

    public function manageUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%'.$request->email.'%');
        }
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->orderBy('id','desc')->paginate(20)
                       ->appends($request->only(['id','name','email','role']));

        $roles = Role::all();

        return view('dashboard.manage-users', compact('users','roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        if ($user->hasRole('admin') && User::role('admin')->count() <= 2) {
            return back()->with('error', 'حداقل دو مدیر باید در سیستم بمانند.');
        }

        $oldRoles = $user->roles->pluck('name')->toArray();
        $user->syncRoles([$validated['role']]);
        
        $this->logger->logUserAssignedToRole($user->email, $validated['role'], auth()->id());

        return back()->with('success', 'نقش کاربر به «' . $validated['role'] . '» تغییر یافت.');
    }

    public function destroy(User $user)
    {
        if ($user->hasRole('admin') && User::role('admin')->count() <= 2) {
            return back()->with('error', 'حداقل دو مدیر باید در سیستم بمانند.');
        }

        if (auth()->id() === $user->id) {
            return abort(403);
        }

        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }

        $this->logger->logDataDelete('users', $user->id, [
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name
        ], auth()->id());

        $user->delete();
        return back()->with('success', 'کاربر حذف شد.');
    }

}
