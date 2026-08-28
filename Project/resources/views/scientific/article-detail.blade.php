@extends('master')

@section('title')
    <title>{{ $article->title }} | مرکز آسا</title>
@endsection

@section('meta')
    <meta name="description" content="{{ Str::limit($article->description ?? $article->keywords, 150) }}">
@endsection

@section('style')
    <style>
        .page-header {
            background: linear-gradient(135deg, #0d1b2a, #1b3a5c, #2d6a9f);
            color: white;
            padding: 60px 0 40px;
        }
        .content-section {
            padding: 40px 0;
        }
        .article-detail-card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 30px;
            background: white;
        }
        .article-detail-card .meta-item {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .article-detail-card .meta-item:last-child {
            border-bottom: none;
        }
        .article-detail-card .meta-label {
            font-weight: bold;
            color: #333;
            display: inline-block;
            min-width: 120px;
        }
        .article-detail-card .meta-value {
            color: #555;
        }
        .article-keywords {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .article-keywords .keyword {
            background: #f0f0f0;
            padding: 4px 14px;
            border-radius: 15px;
            font-size: 0.85rem;
            color: #555;
        }
        .badge-type {
            padding: 5px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .badge-national {
            background: #d4edda;
            color: #155724;
        }
        .badge-international {
            background: #cce5ff;
            color: #004085;
        }
        .article-description {
            line-height: 1.8;
            color: #333;
            text-align: justify;
        }
        .download-btn {
            padding: 10px 25px;
            border-radius: 8px;
        }

        .pdf-viewer-container {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
            background: #f8f9fa;
            min-height: 300px;
            position: relative;
        }
        .pdf-viewer-container embed,
        .pdf-viewer-container object,
        .pdf-viewer-container iframe {
            width: 100%;
            height: 600px;
            border: none;
            display: block;
        }
        .pdf-viewer-container .pdf-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            color: #6c757d;
            padding: 40px;
            text-align: center;
        }
        .pdf-viewer-container .pdf-placeholder .icon {
            font-size: 4rem;
            margin-bottom: 15px;
        }

        .pdf-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            color: #6c757d;
            font-size: 1.1rem;
        }

        .price-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }
        .price-free {
            color: #198754;
            font-size: 1.1rem;
            font-weight: bold;
        }
        .price-paid {
            color: #0d6efd;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .modal-cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease;
        }
        .modal-cart-overlay.show {
            display: flex;
        }
        .modal-cart-box {
            background: white;
            border-radius: 16px;
            padding: 40px 50px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: scaleIn 0.3s ease;
        }
        .modal-cart-box .icon {
            font-size: 4rem;
            margin-bottom: 10px;
        }
        .modal-cart-box h4 {
            color: #28a745;
            margin-bottom: 5px;
        }
        .modal-cart-box p {
            color: #6c757d;
            margin-bottom: 20px;
        }
        .modal-cart-box .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }
        .modal-cart-box .btn-group .btn {
            min-width: 120px;
            padding: 10px 20px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes scaleIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        @media (max-width: 768px) {
            .pdf-viewer-container embed,
            .pdf-viewer-container object,
            .pdf-viewer-container iframe {
                height: 400px;
            }
            .article-detail-card {
                padding: 15px;
            }
            .article-detail-card .meta-label {
                min-width: 80px;
                display: block;
            }
            .price-section .row {
                flex-direction: column;
                gap: 10px;
            }
            .price-section .text-end {
                text-align: center !important;
            }
        }

        @media (max-width: 480px) {
            .pdf-viewer-container embed,
            .pdf-viewer-container object,
            .pdf-viewer-container iframe {
                height: 350px;
            }
        }
    </style>
@endsection

@section('master_content')

    <div class="page-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold">جزئیات مقاله</h1>
            <p class="lead">{{ Str::limit($article->title, 80) }}</p>
        </div>
    </div>

    <div class="content-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="article-detail-card">

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
                            <h3>{{ $article->title }}</h3>
                            <span class="badge-type {{ $article->type === 'national' ? 'badge-national' : 'badge-international' }}">
                                {{ $article->type === 'national' ? 'بومی' : 'بین‌المللی' }}
                            </span>
                        </div>

                        <div class="meta-item">
                            <span class="meta-label">سال انتشار:</span>
                            <span class="meta-value">{{ $article->publication_year ?? '-' }}</span>
                        </div>

                        <div class="meta-item">
                            <span class="meta-label">نویسندگان:</span>
                            <span class="meta-value">{{ $article->authors ?? '-' }}</span>
                        </div>

                        @if($article->keywords)
                            <div class="meta-item">
                                <span class="meta-label">کلمات کلیدی:</span>
                                <div class="article-keywords mt-1">
                                    @foreach(explode(',', $article->keywords) as $keyword)
                                        <span class="keyword">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($article->description)
                            <div class="meta-item">
                                <span class="meta-label">چکیده / توضیحات:</span>
                                <p class="article-description mt-2">{{ $article->description }}</p>
                            </div>
                        @endif

                        @if($article->abstract_file)
                            <div class="meta-item">
                                <span class="meta-label">پیش‌نمایش چکیده:</span>
                                <div class="pdf-viewer-container mt-2">
                                    @php
                                        $fileExtension = pathinfo($article->abstract_file, PATHINFO_EXTENSION);
                                        $pdfUrl = route('scientific.article.view-abstract', $article->id);
                                    @endphp

                                    @if(strtolower($fileExtension) === 'pdf')
                                        <embed 
                                            src="{{ $pdfUrl }}#toolbar=1&navpanes=1&scrollbar=1"
                                            type="application/pdf"
                                            width="100%"
                                            height="600"
                                        />
                                    @else
                                        <div class="pdf-placeholder">
                                            <div class="icon">📄</div>
                                            <h5>پیش‌نمایش فایل چکیده</h5>
                                            <p>فایل چکیده با فرمت {{ strtoupper($fileExtension) }} می‌باشد.</p>
                                            <a href="{{ route('scientific.article.download-abstract', $article->id) }}" class="btn btn-primary mt-2">
                                                دانلود فایل چکیده
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="price-section">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0">
                                        قیمت: 
                                        @if($article->is_free)
                                            <span class="price-free">رایگان</span>
                                        @else
                                            <span class="price-paid">{{ number_format($article->price) }} تومان</span>
                                        @endif
                                    </h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    @php
                                        $isPurchased = false;
                                        $inCart = false;
                                        if(auth()->check()) {
                                            $isPurchased = $article->isPurchasedByUser(auth()->id());
                                            $inCart = \App\Models\Order::where('user_id', auth()->id())
                                                ->where('status', 'pending')
                                                ->whereHas('items', function($q) use ($article) {
                                                    $q->where('article_id', $article->id);
                                                })
                                                ->exists();
                                        }
                                    @endphp

                                    @if($article->is_free)
                                        @if($article->file)
                                            <a href="{{ route('shop.download-purchased', $article->id) }}" class="btn btn-success">
                                                دانلود مقاله
                                            </a>
                                        @endif
                                    @else
                                        @auth
                                            @if($isPurchased)
                                                <div class="text-success">
                                                    <strong>✅ شما قبلاً این مقاله را خریداری کرده‌اید</strong>
                                                    @if($article->file)
                                                        <br>
                                                        <a href="{{ route('shop.download-purchased', $article->id) }}" class="btn btn-success mt-2">
                                                            دانلود مقاله
                                                        </a>
                                                    @endif
                                                </div>
                                            @elseif($inCart)
                                                <form method="POST" action="{{ route('shop.remove-from-cart-article', $article->id) }}" class="d-inline remove-from-cart-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger remove-from-cart-btn">
                                                        حذف از سبد خرید
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('shop.add-to-cart', $article->id) }}" class="d-inline add-to-cart-form" data-article-id="{{ $article->id }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary add-to-cart-btn">
                                                        افزودن به سبد خرید
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                                برای خرید وارد شوید
                                            </a>
                                        @endauth
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('scientific.articles-international') }}" class="btn btn-secondary">
                                بازگشت به لیست مقالات
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-cart-overlay" id="cartModal">
        <div class="modal-cart-box">
            <div class="icon">✅</div>
            <h4>مقاله به سبد خرید اضافه شد</h4>
            <p>آیا می‌خواهید به سبد خرید بروید یا ادامه خرید دهید؟</p>
            <div class="btn-group">
                <a href="{{ route('shop.cart') }}" class="btn btn-success">رفتن به سبد خرید</a>
                <a href="{{ route('scientific.articles-international') }}" class="btn btn-outline-secondary">ادامه خرید</a>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            document.querySelectorAll('.add-to-cart-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const url = this.action;
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('cartModal').classList.add('show');
                        } else {
                            alert(data.message || 'خطایی رخ داد');
                        }
                    })
                    .catch(function() {
                        alert('خطایی در ارتباط با سرور رخ داد');
                    });
                });
            });

            document.querySelectorAll('.remove-from-cart-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const url = this.action;
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'خطایی رخ داد');
                        }
                    })
                    .catch(function() {
                        alert('خطایی در ارتباط با سرور رخ داد');
                    });
                });
            });
        });

        function closeCartModal() {
            document.getElementById('cartModal').classList.remove('show');
        }

        document.getElementById('cartModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCartModal();
            }
        });
    </script>
@endsection