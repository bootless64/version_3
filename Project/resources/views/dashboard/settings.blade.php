@extends('dashboard.index')

@section('title')
    <title>تنظیمات پسورد</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">تنظیمات پسورد</a>
        </div>

        <h2 class="mb-4">تنظیمات سطح سختی پسورد</h2>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">تنظیمات پسورد</h5>
            </div>
            <div class="card-body">

                <div class="alert alert-info mb-4">
                    <h6>راهنما:</h6>
                    <ul class="mb-0">
                        <li><strong>سطح آسان:</strong> فقط شامل حروف (کوچک/بزرگ) یا فقط اعداد</li>
                        <li><strong>سطح متوسط:</strong> شامل حروف و اعداد</li>
                        <li><strong>سطح پیچیده:</strong> شامل حروف کوچک، حروف بزرگ، اعداد و کاراکترهای خاص (!@#$%^&*)</li>
                        <li>حداقل طول پسورد تعیین کننده حداقل کاراکترهای مورد نیاز برای پسورد می‌باشد.</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('dashboard.settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">حداقل طول پسورد <span class="text-danger">*</span></label>
                            <input type="number" name="password_min_length" 
                                   value="{{ $passwordMinLength }}" 
                                   class="form-control" min="4" max="20" required>
                            <small class="text-muted">حداقل ۴ و حداکثر ۲۰ کاراکتر</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">سطح سختی پسورد <span class="text-danger">*</span></label>
                            <select name="password_complexity" class="form-select" required>
                                <option value="simple" {{ $passwordComplexity == 'simple' ? 'selected' : '' }}>
                                    آسان (فقط حروف یا فقط اعداد)
                                </option>
                                <option value="medium" {{ $passwordComplexity == 'medium' ? 'selected' : '' }}>
                                    متوسط (حروف و اعداد)
                                </option>
                                <option value="complex" {{ $passwordComplexity == 'complex' ? 'selected' : '' }}>
                                    پیچیده (حروف کوچک، حروف بزرگ، اعداد و کاراکترهای خاص)
                                </option>
                            </select>
                            <small class="text-muted">سطح پیچیدگی پسورد برای کاربران جدید</small>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            ذخیره تنظیمات
                        </button>
                    </div>
                </form>

                <div class="mt-4 p-3 bg-light rounded">
                    <h6>پسورد پیشنهادی بر اساس سطح انتخاب شده:</h6>
                    <div class="row mt-2">
                        <div class="col-md-4">
                            <span class="badge bg-success">آسان:</span>
                            <code class="d-block mt-1">MyPassword</code>
                            <code class="d-block">12345678</code>
                        </div>
                        <div class="col-md-4">
                            <span class="badge bg-warning text-dark">متوسط:</span>
                            <code class="d-block mt-1">MyPass123</code>
                            <code class="d-block">Password99</code>
                        </div>
                        <div class="col-md-4">
                            <span class="badge bg-danger">پیچیده:</span>
                            <code class="d-block mt-1">MyP@ssw0rd#1</code>
                            <code class="d-block">Secur3!Pass</code>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection