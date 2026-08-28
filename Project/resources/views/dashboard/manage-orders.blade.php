@extends('dashboard.index')

@section('title')
    <title>مدیریت سفارشات</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت سفارشات</a>
        </div>

        <h2 class="mb-4">مدیریت سفارشات</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('dashboard.manage-orders.index') }}" class="row g-2 mb-4">
            <div class="col-lg-2 col-md-4">
                <input type="text" name="id" class="form-control" placeholder="شماره سفارش" value="{{ request('id') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <input type="text" name="buyer_name" class="form-control" placeholder="نام خریدار" value="{{ request('buyer_name') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <select name="status" class="form-select">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>در انتظار پرداخت</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>پرداخت شده</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>ناموفق</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>منقضی شده</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <input type="date" name="date_from" class="form-control" placeholder="از تاریخ" value="{{ request('date_from') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <input type="date" name="date_to" class="form-control" placeholder="تا تاریخ" value="{{ request('date_to') }}">
            </div>
            <div class="col-lg-1 col-md-4">
                <button class="btn btn-primary w-100">جستجو</button>
            </div>
            <div class="col-lg-1 col-md-4">
                <a href="{{ route('dashboard.manage-orders.index') }}" class="btn btn-secondary w-100">پاک</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th># سفارش</th>
                        <th>خریدار</th>
                        <th>تعداد مقالات</th>
                        <th>مبلغ کل</th>
                        <th>تاریخ</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->buyer_name }}</td>
                            <td>{{ $order->items->count() }}</td>
                            <td>{{ number_format($order->total_amount) }} تومان</td>
                            <td>{{ $order->created_at->format('Y/m/d H:i') }}</td>
                            <td>
                                <span class="badge {{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <a href="{{ route('dashboard.order-details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        مشاهده
                                    </a>
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#updateStatusModal{{ $order->id }}">
                                        تغییر وضعیت
                                    </button>
                                    <form method="POST" action="{{ route('dashboard.manage-orders.destroy', $order->id) }}"
                                        onsubmit="return confirm('آیا از حذف این سفارش مطمئن هستید؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="updateStatusModal{{ $order->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">تغییر وضعیت سفارش #{{ $order->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('dashboard.manage-orders.update-status', $order->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">وضعیت جدید</label>
                                                <select name="status" class="form-select">
                                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>در انتظار پرداخت</option>
                                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>پرداخت شده</option>
                                                    <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }}>ناموفق</option>
                                                    <option value="expired" {{ $order->status === 'expired' ? 'selected' : '' }}>منقضی شده</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">یادداشت مدیریت</label>
                                                <textarea name="admin_note" class="form-control" rows="2" placeholder="یادداشت خود را وارد کنید...">{{ $order->admin_note }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                            <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">هیچ سفارشی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection