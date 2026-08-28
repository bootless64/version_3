@extends('dashboard.index')

@section('title')
    <title>مدیریت کامنت‌ها</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت کامنت‌ها</a>
        </div>

        <h2 class="mb-4">مدیریت کامنت‌ها</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('dashboard.manage-comments.index') }}" class="row g-2 mb-4">
            <div class="col-lg-2 col-md-4">
                <input type="text" name="user_name" class="form-control" placeholder="نام کاربر" value="{{ request('user_name') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <input type="text" name="news_id" class="form-control" placeholder="ID خبر" value="{{ request('news_id') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <input type="text" name="article_id" class="form-control" placeholder="ID مقاله" value="{{ request('article_id') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <input type="text" name="content" class="form-control" placeholder="متن کامنت" value="{{ request('content') }}">
            </div>
            <div class="col-lg-2 col-md-4">
                <select name="status" class="form-select form-select-sm d-inline-block h-100">
                    <option value="">همه</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>تایید شده</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>رد شده</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <button class="btn btn-primary w-100">جستجو</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>نام کاربر</th>
                        <th>ID خبر</th>
                        <th>ID مقاله</th>
                        <th>متن کامنت</th>
                        <th>امکانات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($comments as $comment)
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->user->name }}</td>
                            <td>{{ $comment->news_id ?? '-' }}</td>
                            <td>{{ $comment->article_id ?? '-' }}</td>

                            <td>
                                {{ Str::limit($comment->content, 100) }}

                                <button type="button" class="btn btn-link btn-sm" data-bs-toggle="modal" data-bs-target="#commentModal{{ $comment->id }}">
                                    مشاهده متن کامل
                                </button>

                                <div class="modal fade" id="commentModal{{ $comment->id }}" tabindex="-1" aria-labelledby="commentModalLabel{{ $comment->id }}">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header justify-content-between">
                                                <h5 class="modal-title" id="commentModalLabel{{ $comment->id }}">متن کامل کامنت</h5>
                                                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="بستن"></button>
                                            </div>
                                            <div class="modal-body">
                                                <b>{{ $comment->user->name.": " }}</b>
                                                <br>
                                                {!! nl2br(e($comment->content)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                
                                <form method="POST" action="{{ route('dashboard.manage-comments.update-status', $comment->id) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline-block w-auto">
                                        <option value="pending" {{ $comment->status === 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                                        <option value="approved" {{ $comment->status === 'approved' ? 'selected' : '' }}>تایید شده</option>
                                        <option value="rejected" {{ $comment->status === 'rejected' ? 'selected' : '' }}>رد شده</option>
                                    </select>
                                </form>

                                <form method="POST" action="{{ route('dashboard.manage-comments.destroy', $comment->id) }}" class="d-inline" onsubmit="return confirm('آیا از حذف این کامنت مطمئن هستید؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger mt-2">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">هیچ کامنتی یافت نشد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center">
            {{ $comments->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
