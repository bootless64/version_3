@extends('master')

@section('title')
    <title>مقالات ملی و بین‌المللی | مرکز آسا</title>
@endsection

@section('meta')
    <meta name="description" content="مقالات ملی و بین‌المللی مرکز پژوهشی آسا شرق">
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
        .article-card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: white;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .article-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        .article-card .authors {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .badge-year {
            background: #e9ecef;
            padding: 3px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
        }
        .badge-type {
            padding: 3px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
        }
        .badge-national {
            background: #d4edda;
            color: #155724;
        }
        .badge-international {
            background: #cce5ff;
            color: #004085;
        }
        .badge-price {
            padding: 3px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
        }
        .badge-free {
            background: #d4edda;
            color: #155724;
        }
        .badge-paid {
            background: #fff3cd;
            color: #856404;
        }
        .article-keywords {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 8px;
        }
        .article-keywords .keyword {
            background: #f0f0f0;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            color: #555;
        }
        .article-description {
            color: #555;
            font-size: 0.9rem;
            line-height: 1.6;
            flex-grow: 1;
        }
        .article-card .btn {
            align-self: flex-start;
        }
        .article-card .card-footer-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .filter-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .filter-section .form-control,
        .filter-section .form-select {
            border-radius: 8px;
        }
        .filter-section .btn-search {
            border-radius: 8px;
            padding: 10px 16px;
        }
        .filter-section .btn-reset {
            border-radius: 8px;
            padding: 10px 16px;
        }

        .empty-state {
            padding: 60px 0;
        }

        .articles-count {
            font-size: 0.95rem;
            color: #6c757d;
        }

        .pagination-wrapper {
            margin-top: 30px;
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

        .floating-cart {
            position: fixed;
            bottom: 30px;
            left: 30px;
            z-index: 1050;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 20px;
            box-shadow: 0 4px 20px rgba(13, 110, 253, 0.45);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
        }
        .floating-cart:hover {
            background: #0b5ed7;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(13, 110, 253, 0.55);
        }
        .floating-cart .cart-badge {
            background: #ff3b3b;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            animation: badgePop 0.3s ease;
        }
        @keyframes badgePop {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }
    </style>
@endsection

@section('master_content')

    <div class="page-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">مقالات ملی و بین‌المللی</h1>
            <p class="lead">مرکز پژوهشی آسا شرق با همکاری پژوهشگران برجسته، مقالات متعددی را در مجلات معتبر ملی و بین‌المللی منتشر نموده است.</p>
        </div>
    </div>

    <div class="content-section">
        <div class="container">

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

            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-info">
                        <h5>معرفی</h5>
                        <p class="mb-0">
                            مقالات منتشر شده توسط پژوهشگران مرکز آسا شرق در حوزه‌های <strong>امنیت سایبری،
                            رمزنگاری، امنیت شبکه، هوش مصنوعی در امنیت و تحلیل تهدیدات</strong> در مجلات علمی معتبر
                            داخلی و بین‌المللی به چاپ رسیده است.
                        </p>
                    </div>
                </div>
            </div>

            <div class="filter-section">
                <form method="GET" action="{{ route('scientific.articles-international') }}" class="row g-3" id="filterForm">
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" 
                               placeholder="جستجو در کلمات کلیدی..." 
                               value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="author" class="form-control" 
                               placeholder="جستجو در نویسندگان..." 
                               value="{{ request('author') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="type_filter" class="form-select" id="typeFilter">
                            <option value="">همه انواع</option>
                            <option value="national" {{ request('type_filter') == 'national' ? 'selected' : '' }}>بومی</option>
                            <option value="international" {{ request('type_filter') == 'international' ? 'selected' : '' }}>بین‌المللی</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="year" class="form-control" 
                               placeholder="سال انتشار" 
                               value="{{ request('year') }}">
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-search">
                            جستجو
                        </button>
                        <a href="{{ route('scientific.articles-international') }}" class="btn btn-secondary btn-reset">
                            پاک کردن
                        </a>
                    </div>
                </form>
                
                <div class="mt-2">
                    <small class="text-muted">
                        <span class="badge bg-light text-dark me-1">نکته:</span>
                        جستجو در کلمات کلیدی و نویسندگان مقاله انجام می‌شود. برای سال انتشار، عدد را به صورت ۴ رقمی وارد کنید.
                    </small>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="articles-count">
                    نمایش {{ $articles->firstItem() ?? 0 }} تا {{ $articles->lastItem() ?? 0 }} از {{ $articles->total() }} مقاله
                </span>
            </div>

            @if($articles->isEmpty())
                <div class="empty-state text-center py-5">
                    <h4>هیچ مقاله‌ای با این فیلترها یافت نشد.</h4>
                    <p class="text-muted">لطفاً فیلترهای خود را تغییر دهید یا از جستجوی دیگری استفاده کنید.</p>
                    <a href="{{ route('scientific.articles-international') }}" class="btn btn-outline-primary mt-3">
                        نمایش همه مقالات
                    </a>
                </div>
            @else
                <div class="row">
                    @foreach($articles as $article)
                        @php
                            $inCart = false;
                            if(auth()->check()) {
                                $inCart = \App\Models\Order::where('user_id', auth()->id())
                                    ->where('status', 'pending')
                                    ->whereHas('items', function($q) use ($article) {
                                        $q->where('article_id', $article->id);
                                    })
                                    ->exists();
                            }
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="article-card">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge-year">{{ $article->publication_year ?? '-' }}</span>
                                    <span class="badge-type {{ $article->type === 'national' ? 'badge-national' : 'badge-international' }}">
                                        {{ $article->type === 'national' ? 'بومی' : 'بین‌المللی' }}
                                    </span>
                                </div>
                                
                                <div class="mb-2">
                                    @if($article->is_free)
                                        <span class="badge-price badge-free">رایگان</span>
                                    @else
                                        <span class="badge-price badge-paid">{{ number_format($article->price) }} تومان</span>
                                    @endif
                                </div>

                                <h5 class="mt-1">{{ Str::limit($article->title, 60) }}</h5>
                                <p class="authors">نویسندگان: {{ Str::limit($article->authors ?? '-', 60) }}</p>

                                @if($article->description)
                                    <p class="article-description">{{ Str::limit($article->description, 100) }}</p>
                                @endif

                                @if($article->keywords)
                                    <div class="article-keywords">
                                        @foreach(explode(',', $article->keywords) as $keyword)
                                            <span class="keyword">{{ trim($keyword) }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="card-footer-actions">
                                    <a href="{{ route('scientific.article.show', $article->id) }}" class="btn btn-outline-primary btn-sm">
                                        مشاهده مقاله
                                    </a>
                                    
                                    @auth
                                        @if(!$article->is_free)
                                            @if($article->isPurchasedByUser(auth()->id()))
                                                <span class="badge bg-info text-white p-2">خریداری شده</span>
                                            @elseif($inCart)
                                                <form method="POST" action="{{ route('shop.remove-from-cart-article', $article->id) }}" class="d-inline remove-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        حذف از سبد خرید
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('shop.add-to-cart', $article->id) }}" class="d-inline add-form">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        افزودن به سبد خرید
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <a href="{{ route('shop.download-purchased', $article->id) }}" class="btn btn-success btn-sm">
                                                دانلود
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">
                                            برای خرید وارد شوید
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-wrapper d-flex justify-content-center">
                    {{ $articles->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="btn btn-secondary">بازگشت به صفحه اصلی</a>
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
                <button class="btn btn-outline-secondary" onclick="closeCartModal()">ادامه خرید</button>
            </div>
        </div>
    </div>

    @auth
        @php
            $cartCount = \App\Models\Order::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->withCount('items')
                ->first()?->items_count ?? 0;
        @endphp
        <a href="{{ route('shop.cart') }}" class="floating-cart" id="floatingCart">
            🛒 سبد خرید
            @if($cartCount > 0)
                <span class="cart-badge">{{ $cartCount }}</span>
            @endif
        </a>
    @endauth

@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeFilter = document.getElementById('typeFilter');
            if (typeFilter) {
                typeFilter.addEventListener('change', function() {
                    document.getElementById('filterForm').submit();
                });
            }

            document.querySelectorAll('.add-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const url = this.action;
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showCartModal();
                            updateCartBadge(1);
                        } else {
                            alert(data.message || 'خطایی رخ داد');
                        }
                    })
                    .catch(error => {
                        alert('خطایی در ارتباط با سرور رخ داد');
                    });
                });
            });

            document.querySelectorAll('.remove-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const url = this.action;
                    
                    fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
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
                    .catch(error => {
                        alert('خطایی در ارتباط با سرور رخ داد');
                    });
                });
            });
        });

        function showCartModal() {
            document.getElementById('cartModal').classList.add('show');
        }

        function closeCartModal() {
            document.getElementById('cartModal').classList.remove('show');
            location.reload();
        }

        document.getElementById('cartModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCartModal();
            }
        });

        function updateCartBadge(delta) {
            const cart = document.getElementById('floatingCart');
            if (!cart) return;

            let badge = cart.querySelector('.cart-badge');
            const current = badge ? parseInt(badge.textContent) : 0;
            const next = current + delta;

            if (next > 0) {
                if (badge) {
                    badge.textContent = next;
                } else {
                    badge = document.createElement('span');
                    badge.className = 'cart-badge';
                    badge.textContent = next;
                    cart.appendChild(badge);
                }
            } else if (badge) {
                badge.remove();
            }
        }

        (function() {
            const cart = document.getElementById('floatingCart');
            if (!cart) return;

            const articlesSection = document.querySelector('.content-section');
            const footer = document.querySelector('footer');

            function updateVisibility() {
                if (!articlesSection) return;

                const scrollY = window.scrollY;
                const sectionTop = articlesSection.getBoundingClientRect().top + scrollY;
                const footerTop = footer
                    ? footer.getBoundingClientRect().top + scrollY
                    : document.body.scrollHeight;

                const hideBeforeFooter = footerTop - 80;
                const viewportBottom = scrollY + window.innerHeight;

                const shouldShow = scrollY >= sectionTop && viewportBottom <= hideBeforeFooter + window.innerHeight * 0.15;

                cart.style.opacity = shouldShow ? '1' : '0';
                cart.style.pointerEvents = shouldShow ? 'auto' : 'none';
                cart.style.transform = shouldShow ? 'translateY(0)' : 'translateY(10px)';
            }

            cart.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
            cart.style.opacity = '0';
            cart.style.pointerEvents = 'none';

            window.addEventListener('scroll', updateVisibility, { passive: true });
            updateVisibility();
        })();
    </script>
@endsection