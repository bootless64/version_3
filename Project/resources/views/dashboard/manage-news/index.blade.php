@extends('dashboard.index')

@section('title')
    <title>مدیریت خبرها</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت خبرها</a>
        </div>

        <h2 class="mb-4">مدیریت خبرها</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('dashboard.manage-news.index') }}" class="row g-2 mb-4">
            <div class="col-lg-2 col-md-6">
                <input type="text" name="id" class="form-control" placeholder="ID خبر" value="{{ request('id') }}">
            </div>
            <div class="col-lg-2 col-md-6">
                <input type="text" name="user_name" class="form-control" placeholder="نام منتشر کننده"
                    value="{{ request('user_name') }}">
            </div>
            <div class="col-lg-3 col-md-6">
                <input type="text" name="title" class="form-control" placeholder="عنوان خبر"
                    value="{{ request('title') }}">
            </div>
            <div class="col-lg-5 col-md-6">
                <input type="text" name="content" class="form-control" placeholder="متن خبر"
                    value="{{ request('content') }}">
            </div>
            <div class="col-lg-2 col-6">
                <select name="status" class="form-select form-select-sm d-inline-block h-100">
                    <option value="">همه</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>تایید شده</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>رد شده</option>
                </select>
            </div>
            <div class="col-lg-2 col-6">
                <select name="archive_status" class="form-select form-select-sm d-inline-block h-100">
                    <option value="">همه</option>
                    <option value="current" {{ request('archive_status') === 'current' ? 'selected' : '' }}>جاری</option>
                    <option value="archived" {{ request('archive_status') === 'archived' ? 'selected' : '' }}>آرشیو شده</option>
                </select>
            </div>
            <div class="col-lg-3">
                <button class="btn btn-primary w-100">جستجو</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>نام کاربر</th>
                        <th>عنوان خبر</th>
                        <th>تاریخ انتشار</th>
                        <th>امکانات</th>
                        <th>وضعیت انتشار</th>
                        <th>آرشیو</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($news as $one_news)
                        <tr>
                            <td>{{ $one_news->id }}</td>
                            <td>{{ $one_news->user->name }}</td>
                            <td>{{ $one_news->title }}</td>
                            <td>{{ $one_news->getCreatedAt() }}</td>

                            <td>
                                <div>
                                    <a href="{{ route('news.show', $one_news->id) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                                        مشاهده خبر
                                    </a>
                                </div>
                                <div>
                                    <a href="{{ route('dashboard.manage-news.edit', $one_news->id) }}" class="btn btn-sm btn-outline-success mb-1">
                                        ویرایش
                                    </a>
                                </div>
                                
                                <form method="POST" action="{{ route('dashboard.manage-news.destroy', $one_news->id) }}"
                                    class="d-inline" onsubmit="return confirm('آیا از حذف این خبر مطمئن هستید؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                </form>
                            </td>

                            <td>
                                <form method="POST" action="{{ route('dashboard.manage-news.update-status', $one_news->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="pending" {{ $one_news->status === 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                                        <option value="approved" {{ $one_news->status === 'approved' ? 'selected' : '' }}>تایید شده</option>
                                        <option value="rejected" {{ $one_news->status === 'rejected' ? 'selected' : '' }}>رد شده</option>
                                    </select>
                                </form>
                            </td>

                            <td>
                                <form method="POST" action="{{ route('dashboard.manage-news.update-is-archived', $one_news->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="checkbox" name="is_archived" value="1" {{ $one_news->is_archived ? 'checked' : '' }}
                                        onchange="this.form.submit()" class="form-check-input border-dark">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">هیچ خبری یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $news->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>

    </div>

@endsection
