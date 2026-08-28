@extends('dashboard.index')

@section('title')
    <title>تیکت‌های پروژه</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.my-projects.index') }}">پروژه‌های من</a><span class="px-1"> > </span>
            <a href="#">تیکت‌های پروژه</a>
        </div>

        <h2 class="mb-4">تیکت‌های پروژه</h2>

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

        <button class="btn btn-outline-success mb-3" data-bs-toggle="collapse" data-bs-target="#sendTicketForm">
            ارسال تیکت جدید
        </button>
        <div class="collapse" id="sendTicketForm">
            <form method="POST" action="{{ route('dashboard.my-projects.tickets.store', $project->id) }}" class="row gx-5 gy-2 mb-5">
                @csrf
                <label for="subject" class="col-form-label col-md-2">موضوع: </label>
                <div>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="form-control">
                </div>
                <label for="message" class="col-form-label col-md-2">متن تیکت: </label>
                <div class="form-group">
                    <textarea class="form-control" name="message" rows="2" placeholder="متن تیکت را وارد کنید..." required>{{ old('message') }}</textarea>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">ارسال</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse"
                        data-bs-target="#sendTicketForm">
                        انصراف
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>فرستنده</th>
                        <th>موضوع</th>
                        <th style="min-width: 150px">متن تیکت</th>
                        <th>تاریخ</th>
                        <th>وضعیت تیکت</th>
                        <th style="min-width: 150px">پاسخ</th>
                        <th>امکانات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr class="text-end">
                            <td>{{ $ticket->sender->name }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td>{!! nl2br(e($ticket->message)) !!}</td>
                            <td>{{ $ticket->getCreatedAt() }}</td>

                            @if (auth()->id() === $project->primary_coach_id || auth()->id() === $project->secondary_coach_id)
                                <td>
                                    <form method="POST" action="{{ route('dashboard.my-projects.tickets.update-status', [$project->id, $ticket->id]) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block w-auto">
                                            <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>در انتظار بررسی</option>
                                            <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>در جریان</option>
                                            <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>بسته شده</option>
                                        </select>
                                    </form>
                                </td>
                            @else
                                <td>
                                    {{ $ticket->status === 'open' ? 'در انتظار بررسی' : '' }}
                                    {{ $ticket->status === 'in_progress' ? 'در جریان' : '' }}
                                    {{ $ticket->status === 'closed' ? 'بسته شده' : '' }}
                                </td>
                            @endif

                            <td>{{ $ticket->response ?? '-'}}</td>

                            <td>
                                @if ($ticket->sender_id !== auth()->id())
                                    <button class="btn btn-sm btn-outline-primary d-block mb-1" data-bs-toggle="collapse"
                                        data-bs-target="#editResponse{{ $ticket->id }}">
                                        پاسخ به تیکت
                                    </button>
                                @endif

                                @if(auth()->id() === $project->primary_coach_id || auth()->id() === $project->secondary_coach_id)
                                    
                                    <form method="POST" action="{{ route('dashboard.my-projects.tickets.destroy', [$project->id, $ticket->id]) }}"
                                        class="d-inline" onsubmit="return confirm('آیا از حذف این تیکت مطمئن هستید؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger d-block">حذف</button>
                                    </form>
                                @endif

                                @if (auth()->id() === $project->applicant_id && auth()->id() === $ticket->sender_id)
                                    {{ '-' }}
                                @endif
                            </td>

                        </tr>

                        <tr>
                            <td colspan="7" class="p-0">
                                <div class="collapse container px-4" id="editResponse{{ $ticket->id }}">
                                    <form method="POST" action="{{ route('dashboard.my-projects.tickets.update-response', [$project->id, $ticket->id]) }}" class="row gx-5 gy-2 p-2 mb-3">
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
                            <td colspan="7">هیچ تیکتی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
