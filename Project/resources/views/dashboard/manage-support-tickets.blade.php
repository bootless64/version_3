@extends('dashboard.index')

@section('title')
    <title>مدیریت تیکت‌های پشتیبانی</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت تیکت‌های پشتیبانی</a>
        </div>

        <h2 class="mb-4">مدیریت تیکت‌های پشتیبانی</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
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

        @php
            $roleNames = ['admin'=>'مدیر', 'support'=>'پشتیبان', 'delegate'=>'پشتیبان پایگاه داده', 'coach'=>'مربی'];
        @endphp

        <button class="btn btn-outline-success mb-3" data-bs-toggle="collapse" data-bs-target="#sendTicketForm">
            ارسال تیکت جدید
        </button>

        <div class="collapse" id="sendTicketForm">
            <form method="POST" action="{{ route('dashboard.manage-support-tickets.store') }}" class="row gx-5 gy-2 mb-5 p-3 border rounded">
                @csrf

                <div class="col-md-6 mb-3">
                    <label for="receiver_role" class="form-label">ارسال به نقش: <span class="text-danger">*</span></label>
                    <select name="receiver_role" id="receiver_role" class="form-control" required>
                        <option value="">انتخاب کنید...</option>
                        <option value="delegate" {{ old('receiver_role') == 'delegate' ? 'selected' : '' }}>پشتیبان پایگاه داده</option>
                        <option value="support" {{ old('receiver_role') == 'support' ? 'selected' : '' }}>پشتیبان</option>
                        <option value="admin" {{ old('receiver_role') == 'admin' ? 'selected' : '' }}>مدیر</option>
                        <option value="coach" {{ old('receiver_role') == 'coach' ? 'selected' : '' }}>مربی / استاد</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3" id="specific_user_container" style="display: none;">
                    <label for="specific_user_id" class="form-label">انتخاب فرد: <span class="text-danger">*</span></label>
                    <select name="specific_user_id" id="specific_user_id" class="form-control">
                        <option value="">ابتدا نقش را انتخاب کنید...</option>
                    </select>
                    <small class="text-muted">برای نقش مربی، یک فرد خاص انتخاب کنید.</small>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="category" class="form-label">دسته‌بندی: <span class="text-danger">*</span></label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">انتخاب کنید...</option>
                        <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>فنی</option>
                        <option value="financial" {{ old('category') == 'financial' ? 'selected' : '' }}>مالی</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>سایر</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="priority" class="form-label">اولویت: <span class="text-danger">*</span></label>
                    <select name="priority" id="priority" class="form-control" required>
                        <option value="">انتخاب کنید...</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>کم</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>متوسط</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>زیاد</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="subject" class="form-label">موضوع: <span class="text-danger">*</span></label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="form-control" required>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="message" class="form-label">متن تیکت: <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="message" rows="3" placeholder="متن تیکت را وارد کنید..." required>{{ old('message') }}</textarea>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">ارسال تیکت</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#sendTicketForm">
                        انصراف
                    </button>
                </div>
            </form>
        </div>

        <div class="card mb-4 p-3">
            <h6 class="mb-3">فیلتر و جستجو</h6>
            <form method="GET" action="{{ route('dashboard.manage-support-tickets.index') }}" class="row g-2">
                <div class="col-lg-2 col-md-4">
                    <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <input type="text" name="sender_name" class="form-control" placeholder="نام فرستنده" value="{{ request('sender_name') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <input type="text" name="receiver_name" class="form-control" placeholder="نام گیرنده" value="{{ request('receiver_name') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <input type="text" name="subject" class="form-control" placeholder="موضوع" value="{{ request('subject') }}">
                </div>
                <div class="col-lg-3 col-md-4">
                    <input type="text" name="message" class="form-control" placeholder="متن تیکت" value="{{ request('message') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <select name="category" class="form-select">
                        <option value="">همه دسته‌بندی‌ها</option>
                        <option value="technical" {{ request('category') === 'technical' ? 'selected' : '' }}>فنی</option>
                        <option value="financial" {{ request('category') === 'financial' ? 'selected' : '' }}>مالی</option>
                        <option value="other" {{ request('category') === 'other' ? 'selected' : '' }}>سایر</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4">
                    <select name="priority" class="form-select">
                        <option value="">همه اولویت‌ها</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>کم</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>متوسط</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>زیاد</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4">
                    <select name="status" class="form-select">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>در انتظار بررسی</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>در جریان</option>
                        <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>بسته شده</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4">
                    <button class="btn btn-primary w-100">جستجو</button>
                </div>
                <div class="col-lg-2 col-md-4">
                    <a href="{{ route('dashboard.manage-support-tickets.index') }}" class="btn btn-secondary w-100">پاک کردن فیلترها</a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>فرستنده</th>
                        <th>گیرنده</th>
                        <th>موضوع</th>
                        <th>دسته‌بندی</th>
                        <th>اولویت</th>
                        <th style="min-width: 150px">متن تیکت</th>
                        <th>تاریخ</th>
                        <th>وضعیت</th>
                        <th style="min-width: 150px">پاسخ</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        @php
                            $categories = [
                                'technical' => 'فنی',
                                'financial' => 'مالی',
                                'other' => 'سایر'
                            ];
                            $priorities = [
                                'low' => 'کم',
                                'medium' => 'متوسط',
                                'high' => 'زیاد'
                            ];
                            $statuses = [
                                'open' => 'در انتظار بررسی',
                                'in_progress' => 'در جریان',
                                'closed' => 'بسته شده'
                            ];
                        @endphp
                        <tr class="text-end">
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->sender->name ?? '-' }}</td>
                            <td>
                                @if($ticket->receiver_id)
                                    {{ $ticket->receiver->name ?? 'تعیین نشده' }}
                                @else
                                    {{ $roleNames[$ticket->receiver_role] ?? $ticket->receiver_role }}
                                @endif
                            </td>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ $categories[$ticket->category] ?? $ticket->category }}</td>
                            <td>
                                @if($ticket->priority == 'high')
                                    <span class="badge bg-danger">{{ $priorities[$ticket->priority] }}</span>
                                @elseif($ticket->priority == 'medium')
                                    <span class="badge bg-warning text-dark">{{ $priorities[$ticket->priority] }}</span>
                                @else
                                    <span class="badge bg-success">{{ $priorities[$ticket->priority] }}</span>
                                @endif
                            </td>
                            <td>{!! nl2br(e(Str::limit($ticket->message, 50))) !!}</td>
                            <td>{{ $ticket->getCreatedAt() }}</td>
                            <td>
                                <form method="POST" action="{{ route('dashboard.manage-support-tickets.update-status', $ticket->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>در انتظار بررسی</option>
                                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>در جریان</option>
                                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>بسته شده</option>
                                    </select>
                                </form>
                            </td>
                            <td>{{ Str::limit($ticket->response, 30) ?? '-' }}</td>

                            <td>
                                <button class="btn btn-sm btn-outline-info w-100 mb-1" data-bs-toggle="collapse" data-bs-target="#editResponse{{ $ticket->id }}">
                                    پاسخ
                                </button>
                                <form method="POST" action="{{ route('dashboard.manage-support-tickets.destroy', $ticket->id) }}" 
                                      class="d-inline w-100" onsubmit="return confirm('آیا از حذف این تیکت مطمئن هستید؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100">حذف</button>
                                </form>
                            </td>
                        </tr>

                        <tr class="collapse" id="editResponse{{ $ticket->id }}">
                            <td colspan="11" class="p-3 bg-light">
                                <form method="POST" action="{{ route('dashboard.manage-support-tickets.update-response', $ticket->id) }}" class="row g-2">
                                    @csrf
                                    @method('PATCH')
                                    <div class="col-md-10">
                                        <input type="text" name="response" value="{{ old('response', $ticket->response) }}" class="form-control" placeholder="پاسخ خود را وارد کنید...">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-success w-100">ارسال پاسخ</button>
                                    </div>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-5">
                                <div class="alert alert-info mb-0">هیچ تیکتی یافت نشد.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $tickets->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection

@section('dashboard_script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#receiver_role').on('change', function() {
        var selectedRole = $(this).val();

        if (selectedRole === 'coach') {
            $.ajax({
                url: '/get-users-by-role?role=' + selectedRole,
                type: 'GET',
                success: function(data) {
                    var $select = $('#specific_user_id');
                    $select.empty();
                    $select.append('<option value="">انتخاب کنید...</option>');

                    $.each(data.users, function(key, user) {
                        $select.append('<option value="' + user.id + '">' + user.name + '</option>');
                    });

                    $('#specific_user_container').show();
                },
                error: function() {
                    $('#specific_user_container').hide();
                    alert('خطا در دریافت لیست کاربران');
                }
            });
        } else {
            $('#specific_user_container').hide();
            $('#specific_user_id').val('');
        }
    });
});
</script>
@endsection