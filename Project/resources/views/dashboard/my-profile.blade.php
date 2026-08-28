@extends('dashboard.index')

@section('title')
    <title>پروفایل من</title>
@endsection

@section('dashboard_style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/dashboard/my-profile.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/dashboard/my-profile.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/dashboard/my-profile.css') }}" rel="stylesheet">
    @endif
@endsection

@section('dashboard_content')
    <div class="container py-4 px-5">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">پروفایل من</a>
        </div>

        <h2 class="mb-5">پروفایل من</h2>

        <div id="mainAccordion" class="accordion mb-5">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ session('open_form') === 'update_name' ? '' : 'collapsed'}}" data-bs-toggle="collapse" data-bs-target="#section1">
                        <span class="mx-2">تغییر نام</span>
                    </button>
                </h2>
                <div id="section1" class="accordion-collapse collapse {{ session('open_form') === 'update_name' ? 'show' : ''}}" data-bs-parent="#mainAccordion">
                    <div class="accordion-body">
                        
                        <div class="card mb-5">
                            <div class="card-header">تغییر نام</div>
                            <div class="card-body">
                                @if (session('open_form') === 'update_name' && session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if ($errors->hasBag('update_name'))
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->getBag('update_name')->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('dashboard.my-profile.update-name') }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label class="form-label">نام فعلی</label>
                                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">نام جدید</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ session('open_form') === 'update_password' ? '' : 'collapsed'}}" data-bs-toggle="collapse" data-bs-target="#section2">
                        <span class="mx-2">تغییر رمز عبور</span>
                    </button>
                </h2>
                <div id="section2" class="accordion-collapse collapse {{ session('open_form') === 'update_password' ? 'show' : ''}}" data-bs-parent="#mainAccordion">
                    <div class="accordion-body">
                        
                        <div class="card mb-5">
                            <div class="card-header">تغییر رمز عبور</div>
                            <div class="card-body">

                                @if (session('open_form') === 'update_password' && session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if ($errors->hasBag('update_password'))
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->getBag('update_password')->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @error('current_password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                @error('new_password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div>
                                    <b>رمز عبور انتخابی باید شرایط زیر را داشته باشد:</b>
                                    <ul class="px-3 py-1">
                                        <li>شامل حداقل 8 کاراکتر باشد.</li>
                                        <li>شامل حداقل یک حرف بزرگ باشد.</li>
                                    </ul>
                                </div>
                                <form method="POST" action="{{ route('dashboard.my-profile.update-password') }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">رمز عبور فعلی</label>
                                        <input type="password" id="current_password" name="current_password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">رمز عبور جدید</label>
                                        <input type="password" id="new_password" name="new_password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password_confirmation" class="form-label">تأیید رمز عبور جدید</label>
                                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-warning">تغییر رمز عبور</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ session('open_form') === 'update_avatar' ? '' : 'collapsed'}}" data-bs-toggle="collapse" data-bs-target="#section3">
                        <span class="mx-2">تغییر عکس پروفایل</span>
                    </button>
                </h2>
                <div id="section3" class="accordion-collapse collapse {{ session('open_form') === 'update_avatar' ? 'show' : ''}}" data-bs-parent="#mainAccordion">
                    <div class="accordion-body">
                        
                        <div class="card mb-5">
                            <div class="card-header">عکس پروفایل</div>
                            <div class="card-body">

                                @if (session('open_form') === 'update_avatar' && session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @if ($errors->hasBag('update_avatar'))
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->getBag('update_avatar')->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('dashboard.my-profile.update-avatar') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        @if (auth()->user()->avatar)
                                            <label class="form-label d-block">عکس فعلی:</label>
                                        @else
                                            <label class="form-label d-block">بدون عکس</label>
                                        @endif

                                        <div class="avatar shadow">
                                            <img src="{{ auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/no-avatar.png')}}" alt="پروفایل" class="img-fluid avatar">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="avatar" class="form-label">انتخاب عکس جدید</label>
                                        <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">آپلود عکس جدید</button>
                                </form>

                                @if (auth()->user()->avatar)
                                    <form method="POST" action="{{ route('dashboard.my-profile.delete-avatar') }}" onsubmit="return confirm('آیا از حذف عکس پروفایل مطمئن هستید؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger mt-3">
                                            حذف عکس پروفایل
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ session('open_form') === 'delete_account' ? '' : 'collapsed'}}" data-bs-toggle="collapse" data-bs-target="#section4">
                        <span class="mx-2">حذف حساب کاربری</span>
                    </button>
                </h2>
                <div id="section4" class="accordion-collapse collapse {{ session('open_form') === 'delete_account' ? 'show' : ''}}" data-bs-parent="#mainAccordion">
                    <div class="accordion-body">
                        
                        <div class="card">
                            <div class="card-header">حذف حساب کاربری</div>
                            <div class="card-body">

                                @if (session('open_form') === 'delete_account' && session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <form method="POST" action="{{ route('dashboard.my-profile.delete-account') }}" onsubmit="return confirm('آیا از حذف حساب کاربری خود مطمئن هستید؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        حذف حساب کاربری من
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
