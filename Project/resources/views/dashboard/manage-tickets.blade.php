@extends('dashboard.index')

@section('title')
    <title>مدیریت تیکت‌ها</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت تیکت‌ها</a>
        </div>

        <h2 class="mb-4">مدیریت تیکت‌ها</h2>

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

        <form method="GET" action="{{ route('dashboard.manage-tickets.index') }}" class="row g-2 mb-4">
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
            <div class="col-lg-4 col-md-4">
                <input type="text" name="message" class="form-control" placeholder="متن تیکت" value="{{ request('message') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <input type="text" name="project_id" class="form-control" placeholder="ID پروژه" value="{{ request('project_id') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <select name="status" class="form-select form-select-sm d-inline-block h-100">
                    <option value="">همه</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>در انتظار بررسی</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>در جریان</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>بسته شده</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <button class="btn btn-primary w-100">جستجو</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>فرستنده</th>
                        <th>گیرنده</th>
                        <th>موضوع</th>
                        <th style="min-width: 150px">متن تیکت</th>
                        <th>ID پروژه</th>
                        <th>تاریخ</th>
                        <th>وضعیت تیکت</th>
                        <th style="min-width: 150px">پاسخ</th>
                        <th>امکانات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr class="text-end">
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->sender->name }}</td>
                            <td>
                                @if($ticket->receiver_id)
                                    {{ $ticket->receiver->name ?? '-' }}
                                @else
                                    {{ $roleNames[$ticket->receiver_role] ?? $ticket->receiver_role }}
                                @endif
                            </td>
                            <td>{{ $ticket->subject }}</td>
                            <td>{!! nl2br(e($ticket->message)) !!}</td>
                            <td>{{ $ticket->project_id ?? '-' }}</td>
                            <td>{{ $ticket->getCreatedAt() }}</td>
                            <td>
                                <form method="POST" action="{{ route('dashboard.manage-tickets.update-status', $ticket->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>در انتظار بررسی</option>
                                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>در جریان</option>
                                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>بسته شده</option>
                                    </select>
                                </form>
                            </td>
                            <td>{{ $ticket->response ?? '-'}}</td>

                            @if ( ! $ticket->deleted_at )
                                <td>
                                    <button class="btn btn-sm btn-outline-primary d-block mb-1" data-bs-toggle="collapse"
                                        data-bs-target="#editResponse{{ $ticket->id }}">
                                        پاسخ به تیکت
                                    </button>

                                    <form method="POST" action="{{ route('dashboard.manage-tickets.destroy', $ticket->id) }}"
                                        class="d-inline" onsubmit="return confirm('آیا از حذف این تیکت مطمئن هستید؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger d-block">حذف</button>
                                    </form>
                                </td>
                            @else
                                <td>
                                    این رکورد حذف شده است.
                                </td>
                            @endif
                        </tr>

                        <tr>
                            <td colspan="10" class="p-0">
                                <div class="collapse container px-4" id="editResponse{{ $ticket->id }}">
                                    <form method="POST" action="{{ route('dashboard.manage-tickets.update-response', $ticket->id) }}" class="row gx-5 gy-2 p-2 mb-3">
                                        @csrf
                                        @method('PATCH')
                                        <label for="ticketResponse{{ $ticket->id }}" class="col-form-label col-md-2">پاسخ به تیکت: </label>
                                        <div>
                                            <input type="text" id="ticketResponse{{ $ticket->id }}" name="response" value="{{ old('ticket_response', $ticket->response) }}" class="form-control">
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-sm btn-success">ثبت</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse"
                                                data-bs-target="#editResponse{{ $ticket->id }}">
                                                انصراف
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="10">هیچ تیکتی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $tickets->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection