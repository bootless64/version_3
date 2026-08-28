@extends('dashboard.index')

@section('title')
    <title>مدیریت درخواست‌ها</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.manage-projects.index') }}">مدیریت پروژه‌ها</a><span class="px-1"> > </span>
            <a href="#">مدیریت درخواست‌ها</a>
        </div>

        <h2 class="mb-4">مدیریت درخواست‌ها</h2>

        <form method="GET" action="{{ route('dashboard.manage-projects.manage-requests.index') }}" class="row g-2 mb-4">
            <div class="col-lg-2 col-md-4">
                <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <input type="text" name="user_name" class="form-control" placeholder="نام کاربر" value="{{ request('user_name') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <input type="text" name="product_name" class="form-control" placeholder="نام محصول" value="{{ request('subject') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <button class="btn btn-primary w-100">جستجو</button>
            </div>
        </form>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>نام کاربر</th>
                    <th>نام محصول</th>
                    <th>تاریخ ثبت درخواست</th>
                    <th>امکانات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assessment_requests as $assessment_request)
                    <tr>
                        <td>{{ $assessment_request->id }}</td>
                        <td>{{ $assessment_request->user->name }}</td>
                        <td>{{ $assessment_request->product_name }}</td>
                        <td>{{ $assessment_request->getCreatedAt() }}</td>

                        <td>
                            <a href="{{ route('dashboard.manage-projects.manage-requests.show', $assessment_request->id) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                مشاهده درخواست
                            </a>
                            
                            <form method="POST" action="{{ route('dashboard.manage-projects.manage-requests.destroy', $assessment_request->id) }}"
                                class="d-inline" onsubmit="return confirm('آیا از حذف این درخواست مطمئن هستید؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger mt-1 mt-lg-0">حذف</button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5">هیچ درخواستی یافت نشد.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $assessment_requests->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection
