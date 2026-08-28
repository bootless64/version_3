@extends('master')

@section('title')
    <title>سبد خرید</title>
@endsection

@section('style')
    <style>
        .cart-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 0;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .cart-total {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .empty-cart {
            padding: 60px 0;
            text-align: center;
        }
    </style>
@endsection

@section('master_content')

    <div class="container py-5" style="margin-top: 60px;">
        <h2 class="mb-4">سبد خرید</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        @if($order && $order->items->count() > 0)
            <div class="card">
                <div class="card-body">
                    @foreach($order->items as $item)
                        <div class="cart-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $item->article->title ?? '(مقاله حذف شده)' }}</h6>
                                <p class="small text-muted mb-0">
                                    نویسندگان: {{ $item->article->authors ?? '-' }}
                                </p>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="fw-bold">{{ number_format($item->price) }} تومان</span>
                                <form method="POST" action="{{ route('shop.remove-from-cart', $item->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                        <span class="cart-total">مجموع: {{ number_format($order->total_amount) }} تومان</span>
                        <a href="{{ route('shop.checkout') }}" class="btn btn-success btn-lg">
                            تسویه حساب
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <h4>سبد خرید شما خالی است</h4>
                <p class="text-muted">برای افزودن مقاله به سبد خرید، به صفحه مقالات بروید.</p>
                <a href="{{ route('scientific.articles-international') }}" class="btn btn-primary mt-3">
                    مشاهده مقالات
                </a>
            </div>
        @endif
    </div>

@endsection