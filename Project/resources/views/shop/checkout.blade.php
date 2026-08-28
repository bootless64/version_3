@extends('master')

@section('title')
    <title>تسویه حساب</title>
@endsection

@section('style')
    <style>
        .checkout-container {
            margin-top: 60px;
        }
        .order-summary {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
        }
        .order-summary .item {
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }
        .order-summary .item:last-child {
            border-bottom: none;
        }
        .total-amount {
            font-size: 1.3rem;
            font-weight: bold;
            color: #198754;
        }
        .terms-check {
            margin-top: 15px;
        }
    </style>
@endsection

@section('master_content')

    <div class="container checkout-container py-4">
        <h2 class="mb-4">تسویه حساب</h2>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">اطلاعات خریدار</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('shop.process-payment') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">نام و نام خانوادگی <span class="text-danger">*</span></label>
                                <input type="text" name="buyer_name" value="{{ old('buyer_name', auth()->user()->name) }}" 
                                       class="form-control" required>
                                @error('buyer_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ایمیل <span class="text-danger">*</span></label>
                                <input type="email" name="buyer_email" value="{{ old('buyer_email', auth()->user()->email) }}" 
                                       class="form-control" required>
                                @error('buyer_email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">شماره تماس <span class="text-danger">*</span></label>
                                <input type="tel" name="buyer_phone" value="{{ old('buyer_phone', auth()->user()->mobile_number) }}" 
                                       class="form-control" required>
                                @error('buyer_phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 terms-check">
                                <div class="form-check">
                                    <input type="checkbox" name="terms_accepted" class="form-check-input" id="terms" value="1" required>
                                    <label class="form-check-label" for="terms">
                                        با <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">قوانین سایت</a> موافقم
                                        <span class="text-danger">*</span>
                                    </label>
                                    @error('terms_accepted')
                                        <br><small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 mt-3">
                                پرداخت {{ number_format($order->total_amount) }} تومان
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="order-summary">
                    <h5 class="mb-3">خلاصه سفارش</h5>
                    
                    @foreach($order->items as $item)
                        <div class="item d-flex justify-content-between">
                            <span>{{ Str::limit($item->article->title ?? '(مقاله حذف شده)', 40) }}</span>
                            <span>{{ number_format($item->price) }} تومان</span>
                        </div>
                    @endforeach

                    <div class="mt-3 pt-3 border-top d-flex justify-content-between">
                        <span class="fw-bold">مجموع:</span>
                        <span class="total-amount">{{ number_format($order->total_amount) }} تومان</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="termsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">قوانین سایت</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h6>قوانین خرید و دانلود مقالات</h6>
                    <ol>
                        <li>پس از خرید موفق، مقاله به صورت نامحدود برای شما قابل دانلود خواهد بود.</li>
                        <li>امکان انتقال مقاله به شخص دیگر وجود ندارد.</li>
                        <li>در صورت بروز مشکل در دانلود، با پشتیبانی تماس بگیرید.</li>
                        <li>قیمت مقالات بر اساس تعیین مدیر سایت می‌باشد.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>

@endsection