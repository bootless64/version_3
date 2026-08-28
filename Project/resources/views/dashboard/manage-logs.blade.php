@extends('dashboard.index')

@section('title')
    <title>مدیریت لاگ‌های سیستم</title>
@endsection

@section('dashboard_style')
    <style>
        .log-row-success {
            border-right: 4px solid #198754;
        }
        .log-row-failed {
            border-right: 4px solid #dc3545;
        }
        .log-row-info {
            border-right: 4px solid #0d6efd;
        }
        .log-row-warning {
            border-right: 4px solid #ffc107;
        }
        .log-detail-toggle {
            cursor: pointer;
        }
        .log-detail-toggle:hover {
            background-color: #f8f9fa;
        }
        .badge-category {
            font-size: 0.7rem;
            padding: 3px 8px;
        }
        .badge-auth { background: #6f42c1; color: white; }
        .badge-data { background: #0d6efd; color: white; }
        .badge-security { background: #dc3545; color: white; }
        .badge-system { background: #198754; color: white; }
        .badge-admin { background: #fd7e14; color: white; }
        .badge-user_management { background: #20c997; color: white; }
        .badge-session { background: #6c757d; color: white; }
        .badge-entity { background: #6610f2; color: white; }
        
        .log-detail-modal .modal-body {
            font-size: 0.9rem;
        }
        .log-detail-modal .detail-item {
            padding: 5px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .log-detail-modal .detail-item:last-child {
            border-bottom: none;
        }
        .log-detail-modal .detail-label {
            font-weight: bold;
            color: #333;
            display: inline-block;
            min-width: 120px;
        }
    </style>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت لاگ‌ها</a>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">مدیریت لاگ‌های سیستم</h2>
            <div>
                <form method="POST" action="{{ route('dashboard.manage-logs.clear-old') }}" class="d-inline">
                    @csrf
                    <div class="input-group">
                        <input type="number" name="days" value="30" class="form-control form-control-sm" style="width: 70px;" min="1">
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('آیا از حذف لاگ‌های قدیمی مطمئن هستید؟');">
                            حذف لاگ‌های قدیمی
                        </button>
                    </div>
                </form>
                <span class="badge bg-secondary ms-2">تعداد کل: {{ $logs->total() }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @php $bannedIps = \App\Models\BannedIp::with('bannedBy')->latest()->get(); @endphp
        <ul class="nav nav-tabs mb-4" id="manageTabs">
            <li class="nav-item">
                <a class="nav-link {{ request('tab') !== 'banned' ? 'active' : '' }}"
                   href="{{ route('dashboard.manage-logs.index', request()->except('tab')) }}">
                    لاگ‌های سیستم
                    <span class="badge bg-secondary ms-1">{{ $logs->total() }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('tab') === 'banned' ? 'active' : '' }}"
                   href="{{ route('dashboard.manage-logs.index', array_merge(request()->except('tab'), ['tab' => 'banned'])) }}">
                    آی‌پی‌های بن شده
                    <span class="badge {{ $bannedIps->isNotEmpty() ? 'bg-danger' : 'bg-secondary' }} ms-1">{{ $bannedIps->count() }}</span>
                </a>
            </li>
        </ul>

        @if(request('tab') === 'banned')

            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#manualBanModal">
                    + بن دستی آی‌پی
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>آی‌پی</th>
                            <th>دلیل</th>
                            <th>بن شده توسط</th>
                            <th>تاریخ</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bannedIps as $ban)
                        <tr>
                            <td><code>{{ $ban->ip }}</code></td>
                            <td>{{ $ban->reason ?? '-' }}</td>
                            <td>{{ $ban->bannedBy?->name ?? 'ناشناخته' }}</td>
                            <td>{{ $ban->created_at->format('Y/m/d H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('dashboard.manage-logs.ban-ip.destroy', $ban->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-success"
                                        onclick="return confirm('رفع بن آی‌پی {{ $ban->ip }}؟')">
                                        رفع بن
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">هیچ آی‌پی بن شده‌ای وجود ندارد.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @else

            <form method="GET" action="{{ route('dashboard.manage-logs.index') }}" class="row g-2 mb-4">
                <div class="col-lg-2 col-md-4">
                    <input type="date" name="date_from" class="form-control" placeholder="از تاریخ" value="{{ request('date_from') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <input type="date" name="date_to" class="form-control" placeholder="تا تاریخ" value="{{ request('date_to') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <input type="text" name="ip" class="form-control" placeholder="IP" value="{{ request('ip') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <input type="text" name="user_id" class="form-control" placeholder="شناسه کاربر" value="{{ request('user_id') }}">
                </div>
                <div class="col-lg-2 col-md-4">
                    <select name="category" class="form-select">
                        <option value="">همه دسته‌بندی‌ها</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $cat)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-4">
                    <select name="result" class="form-select">
                        <option value="">همه نتایج</option>
                        <option value="true" {{ request('result') === 'true' ? 'selected' : '' }}>موفق</option>
                        <option value="false" {{ request('result') === 'false' ? 'selected' : '' }}>ناموفق</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-4">
                    <button class="btn btn-primary w-100">جستجو</button>
                </div>
                <div class="col-lg-2 col-md-4">
                    <a href="{{ route('dashboard.manage-logs.index') }}" class="btn btn-secondary w-100">پاک کردن</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>تاریخ و زمان</th>
                            <th>نوع رویداد</th>
                            <th>دسته‌بندی</th>
                            <th>کاربر</th>
                            <th>IP</th>
                            <th>نتیجه</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr class="{{ $log->event_result ? 'log-row-success' : 'log-row-failed' }}">
                                <td class="small">{{ $log->event_time->format('Y/m/d H:i:s') }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ str_replace('_', ' ', $log->event_type) }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-category badge-{{ str_replace('_', '', $log->event_category) }}">
                                        {{ ucfirst(str_replace('_', ' ', $log->event_category)) }}
                                    </span>
                                </td>
                                <td>{{ $log->user_name ?? 'ناشناخته' }}</td>
                                <td>{{ $log->user_ip ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $log->result_badge_class }}">
                                        {{ $log->result_label }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#logDetailModal{{ $log->id }}">
                                        جزئیات
                                    </button>
                                    @if($log->user_ip && $log->user_ip !== '-')
                                        @if(!\App\Models\BannedIp::isBanned($log->user_ip))
                                            <button class="btn btn-sm btn-outline-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#banIpModal{{ $log->id }}">
                                                بن IP
                                            </button>
                                        @else
                                            <span class="badge bg-danger">IP بن شده</span>
                                        @endif
                                    @endif
                                    <form method="POST" action="{{ route('dashboard.manage-logs.destroy', $log->id) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('آیا از حذف این لاگ مطمئن هستید؟');">
                                            حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade log-detail-modal" id="logDetailModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">جزئیات لاگ</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="detail-item">
                                                <span class="detail-label">زمان رویداد:</span>
                                                {{ $log->event_time->format('Y/m/d H:i:s') }}
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">نوع رویداد:</span>
                                                {{ str_replace('_', ' ', $log->event_type) }}
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">دسته‌بندی:</span>
                                                {{ ucfirst(str_replace('_', ' ', $log->event_category)) }}
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">نتیجه:</span>
                                                <span class="badge {{ $log->result_badge_class }}">{{ $log->result_label }}</span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">کاربر:</span>
                                                {{ $log->user_name ?? 'ناشناخته' }}
                                                @if($log->user)
                                                    ({{ $log->user->email }})
                                                @endif
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">IP:</span>
                                                {{ $log->user_ip ?? '-' }}
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">مرورگر:</span>
                                                {{ $log->user_agent ?? '-' }}
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">URL:</span>
                                                {{ $log->url ?? '-' }}
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">متود:</span>
                                                {{ $log->method ?? '-' }}
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">رویداد:</span>
                                                <p class="mt-1 mb-0">{{ $log->description ?? '-' }}</p>
                                            </div>
                                            @if($log->details)
                                                <div class="detail-item">
                                                    <span class="detail-label">اطلاعات تکمیلی:</span>
                                                    <pre class="bg-light p-2 mt-1 rounded" style="font-size: 0.8rem;">{{ json_encode($log->details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                </div>
                                            @endif
                                            @if($log->error_message)
                                                <div class="detail-item">
                                                    <span class="detail-label">خطا:</span>
                                                    <p class="text-danger mt-1 mb-0">{{ $log->error_message }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($log->user_ip && $log->user_ip !== '-')
                            <div class="modal fade" id="banIpModal{{ $log->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">بن آی‌پی: {{ $log->user_ip }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('dashboard.manage-logs.ban-ip.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="ip" value="{{ $log->user_ip }}">
                                                <div class="mb-3">
                                                    <label class="form-label">آی‌پی</label>
                                                    <input type="text" class="form-control" value="{{ $log->user_ip }}" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">دلیل بن (اختیاری)</label>
                                                    <input type="text" name="reason" class="form-control" placeholder="مثلاً: تلاش‌های مکرر ناموفق" maxlength="255">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                                <button type="submit" class="btn btn-danger">بن کردن</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">هیچ لاگی یافت نشد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $logs->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

        @endif

        <div class="modal fade" id="manualBanModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">بن دستی آی‌پی</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('dashboard.manage-logs.ban-ip.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">آی‌پی <span class="text-danger">*</span></label>
                                <input type="text" name="ip" class="form-control" placeholder="مثلاً: 192.168.1.100" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">دلیل (اختیاری)</label>
                                <input type="text" name="reason" class="form-control" placeholder="مثلاً: تلاش‌های مکرر ناموفق" maxlength="255">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                            <button type="submit" class="btn btn-danger">بن کردن</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection