@extends('dashboard.index')

@section('title')
    <title>ثبت مقاله جدید</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.manage-articles.index') }}">مدیریت مقالات</a><span class="px-1"> > </span>
            <span class="text-muted">ثبت مقاله جدید</span>
        </div>

        <h2 class="mb-4">ثبت مقاله جدید</h2>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
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
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.manage-articles.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">عنوان مقاله <span class="text-danger">*</span></label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">نویسندگان <span class="text-danger">*</span></label>
                            <input type="text" name="authors" value="{{ old('authors') }}" class="form-control" placeholder="نام نویسندگان را با کاما جدا کنید" required>
                            <small class="text-muted">مثال: دکتر احمد رضایی، دکتر مریم کریمی</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">کلمات کلیدی</label>
                            <input type="text" name="keywords" value="{{ old('keywords') }}" class="form-control" placeholder="کلمات کلیدی را با کاما جدا کنید">
                            <small class="text-muted">مثال: امنیت سایبری، رمزنگاری، شبکه</small>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">توضیحات / چکیده مقاله</label>
                            <textarea name="description" rows="4" class="form-control" placeholder="توضیحات مختصری درباره مقاله وارد کنید...">{{ old('description') }}</textarea>
                            <small class="text-muted">حداکثر ۵۰۰ کاراکتر</small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">نوع مقاله <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="">انتخاب کنید...</option>
                                <option value="national" {{ old('type') == 'national' ? 'selected' : '' }}>بومی</option>
                                <option value="international" {{ old('type') == 'international' ? 'selected' : '' }}>بین‌المللی</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">سال انتشار <span class="text-danger">*</span></label>
                            <input type="text" name="publication_year" value="{{ old('publication_year') }}" class="form-control" placeholder="مثال: ۱۴۰۳ یا 2024" required>
                            <small class="text-muted">برای مقالات بومی: شمسی | برای بین‌المللی: میلادی</small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">وضعیت انتشار</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>در انتظار تایید</option>
                                <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>تایید شده</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>رد شده</option>
                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">قیمت (تومان)</label>
                            <input type="number" name="price" value="{{ old('price') }}" class="form-control" min="10000">
                            <small class="text-muted">حداقل قیمت: ۱۰,۰۰۰ تومان | در صورت رایگان بودن، تیک زیر را بزنید</small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="is_free" class="form-check-input" id="is_free" value="1" 
                                    {{ old('is_free') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_free">رایگان</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">فایل اصلی مقاله <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx" required>
                            <small class="text-muted">فرمت‌های مجاز: PDF, DOC, DOCX | حداکثر 30 مگابایت</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">فایل چکیده مقاله</label>
                            <input type="file" name="abstract_file" class="form-control" accept=".pdf,.doc,.docx">
                            <small class="text-muted">فرمت‌های مجاز: PDF, DOC, DOCX | حداکثر ۲۰ مگابایت</small>
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">ثبت مقاله</button>
                        <a href="{{ route('dashboard.manage-articles.index') }}" class="btn btn-secondary">انصراف</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@section('dashboard_script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isFreeCheckbox = document.getElementById('is_free');
    const priceInput = document.querySelector('input[name="price"]');

    if (isFreeCheckbox && priceInput) {
        isFreeCheckbox.addEventListener('change', function() {
            if (this.checked) {
                priceInput.disabled = true;
                priceInput.value = '';
                priceInput.min = 0;
            } else {
                priceInput.disabled = false;
                priceInput.min = 10000;
                priceInput.placeholder = 'حداقل ۱۰,۰۰۰ تومان';
            }
        });

        if (isFreeCheckbox.checked) {
            priceInput.disabled = true;
            priceInput.value = '';
        } else {
            priceInput.min = 10000;
        }
    }
});
</script>
@endsection