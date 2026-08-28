@extends('dashboard.index')

@section('title')
    <title>مدیریت کاربران</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">مدیریت کاربران</a>
        </div>

        <h2 class="mb-4">مدیریت کاربران</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('dashboard.manage-users.index') }}" class="row g-2 mb-4">
            <div class="col-lg-2 col-md-6">
                <input type="text" name="id" class="form-control" placeholder="ID" value="{{ request('id') }}">
            </div>
            <div class="col-lg-3 col-md-6">
                <input type="text" name="name" class="form-control" placeholder="نام کاربر" value="{{ request('name') }}">
            </div>
            <div class="col-lg-3 col-md-6">
                <input type="text" name="email" class="form-control" placeholder="ایمیل" value="{{ request('email') }}">
            </div>
            <div class="col-lg-2 col-md-6">
                <select name="role" class="form-select form-select-sm d-inline-block h-100">
                    <option value="">همه</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') === $role->name ? 'selected' : ''}}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2">
                <button class="btn btn-primary w-100">جستجو</button>
            </div>
        </form>

        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>نام کاربر</th>
                    <th>ایمیل</th>
                    <th>نقش فعلی</th>
                    <th>امکانات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td class="text-break">{{ $user->name }}</td>
                        <td class="text-break">{{ $user->email }}</td>
                        <td>{{ $user->getRoleNames()->first() ?? '-' }}</td>
                        <td class="text-end">
                            
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                data-bs-target="#editUserRole{{ $user->id }}">
                                اعطای نقش
                            </button>
                            
                            @if (auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('dashboard.manage-users.destroy', $user->id) }}" class="d-inline-block"
                                    onsubmit="return confirm('آیا از حذف این کاربر مطمئن هستید؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger mt-1 mt-md-0">حذف</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    
                    <tr class="bg-light">
                        <td colspan="5" class="p-0">
                            <div class="collapse"  id="editUserRole{{ $user->id }}">
                                <form method="POST" action="{{ route('dashboard.manage-users.update-role', $user->id) }}" class="mb-3 p-2">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row gx-2 align-items-center">
                                        <div class="col-md-4 col-6">
                                            <select name="role" class="form-select" required>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-sm btn-success">ثبت</button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#editUserRole{{ $user->id }}">
                                                انصراف
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5">هیچ کاربری یافت نشد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
