@extends('dashboard.index')

@section('title')
    <title>درخواست‌های مشاوره</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">درخواست‌های مشاوره</a>
        </div>

        <h2 class="mb-4">درخواست‌های مشاوره</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('dashboard.manage-consultations.index') }}" class="row g-2 mb-4">
            <div class="col-md-3">
                <input type="text" name="company_name" class="form-control" placeholder="نام شرکت" value="{{ request('company_name') }}">
            </div>
            <div class="col-md-3">
                <select name="service_type" class="form-select">
                    <option value="">همه نوع خدمات</option>
                    <option value="ISO15408"            {{ request('service_type') === 'ISO15408'            ? 'selected' : '' }}>ISO/IEC 15408</option>
                    <option value="ISO25000"            {{ request('service_type') === 'ISO25000'            ? 'selected' : '' }}>ISO/IEC 25000</option>
                    <option value="penetration_test"    {{ request('service_type') === 'penetration_test'    ? 'selected' : '' }}>تست نفوذ و امنیت</option>
                    <option value="document_management" {{ request('service_type') === 'document_management' ? 'selected' : '' }}>تنظیم و پایش اسناد</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">همه وضعیت‌ها</option>
                    <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>پاسخ داده نشده</option>
                    <option value="responded" {{ request('status') === 'responded' ? 'selected' : '' }}>پاسخ داده شده</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">جستجو</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('dashboard.manage-consultations.index') }}" class="btn btn-secondary w-100">پاک کردن</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>نام شرکت</th>
                        <th>شماره تماس</th>
                        <th>ایمیل</th>
                        <th>نوع خدمت</th>
                        <th>وضعیت</th>
                        <th>تاریخ</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultations as $item)
                        <tr class="{{ $item->status === 'pending' ? 'table-warning' : '' }}">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->company_name }}</td>
                            <td>
                                <a href="tel:{{ $item->phone }}" class="text-decoration-none">{{ $item->phone }}</a>
                            </td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $item->service_type_label }}</span>
                            </td>
                            <td>
                                @if($item->status === 'pending')
                                    <span class="badge bg-warning text-dark">پاسخ داده نشده</span>
                                @else
                                    <span class="badge bg-success">پاسخ داده شده</span>
                                @endif
                            </td>
                            <td>{{ $item->created_at->format('Y/m/d H:i') }}</td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    
                                    @if($item->status === 'pending')
                                        <form method="POST" action="{{ route('dashboard.manage-consultations.update-status', $item->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="responded">
                                            <button type="submit" class="btn btn-sm btn-success w-100">پاسخ داده شد</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('dashboard.manage-consultations.update-status', $item->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="btn btn-sm btn-outline-warning w-100">برگشت به پاسخ نشده</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('dashboard.manage-consultations.destroy', $item->id) }}"
                                          onsubmit="return confirm('آیا از حذف این درخواست مطمئن هستید؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">هیچ درخواستی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $consultations->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection
