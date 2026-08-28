@extends('dashboard.index')

@section('title')
    <title>تیکت‌های من | مرکز آسا</title>
@endsection

@section('dashboard_content')

    <div class="py-4 px-3">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a>
            <span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a>
            <span class="px-1"> > </span>
            <span class="text-muted">تیکت‌های من</span>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">تیکت‌های من</h3>
            <span class="badge bg-primary">{{ $my_tickets->total() }} تیکت</span>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert alert-info mb-3 p-2 small">
            کاربر گرامی، تیکت‌های شما بر اساس اولویت و دسته‌بندی بررسی می‌شوند.
            <span class="d-block mt-1">تیکت‌های با اولویت <strong>زیاد</strong> در اسرع وقت بررسی می‌شوند.</span>
        </div>

        <button class="btn btn-primary btn-sm mb-3" data-bs-toggle="collapse" data-bs-target="#sendTicketForm">
            ارسال تیکت جدید
        </button>

        <div class="collapse mb-3" id="sendTicketForm">
            <div class="card card-body p-3">
                <form method="POST" action="{{ route('dashboard.my-tickets.store') }}">
                    @csrf

                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small">موضوع <span class="text-danger">*</span></label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small">دسته‌بندی</label>
                            <select name="category" class="form-select form-select-sm" required>
                                <option value="">انتخاب...</option>
                                <option value="technical">فنی</option>
                                <option value="financial">مالی</option>
                                <option value="other">سایر</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small">اولویت</label>
                            <select name="priority" class="form-select form-select-sm" required>
                                <option value="">انتخاب...</option>
                                <option value="low">کم</option>
                                <option value="medium">متوسط</option>
                                <option value="high">زیاد</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small">ارسال به</label>
                            <select name="receiver_role" id="receiver_role" class="form-select form-select-sm" required>
                                <option value="">انتخاب...</option>
                                <option value="delegate">پشتیبان پایگاه داده</option>
                                <option value="support">پشتیبان</option>
                                <option value="admin">مدیر</option>
                                <option value="coach">مربی</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="specific_user_container" style="display: none;">
                            <label class="form-label small">انتخاب فرد</label>
                            <select name="specific_user_id" id="specific_user_id" class="form-select form-select-sm">
                                <option value="">ابتدا نقش را انتخاب کنید...</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small">متن تیکت</label>
                            <textarea name="message" rows="3" class="form-control form-control-sm" required>{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-sm">ارسال</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#sendTicketForm">انصراف</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle">
                <thead class="table-dark">
                    <tr class="small">
                        <th>فرستنده</th>
                        <th>گیرنده</th>
                        <th>موضوع</th>
                        <th>دسته</th>
                        <th>اولویت</th>
                        <th>متن</th>
                        <th>تاریخ</th>
                        <th>وضعیت</th>
                        <th>پاسخ</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($my_tickets as $ticket)
                        @php
                            $categories = ['technical'=>'فنی', 'financial'=>'مالی', 'other'=>'سایر'];
                            $priorities = ['low'=>'<span class="badge bg-success">کم</span>', 'medium'=>'<span class="badge bg-warning text-dark">متوسط</span>', 'high'=>'<span class="badge bg-danger">زیاد</span>'];
                            $statuses = ['open'=>'<span class="badge bg-warning text-dark">باز</span>', 'in_progress'=>'<span class="badge bg-info">در جریان</span>', 'closed'=>'<span class="badge bg-success">بسته</span>'];
                            $roleNames = ['admin'=>'مدیر', 'support'=>'پشتیبان', 'delegate'=>'پشتیبان پایگاه داده', 'coach'=>'مربی'];
                            $receiverRole = $ticket->receiver_role ?? ($ticket->receiver ? $ticket->receiver->roles->first()->name ?? null : null);
                        @endphp
                        <tr class="small">
                            <td>{{ auth()->id() === $ticket->sender_id ? $ticket->sender->name : 'شما' }}</td>
                            <td>
                                @if($ticket->receiver_id)
                                    {{ $roleNames[$receiverRole] ?? $ticket->receiver->name ?? 'پشتیبان' }}
                                @else
                                    {{ $roleNames[$ticket->receiver_role] ?? $ticket->receiver_role }}
                                @endif
                            </td>
                            <td>{{ Str::limit($ticket->subject, 30) }}</td>
                            <td>{{ $categories[$ticket->category] ?? $ticket->category }}</td>
                            <td>{!! $priorities[$ticket->priority] ?? '-' !!}</td>
                            <td>{{ Str::limit($ticket->message, 40) }}</td>
                            <td>{{ $ticket->getCreatedAt() }}</td>
                            <td>
                                @php
                                    $canChangeStatus = false;
                                    $user = auth()->user();
                                    $userRoles = $user->roles->pluck('name')->toArray();
                                    
                                    if(in_array('admin', $userRoles)) {
                                        $canChangeStatus = true;
                                    } elseif($ticket->receiver_id && auth()->id() === $ticket->receiver_id) {
                                        $canChangeStatus = true;
                                    } elseif(!$ticket->receiver_id && in_array($ticket->receiver_role, $userRoles)) {
                                        $canChangeStatus = true;
                                    }
                                @endphp
                                
                                @if($canChangeStatus && $ticket->status !== 'closed')
                                    <td>
                                        <form method="POST" action="{{ route('dashboard.my-tickets.update-status', $ticket->id) }}" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                                <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>باز</option>
                                                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>در جریان</option>
                                                <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>بسته</option>
                                            </select>
                                        </form>
                                    </td>
                                @else
                                    <td>{!! $statuses[$ticket->status] !!}</td>
                                @endif
                            </td>
                            <td>{{ Str::limit($ticket->response, 30) ?? '-' }}</td>

                            <td>
                                @php
                                    $canRespond = false;
                                    if(in_array('admin', $userRoles)) {
                                        $canRespond = true;
                                    } elseif($ticket->receiver_id && auth()->id() === $ticket->receiver_id) {
                                        $canRespond = true;
                                    } elseif(!$ticket->receiver_id && in_array($ticket->receiver_role, $userRoles)) {
                                        $canRespond = true;
                                    }
                                @endphp
                                
                                @if($canRespond && $ticket->status !== 'closed')
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#editResponse{{ $ticket->id }}">پاسخ</button>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>

                        @php
                            $canRespond = false;
                            if(in_array('admin', $userRoles)) {
                                $canRespond = true;
                            } elseif($ticket->receiver_id && auth()->id() === $ticket->receiver_id) {
                                $canRespond = true;
                            } elseif(!$ticket->receiver_id && in_array($ticket->receiver_role, $userRoles)) {
                                $canRespond = true;
                            }
                        @endphp
                        
                        @if($canRespond && $ticket->status !== 'closed')
                            <tr class="collapse bg-light" id="editResponse{{ $ticket->id }}">
                                <td colspan="10" class="p-2">
                                    <form method="POST" action="{{ route('dashboard.my-tickets.update-response', $ticket->id) }}" class="row g-1">
                                        @csrf
                                        @method('PATCH')
                                        <div class="col-md-10">
                                            <input type="text" name="response" value="{{ old('response', $ticket->response) }}" class="form-control form-control-sm" placeholder="پاسخ خود را وارد کنید...">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success btn-sm w-100">ارسال</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">هیچ تیکتی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $my_tickets->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection

@section('dashboard_script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var receiverRole = document.getElementById('receiver_role');
    if (receiverRole) {
        receiverRole.addEventListener('change', function() {
            var selectedRole = this.value;
            if (selectedRole === 'coach') {
                fetch('/get-users-by-role?role=' + selectedRole)
                    .then(function(response) { return response.json(); })
                    .then(function(data) {
                        var select = document.getElementById('specific_user_id');
                        select.innerHTML = '<option value="">انتخاب کنید...</option>';
                        data.users.forEach(function(user) {
                            var option = document.createElement('option');
                            option.value = user.id;
                            option.textContent = user.name;
                            select.appendChild(option);
                        });
                        document.getElementById('specific_user_container').style.display = 'block';
                    })
                    .catch(function() {
                        document.getElementById('specific_user_container').style.display = 'none';
                    });
            } else {
                document.getElementById('specific_user_container').style.display = 'none';
            }
        });
    }
});
</script>
@endsection