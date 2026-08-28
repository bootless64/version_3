@extends('dashboard.index')

@section('title')
    <title>مدیریت مقالات</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت مقالات</a>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">مدیریت مقالات</h2>
            <a href="{{ route('dashboard.manage-articles.create') }}" class="btn btn-primary">
                ثبت مقاله جدید
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <ul class="nav nav-tabs mb-4" id="articlesTabs">
            <li class="nav-item">
                <a class="nav-link {{ request('tab') !== 'proposals' ? 'active' : '' }}"
                   href="{{ route('dashboard.manage-articles.index') }}">
                    مقالات
                    @php $pendingArticles = $articles->getCollection()->where('status', 'pending')->count() @endphp
                    @if($pendingArticles > 0)
                        <span class="badge bg-warning text-dark ms-1">{{ $pendingArticles }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('tab') === 'proposals' ? 'active' : '' }}"
                   href="{{ route('dashboard.manage-articles.index', ['tab' => 'proposals']) }}">
                    پیشنهادات مقالات
                    @php $pendingProposals = $proposals->getCollection()->where('status', 'pending')->count() @endphp
                    @if($pendingProposals > 0)
                        <span class="badge bg-warning text-dark ms-1">{{ $pendingProposals }}</span>
                    @endif
                </a>
            </li>
        </ul>

        @if(request('tab') !== 'proposals')

            <form method="GET" action="{{ route('dashboard.manage-articles.index') }}" class="row g-2 mb-4">
                <div class="col-lg-2 col-md-4">
                    <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <input type="text" name="title" class="form-control" placeholder="عنوان مقاله" value="{{ request('title') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <input type="text" name="user_name" class="form-control" placeholder="نام کاربر" value="{{ request('user_name') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <select name="type" class="form-select">
                        <option value="">همه انواع</option>
                        <option value="national" {{ request('type') === 'national' ? 'selected' : '' }}>بومی</option>
                        <option value="international" {{ request('type') === 'international' ? 'selected' : '' }}>بین‌المللی</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4">
                    <select name="status" class="form-select">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>تایید شده</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>رد شده</option>
                    </select>
                </div>
                <div class="col-lg-1 col-md-4">
                    <button class="btn btn-primary w-100">جستجو</button>
                </div>
                <div class="col-lg-1 col-md-4">
                    <a href="{{ route('dashboard.manage-articles.index') }}" class="btn btn-secondary w-100">پاک</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>عنوان مقاله</th>
                            <th>نویسندگان</th>
                            <th>کاربر</th>
                            <th>نوع</th>
                            <th>سال انتشار</th>
                            <th>قیمت</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($articles as $article)
                            <tr>
                                <td>{{ $article->id }}</td>
                                <td>{{ Str::limit($article->title, 35) }}</td>
                                <td>{{ Str::limit($article->authors ?? '-', 25) }}</td>
                                <td>{{ $article->user->name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $article->type === 'national' ? 'bg-success' : 'bg-primary' }}">
                                        {{ $article->type === 'national' ? 'بومی' : 'بین‌المللی' }}
                                    </span>
                                </td>
                                <td>{{ $article->publication_year ?? '-' }}</td>
                                <td>
                                    @if($article->is_free)
                                        <span class="badge bg-success">رایگان</span>
                                    @else
                                        <span class="badge bg-primary">{{ number_format($article->price) }} تومان</span>
                                    @endif
                                </td>
                                <td>
                                    @if($article->status === 'pending')
                                        <span class="badge bg-warning text-dark">در انتظار تایید</span>
                                    @elseif($article->status === 'approved')
                                        <span class="badge bg-success">تایید شده</span>
                                    @elseif($article->status === 'rejected')
                                        <span class="badge bg-danger">رد شده</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $article->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        <a href="{{ route('scientific.article.show', $article->id) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            مشاهده
                                        </a>
                                        <a href="{{ route('dashboard.manage-articles.edit', $article->id) }}" class="btn btn-sm btn-outline-warning">
                                            ویرایش
                                        </a>
                                        @if($article->status === 'pending')
                                            <form method="POST" action="{{ route('dashboard.manage-articles.approve', $article->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success w-100">تایید</button>
                                            </form>
                                            <button class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectArticleModal{{ $article->id }}">
                                                رد
                                            </button>
                                        @endif
                                        <form method="POST" action="{{ route('dashboard.manage-articles.destroy', $article->id) }}"
                                            onsubmit="return confirm('آیا از حذف این مقاله مطمئن هستید؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="rejectArticleModal{{ $article->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">رد مقاله</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('dashboard.manage-articles.reject', $article->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">توضیح دلیل رد (اختیاری)</label>
                                                    <textarea name="admin_note" class="form-control" rows="3" placeholder="دلیل رد مقاله را وارد کنید..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                                <button type="submit" class="btn btn-danger">رد مقاله</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">هیچ مقاله‌ای یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $articles->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

        @else
        
            <form method="GET" action="{{ route('dashboard.manage-articles.index') }}" class="row g-2 mb-4">
                <input type="hidden" name="tab" value="proposals">
                <div class="col-lg-3 col-md-4">
                    <input type="text" name="proposal_title" class="form-control" placeholder="عنوان مقاله" value="{{ request('proposal_title') }}">
                </div>
                <div class="col-lg-3 col-md-4">
                    <input type="text" name="proposal_user" class="form-control" placeholder="نام کاربر" value="{{ request('proposal_user') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <select name="proposal_status" class="form-select">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="pending" {{ request('proposal_status') === 'pending' ? 'selected' : '' }}>در انتظار</option>
                        <option value="approved" {{ request('proposal_status') === 'approved' ? 'selected' : '' }}>تایید</option>
                        <option value="rejected" {{ request('proposal_status') === 'rejected' ? 'selected' : '' }}>رد</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4">
                    <button class="btn btn-primary w-100">جستجو</button>
                </div>
                <div class="col-lg-2 col-md-4">
                    <a href="{{ route('dashboard.manage-articles.index', ['tab' => 'proposals']) }}" class="btn btn-secondary w-100">پاک کردن</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>کاربر</th>
                            <th>نوع</th>
                            <th>سال</th>
                            <th>وضعیت</th>
                            <th>تاریخ</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($proposals as $proposal)
                            <tr>
                                <td>{{ $proposal->id }}</td>
                                <td>{{ Str::limit($proposal->title, 35) }}</td>
                                <td>{{ $proposal->user->name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $proposal->type === 'national' ? 'bg-success' : 'bg-primary' }}">
                                        {{ $proposal->type === 'national' ? 'بومی' : 'بین‌المللی' }}
                                    </span>
                                </td>
                                <td>{{ $proposal->publication_year }}</td>
                                <td>
                                    <span class="badge {{ $proposal->status_badge_class }}">
                                        {{ $proposal->status_label }}
                                    </span>
                                </td>
                                <td>{{ $proposal->created_at->format('Y/m/d') }}</td>
                                <td>
                                    @if($proposal->status === 'pending')
                                        <div class="d-flex flex-column gap-1">
                                            <form method="POST" action="{{ route('dashboard.manage-proposals.approve', $proposal->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success w-100">تایید</button>
                                            </form>
                                            <button class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectProposalModal{{ $proposal->id }}">
                                                رد
                                            </button>
                                            <form method="POST" action="{{ route('dashboard.manage-proposals.destroy', $proposal->id) }}"
                                                onsubmit="return confirm('آیا از حذف این پیشنهاد مطمئن هستید؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">حذف</button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="d-flex flex-column gap-1">
                                            <span class="text-muted small">بررسی شده</span>
                                            <form method="POST" action="{{ route('dashboard.manage-proposals.destroy', $proposal->id) }}"
                                                onsubmit="return confirm('آیا از حذف این پیشنهاد مطمئن هستید؟');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">حذف</button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            </tr>

                            <div class="modal fade" id="rejectProposalModal{{ $proposal->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">رد پیشنهاد</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('dashboard.manage-proposals.reject', $proposal->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">توضیح دلیل رد (اختیاری)</label>
                                                    <textarea name="admin_note" class="form-control" rows="3" placeholder="دلیل رد پیشنهاد را وارد کنید..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                                <button type="submit" class="btn btn-danger">رد پیشنهاد</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">هیچ پیشنهادی یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $proposals->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

        @endif

    </div>

@endsection