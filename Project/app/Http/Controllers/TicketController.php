<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Services\LoggingService;

class TicketController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }
    public function manageTickets(Request $request)
    {
        $query = Ticket::query();

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }
        if ($request->filled('sender_name')) {
            $query->whereHas('sender', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->sender_name . '%');
            });
        }
        if ($request->filled('receiver_name')) {
            $query->whereHas('receiver', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->receiver_name . '%');
            });
        }
        if ($request->filled('subject')) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }
        if ($request->filled('message')) {
            $query->where('message', 'like', '%' . $request->message . '%');
        }
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $tickets = $query->withTrashed()->orderBy('created_at', 'desc')->paginate(25)
            ->appends($request->only(['id', 'sender_name', 'subject', 'message', 'project_id', 'status']));

        return view('dashboard.manage-tickets', compact('tickets'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $ticket = Ticket::findOrFail($id);

        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();

        if (in_array('admin', $userRoles)) {
            $ticket->status = $validated['status'];
            $ticket->save();
            return back()->with('success', 'وضعیت تیکت با موفقیت تغییر کرد.');
        }

        if (auth()->id() === $ticket->sender_id) {
            return abort(403, 'شما نمی‌توانید وضعیت تیکت خودتان را تغییر دهید.');
        }

        if ($ticket->receiver_id) {
            if (auth()->id() !== $ticket->receiver_id) {
                return abort(403, 'شما دسترسی به تغییر وضعیت این تیکت را ندارید.');
            }
        } else {
            if (!in_array($ticket->receiver_role, $userRoles)) {
                return abort(403, 'شما دسترسی به تغییر وضعیت این تیکت را ندارید.');
            }
        }

        $ticket->status = $validated['status'];
        $ticket->save();

        return back()->with('success', 'وضعیت تیکت با موفقیت تغییر کرد.');
    }

    public function updateResponse(Request $request, $id)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:500',
        ]);

        $ticket = Ticket::findOrFail($id);

        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();

        if (in_array('admin', $userRoles)) {
            $ticket->response = $validated['response'];
            $ticket->save();
            return back()->with('success', 'پاسخ با موفقیت ثبت شد.');
        }

        if (auth()->id() === $ticket->sender_id) {
            return abort(403, 'شما نمی‌توانید به تیکت خودتان پاسخ دهید.');
        }

        if ($ticket->receiver_id) {
            if (auth()->id() !== $ticket->receiver_id) {
                return abort(403, 'شما دسترسی به پاسخگویی این تیکت را ندارید.');
            }
        } else {
            if (!in_array($ticket->receiver_role, $userRoles)) {
                return abort(403, 'شما دسترسی به پاسخگویی این تیکت را ندارید.');
            }
        }

        $ticket->response = $validated['response'];
        $ticket->save();

        return back()->with('success', 'پاسخ با موفقیت ثبت شد.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        $this->logger->logDataDelete('tickets', $ticket->id, [
            'ticket_id' => $ticket->id,
            'subject' => $ticket->subject,
            'sender_id' => $ticket->sender_id,
            'status' => $ticket->status,
        ], auth()->id());

        $ticket->delete();
        return back()->with('success', 'تیکت حذف شد.');
    }

    public function manageSupportTickets(Request $request)
    {
        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();

        $query = Ticket::query()->where('project_id', null);

        if (!in_array('admin', $userRoles)) {
            $query->where(function ($q) use ($user, $userRoles) {
                $q->where('receiver_id', $user->id)
                  ->orWhere(function ($q2) use ($userRoles) {
                      $q2->whereNull('receiver_id')
                         ->whereIn('receiver_role', $userRoles);
                  });
            });
        }

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('sender_name')) {
            $query->whereHas('sender', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->sender_name . '%');
            });
        }

        if ($request->filled('receiver_name')) {
            $query->whereHas('receiver', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->receiver_name . '%');
            });
        }

        if ($request->filled('subject')) {
            $query->where('subject', 'like', '%' . $request->subject . '%');
        }

        if ($request->filled('message')) {
            $query->where('message', 'like', '%' . $request->message . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('receiver_role')) {
            $query->where('receiver_role', $request->receiver_role);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(25)
            ->appends($request->only([
                'id',
                'sender_name',
                'receiver_name',
                'subject',
                'message',
                'status',
                'category',
                'priority',
                'receiver_role'
            ]));

        return view('dashboard.manage-support-tickets', compact('tickets'));
    }

    public function storeSupportTicket(Request $request)
    {
        $validated = $request->validate([
            'receiver_role' => 'required|in:admin,support,coach,delegate',
            'specific_user_id' => 'nullable|exists:users,id',
            'subject' => 'required|string|max:50',
            'message' => 'required|string|max:500',
            'category' => 'required|in:technical,financial,other',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket = new Ticket();

        $ticket->sender_id = auth()->id();
        $ticket->subject = $validated['subject'];
        $ticket->message = $validated['message'];
        $ticket->status = 'open';
        $ticket->category = $validated['category'];
        $ticket->priority = $validated['priority'];
        $ticket->receiver_role = $validated['receiver_role'];

        if ($request->receiver_role === 'coach' && $request->filled('specific_user_id')) {
            $ticket->receiver_id = $request->specific_user_id;
        } else {
            $ticket->receiver_id = null;
        }

        $ticket->save();

        $this->logger->logDataCreate('support_tickets', $ticket->id, [
            'ticket_id' => $ticket->id,
            'subject' => $ticket->subject,
            'category' => $ticket->category,
            'priority' => $ticket->priority,
        ], auth()->id());

        return back()->with('success', 'تیکت با موفقیت ارسال شد.');
    }

    public function updateSupportTicketStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'in:open,in_progress,closed',
        ]);

        $ticket = Ticket::where('project_id', null)->findOrFail($id);

        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();

        if (in_array('admin', $userRoles)) {
            $ticket->status = $validated['status'];
            $ticket->save();
            return back()->with('success', 'وضعیت تیکت به‌روزرسانی شد.');
        }

        if (auth()->id() === $ticket->sender_id) {
            return abort(403, 'شما نمی‌توانید وضعیت تیکت خودتان را تغییر دهید.');
        }

        if ($ticket->receiver_id) {
            if (auth()->id() !== $ticket->receiver_id) {
                return abort(403, 'شما دسترسی به تغییر وضعیت این تیکت را ندارید.');
            }
        } else {
            if (!in_array($ticket->receiver_role, $userRoles)) {
                return abort(403, 'شما دسترسی به تغییر وضعیت این تیکت را ندارید.');
            }
        }

        $ticket->status = $validated['status'];
        $ticket->save();

        return back()->with('success', 'وضعیت تیکت به‌روزرسانی شد.');
    }

    public function updateSupportTicketResponse(Request $request, $id)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:500',
        ]);

        $ticket = Ticket::where('project_id', null)->findOrFail($id);

        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();

        if (in_array('admin', $userRoles)) {
            $ticket->response = $validated['response'];
            $ticket->save();
            return back()->with('success', 'پاسخ با موفقیت ثبت شد.');
        }

        if (auth()->id() === $ticket->sender_id) {
            return abort(403, 'شما نمی‌توانید به تیکت خودتان پاسخ دهید.');
        }

        if ($ticket->receiver_id) {
            if (auth()->id() !== $ticket->receiver_id) {
                return abort(403, 'شما دسترسی به پاسخگویی این تیکت را ندارید.');
            }
        } else {
            if (!in_array($ticket->receiver_role, $userRoles)) {
                return abort(403, 'شما دسترسی به پاسخگویی این تیکت را ندارید.');
            }
        }

        $ticket->response = $validated['response'];
        $ticket->save();
        return back()->with('success', 'پاسخ با موفقیت ثبت شد.');
    }

    public function destroySupportTicket($id)
    {
        $ticket = Ticket::where('project_id', null)->findOrFail($id);

        $this->logger->logDataDelete('support_tickets', $ticket->id, [
            'ticket_id' => $ticket->id,
            'subject' => $ticket->subject,
            'sender_id' => $ticket->sender_id,
            'status' => $ticket->status,
        ], auth()->id());

        $ticket->delete();

        return back()->with('success', 'تیکت حذف شد.');
    }

    public function storeProjectTicket(Request $request, $project_id)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:50',
            'message' => 'required|string|max:500',
        ]);

        $ticket = new Ticket();

        $ticket->sender_id = auth()->id();
        $ticket->project_id = $project_id;
        $ticket->subject = $validated['subject'];
        $ticket->message = $validated['message'];
        $ticket->status = 'open';

        $ticket->save();

        return back()->with('success', 'تیکت شما ثبت شد و بررسی خواهد شد. برای پیگیری وضعیت تیکت می‌توانید به همین صفحه مراجعه کنید.');
    }

    public function updateProjectTicketStatus(Request $request, $project_id, $ticket_id)
    {
        $validated = $request->validate([
            'status' => 'in:open,in_progress,closed',
        ]);

        $ticket = Ticket::findOrFail($ticket_id);

        if (auth()->id() === $ticket->project->primary_coach_id || auth()->id() === $ticket->project->secondary_coach_id) {
            $ticket->status = $validated['status'];
            $ticket->save();
            return back()->with('success', 'وضعیت تیکت به‌روزرسانی شد.');
        }
        return abort(403);
    }

    public function updateProjectTicketResponse(Request $request, $project_id, $ticket_id)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:500',
        ]);

        $ticket = Ticket::findOrFail($ticket_id);

        if (auth()->id() === $ticket->sender_id) {
            return abort(403);
        }

        $ticket->response = $validated['response'];
        $ticket->save();
        return back()->with('success', 'پاسخ با موفقیت ثبت شد.');
    }

    public function destroyProjectTicket($project_id, $ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);

        if (auth()->id() === $ticket->project->primary_coach_id || auth()->id() === $ticket->project->secondary_coach_id)

            $ticket->delete();

        return back()->with('success', 'تیکت حذف شد.');
    }

    public function myTickets()
    {
        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();

        $my_tickets = Ticket::where(function ($q) use ($user, $userRoles) {
            $q->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orWhere(function ($q2) use ($userRoles) {
                $q2->whereNull('receiver_id')
                    ->whereIn('receiver_role', $userRoles);
            });

            if (in_array('admin', $userRoles)) {
                $q->orWhere('receiver_role', 'admin');
            }
        })->where('project_id', null)->latest()->paginate(25);

        $supportUsers = User::role('support')->get();

        return view('dashboard.my-tickets', compact('my_tickets', 'supportUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:50',
            'message' => 'required|string|max:500',
            'receiver_role' => 'required|in:admin,support,coach,delegate',
            'specific_user_id' => 'nullable|exists:users,id',
            'category' => 'required|in:technical,financial,support,content,other',
            'priority' => 'required|in:low,medium,high',
        ]);

        $ticket = new Ticket();

        $ticket->sender_id = auth()->id();
        $ticket->subject = $validated['subject'];
        $ticket->message = $validated['message'];
        $ticket->status = 'open';
        $ticket->category = $validated['category'];
        $ticket->priority = $validated['priority'];
        $ticket->receiver_role = $validated['receiver_role'];

        if ($request->receiver_role === 'coach' && $request->filled('specific_user_id')) {
            $ticket->receiver_id = $request->specific_user_id;
        } else {
            $ticket->receiver_id = null;
        }

        $ticket->save();

        $this->logger->logDataCreate('tickets', $ticket->id, [
            'ticket_id' => $ticket->id,
            'subject' => $ticket->subject,
            'category' => $ticket->category,
            'priority' => $ticket->priority,
            'receiver_role' => $ticket->receiver_role,
        ], auth()->id());

        return back()->with('success', 'تیکت شما با موفقیت ارسال شد.');
    }

    private function getRoleName($role)
    {
        $roles = [
            'admin' => 'مدیر',
            'support' => 'پشتیبان',
            'delegate' => 'پشتیبان پایگاه داده',
            'coach' => 'استاد/مربی'
        ];
        return $roles[$role] ?? $role;
    }

    public function updateMyTicketResponse(Request $request, $id)
    {
        $validated = $request->validate([
            'response' => 'required|string|max:500',
        ]);

        $ticket = Ticket::where('project_id', null)->findOrFail($id);

        $user = auth()->user();
        $userRoles = $user->roles->pluck('name')->toArray();

        if (in_array('admin', $userRoles)) {
            $ticket->response = $validated['response'];
            $ticket->save();
            return back()->with('success', 'پاسخ شما با موفقیت ثبت شد.');
        }

        if (auth()->id() === $ticket->sender_id) {
            return abort(403, 'شما نمی‌توانید به تیکت خودتان پاسخ دهید.');
        }

        if ($ticket->receiver_id) {
            if (auth()->id() !== $ticket->receiver_id) {
                return abort(403, 'شما دسترسی به پاسخگویی این تیکت را ندارید.');
            }
        } else {
            if (!in_array($ticket->receiver_role, $userRoles)) {
                return abort(403, 'شما دسترسی به پاسخگویی این تیکت را ندارید.');
            }
        }

        $ticket->response = $validated['response'];
        $ticket->save();

        return back()->with('success', 'پاسخ شما با موفقیت ثبت شد.');
    }

    public function getUsersByRole(Request $request)
    {
        $role = $request->get('role');

        if ($role === 'coach') {
            $users = User::whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            })->get(['id', 'name']);
        } else {
            $users = collect();
        }

        return response()->json(['users' => $users]);
    }
}