@extends('dashboard.index')

@section('title')
    <title>سفارشات من</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <span class="text-muted">سفارشات من</span>
        </div>

        <h2 class="mb-4">سفارشات من</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th># سفارش</th>
                        <th>تاریخ</th>
                        <th>مقالات</th>
                        <th>مبلغ کل</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->paid_at ? $order->paid_at->format('Y/m/d H:i') : $order->created_at->format('Y/m/d H:i') }}</td>
                            <td>
                                @foreach($order->items as $item)
                                    <span class="badge bg-secondary d-inline-block mb-1">
                                        {{ $item->article ? Str::limit($item->article->title, 25) : '(مقاله حذف شده)' }}
                                    </span>
                                @endforeach
                            </td>
                            <td>{{ number_format($order->total_amount) }} تومان</td>
                            <td>
                                <span class="badge {{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('dashboard.order-details', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                    مشاهده جزئیات
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <h4 class="mb-2">شما هیچ سفارشی ندارید</h4>
                                <p class="text-muted">برای خرید مقاله به صفحه مقالات مراجعه کنید.</p>
                                <a href="{{ route('scientific.articles-international') }}" class="btn btn-primary mt-3">
                                    مشاهده مقالات
                                </a>
                            </td>
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