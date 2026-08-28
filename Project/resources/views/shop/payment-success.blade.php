@extends('master')

@section('title')
    <title>پرداخت موفق</title>
@endsection

@section('style')
    <style>
        .success-container {
            margin-top: 80px;
            text-align: center;
            padding: 60px 20px;
        }
        .success-icon {
            font-size: 5rem;
            color: #198754;
            margin-bottom: 20px;
        }
        .order-details {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            max-width: 500px;
            margin: 20px auto;
            text-align: right;
        }
    </style>
@endsection

@section('master_content')

    <div class="container success-container">
        <div class="success-icon">✅</div>
        <h2 class="text-success">پرداخت با موفقیت انجام شد</h2>
        <p class="lead">سفارش شما ثبت گردید و می‌توانید مقالات خود را دانلود کنید.</p>

        <div class="order-details">
            <h6>جزئیات سفارش</h6>
            <p><strong>شماره سفارش:</strong> #{{ $order->id }}</p>
            <p><strong>تاریخ پرداخت:</strong> {{ $order->paid_at ? $order->paid_at->format('Y/m/d H:i') : '-' }}</p>
            <p><strong>مبلغ پرداختی:</strong> {{ number_format($order->total_amount) }} تومان</p>
            <p><strong>مقالات خریداری شده:</strong></p>
            <ul>
                @foreach($order->items as $item)
                    <li>{{ $item->article->title ?? '(مقاله حذف شده)' }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mt-4">
            <a href="{{ route('shop.my-orders') }}" class="btn btn-primary">مشاهده سفارشات من</a>
            <a href="{{ route('scientific.articles-international') }}" class="btn btn-secondary">بازگشت به مقالات</a>
        </div>
    </div>

@endsection