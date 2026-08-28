@extends('master')

@section('title')
    <title>پرداخت ناموفق</title>
@endsection

@section('style')
    <style>
        .failed-container {
            margin-top: 80px;
            text-align: center;
            padding: 60px 20px;
        }
        .failed-icon {
            font-size: 5rem;
            color: #dc3545;
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

    <div class="container failed-container">
        <div class="failed-icon">❌</div>
        <h2 class="text-danger">پرداخت ناموفق</h2>
        <p class="lead">متأسفانه پرداخت شما با مشکل مواجه شد.</p>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="order-details">
            <h6>جزئیات سفارش</h6>
            <p><strong>شماره سفارش:</strong> #{{ $order->id }}</p>
            <p><strong>مبلغ:</strong> {{ number_format($order->total_amount) }} تومان</p>
            <p><strong>وضعیت:</strong> <span class="text-danger">ناموفق</span></p>
        </div>

        <div class="mt-4">
            <a href="{{ route('shop.cart') }}" class="btn btn-warning">بازگشت به سبد خرید</a>
            <a href="{{ route('scientific.articles-international') }}" class="btn btn-secondary">بازگشت به مقالات</a>
        </div>
    </div>

@endsection