@extends('dashboard.index')

@section('title')
    <title>جزئیات سفارش #{{ $order->id }}</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            @if(auth()->user()->can('manage_orders'))
                <a href="{{ route('dashboard.manage-orders.index') }}">مدیریت سفارشات</a><span class="px-1"> > </span>
            @else
                <a href="{{ route('dashboard.my-orders') }}">سفارشات من</a><span class="px-1"> > </span>
            @endif
            <span class="text-muted">جزئیات سفارش #{{ $order->id }}</span>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">جزئیات سفارش #{{ $order->id }}</h2>
            <span class="badge {{ $order->status_badge_class }} fs-6 p-2">
                {{ $order->status_label }}
            </span>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">اطلاعات سفارش</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>شماره سفارش:</strong> #{{ $order->id }}</p>
                                <p><strong>تاریخ ثبت:</strong> {{ $order->created_at->format('Y/m/d H:i') }}</p>
                                @if($order->paid_at)
                                    <p><strong>تاریخ پرداخت:</strong> {{ $order->paid_at->format('Y/m/d H:i') }}</p>
                                @endif
                                <p><strong>مبلغ کل:</strong> {{ number_format($order->total_amount) }} تومان</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>نام خریدار:</strong> {{ $order->buyer_name }}</p>
                                <p><strong>ایمیل:</strong> {{ $order->buyer_email }}</p>
                                <p><strong>شماره تماس:</strong> {{ $order->buyer_phone }}</p>
                                <p><strong>روش پرداخت:</strong> {{ $order->payment_method ?? '-' }}</p>
                            </div>
                        </div>
                        @if($order->admin_note)
                            <div class="mt-2 p-2 bg-light rounded">
                                <strong>یادداشت مدیریت:</strong>
                                <p class="mb-0">{{ $order->admin_note }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">مقالات سفارش</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>عنوان مقاله</th>
                                        <th>نویسندگان</th>
                                        <th>قیمت</th>
                                        <th>دانلود</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->article->title ?? '(مقاله حذف شده)' }}</td>
                                            <td>{{ Str::limit($item->article->authors ?? '-', 30) }}</td>
                                            <td>{{ number_format($item->price) }} تومان</td>
                                            <td>
                                                @if($order->status === 'paid')
                                                    @if($item->article)
                                                        <a href="{{ route('shop.download-purchased', $item->article->id) }}" 
                                                           class="btn btn-sm btn-success">
                                                            دانلود
                                                        </a>
                                                    @else
                                                        <span class="text-muted">فایل موجود نیست</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">پرداخت نشده</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">مجموع:</td>
                                        <td colspan="2" class="fw-bold">{{ number_format($order->total_amount) }} تومان</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                @can('manage_orders')
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">مدیریت سفارش</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('dashboard.manage-orders.update-status', $order->id) }}">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label class="form-label">تغییر وضعیت</label>
                                    <select name="status" class="form-select">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>در انتظار پرداخت</option>
                                        <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>پرداخت شده</option>
                                        <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }}>ناموفق</option>
                                        <option value="expired" {{ $order->status === 'expired' ? 'selected' : '' }}>منقضی شده</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">یادداشت</label>
                                    <textarea name="admin_note" class="form-control" rows="3">{{ $order->admin_note }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">به‌روزرسانی وضعیت</button>
                            </form>
                            <hr>
                            <form method="POST" action="{{ route('dashboard.manage-orders.destroy', $order->id) }}"
                                onsubmit="return confirm('آیا از حذف این سفارش مطمئن هستید؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">حذف سفارش</button>
                            </form>
                        </div>
                    </div>
                @endcan

                <div class="mt-3">
                    @can('manage_orders')
                        <a href="{{ route('dashboard.manage-orders.index') }}" class="btn btn-secondary w-100">
                            بازگشت به لیست سفارشات
                        </a>
                    @else
                        <a href="{{ route('dashboard.my-orders') }}" class="btn btn-secondary w-100">
                            بازگشت به سفارشات من
                        </a>
                    @endcan
                </div>
            </div>
        </div>

    </div>

@endsection