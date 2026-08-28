@extends('dashboard.index')

@section('title')
    <title>مدیریت پروژه‌ها</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت پروژه‌ها</a>
        </div>

        <h2 class="mb-4">مدیریت پروژه‌ها</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <a class="btn btn-outline-primary mb-5" href="{{ route('dashboard.manage-projects.manage-requests.index') }}">
            مدیریت درخواست‌ها
        </a>
        <a class="btn btn-outline-success mb-5 me-1" href="{{ route('dashboard.manage-projects.create') }}">
            ایجاد پروژه جدید
        </a>

        <form method="GET" action="{{ route('dashboard.manage-projects.index') }}" class="row g-2 mb-4">
            <div class="col-lg-2 col-md-6">
                <input type="text" name="id" class="form-control" placeholder="ID پروژه" value="{{ request('id') }}">
            </div>
            <div class="col-lg-2 col-md-6">
                <input type="text" name="title" class="form-control" placeholder="عنوان پروژه"
                    value="{{ request('title') }}">
            </div>
            <div class="col-lg-3 col-md-6">
                <input type="text" name="applicant_name" class="form-control" placeholder="نام متقاضی"
                    value="{{ request('applicant_name') }}">
            </div>
            <div class="col-lg-3 col-md-6">
                <input type="text" name="primary_coach_name" class="form-control" placeholder="نام مسئول اصلی پروژه"
                    value="{{ request('primary_coach_name') }}">
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary w-100">جستجو</button>
            </div>
        </form>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>عنوان پروژه</th>
                    <th>نام متقاضی</th>
                    <th>مسئول اصلی پروژه</th>
                    <th>امکانات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td class="text-break">{{ $project->title }}</td>
                        <td>{{ $project->applicant->name }}</td>
                        <td>{{ $project->primaryCoach->name ?? '-' }}</td>

                        <td>
                            <a href="{{ route('dashboard.manage-projects.reports', $project->id) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                مشاهده گزارش
                            </a>
                            <a href="{{ route('dashboard.manage-projects.edit', $project->id) }}" class="btn btn-outline-success btn-sm mt-1 mt-sm-0">
                                ویرایش
                            </a>
                            
                            <form method="POST" action="{{ route('dashboard.manage-projects.destroy', $project->id) }}"
                                class="d-inline" onsubmit="return confirm('آیا از حذف این پروژه مطمئن هستید؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger mt-1 mt-lg-0">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">هیچ پروژه‌ای یافت نشد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $projects->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection
