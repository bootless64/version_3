@extends('dashboard.index')

@section('title')
    <title>چک لیست درخواست پیش ارزیابی</title>
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.requests.index') }}">درخواست‌ها</a><span class="px-1"> > </span>
            <a href="#">درخواست پیش ارزیابی</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card mx-md-5 mx-2">
            <div class="card-header">چک لیست درخواست پیش ارزیابی</div>
            <div class="card-body">
                <div class="mb-4">
                    <b>لطفا اسنادی که در قالب فایل فشرده ارسال نمودید را در فرم زیر مشخص کنید:</b>
                </div>
                <form method="POST" action="{{ route('dashboard.requests.assessment.checklist.store', $assessment_request->id) }}">
                    @csrf
                    <h5 class="mb-3">اسناد مربوط به آزمون کیفیت</h5>
                    <div>
                        <input id="qa_product_catalog" name="qa_product_catalog" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="qa_product_catalog">کاتالوگ معرفی کامل محصول</label>
                    </div>
                    <div class="d-flex">
                        <input id="qa_user_manual" name="qa_user_manual" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label me-1" for="qa_user_manual">سند راهنمای کاربری شامل نام، توصیف نرم‌افزار، مجوز، نسخه</label>
                    </div>
                    <div>
                        <input id="qa_basic_procedures_description" name="qa_basic_procedures_description" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="qa_basic_procedures_description">توصیف رویه‌ها و توابع پایه‌ای</label>
                    </div>
                    <div>
                        <input id="qa_product_security_requirements" name="qa_product_security_requirements" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="qa_product_security_requirements">سند قابلیت‌های امنیتی محصول</label>
                    </div>
                    <div>
                        <input id="qa_product_release_version" name="qa_product_release_version" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="qa_product_release_version">ارائه یک نسخه مناسب از محصول</label>
                    </div>
                    <div>
                        <input id="qa_product_architecture" name="qa_product_architecture" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="qa_product_architecture">سند معماری محصول</label>
                    </div>
                    <div>
                        <input id="qa_database_documentation" name="qa_database_documentation" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="qa_database_documentation">ارائه سند پایگاه داده سیستم</label>
                    </div>
                    <div>
                        <input id="qa_non_functional_requirements" name="qa_non_functional_requirements" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="qa_non_functional_requirements">ارائه سند نیازمندی‌های غیر کارکردی</label>
                    </div>
                    <div class="d-flex">
                        <input id="qa_system_diagrams" name="qa_system_diagrams" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label me-1" for="qa_system_diagrams">ارائه نمودارهای جریان داده، نمودارهای ساختار، فلوچارت‌های سیستم، دایرة‌المعارف داده</label>
                    </div>
                    <div>
                        <input id="qa_questionnaire" name="qa_questionnaire" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="qa_questionnaire">تکمیل پرسشنامه</label>
                    </div>
                    <div class="d-flex">
                        <input id="qa_manufacturer_info" name="qa_manufacturer_info" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label me-1" for="qa_manufacturer_info">نام، آدرس فیزیکی و کد ثبتی تولیدکننده نرم‌افزار</label>
                    </div>
                    <div>
                        <input id="qa_maintenance_manual" name="qa_maintenance_manual" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="qa_maintenance_manual">ارائه سند راهنمای نگهداری سیستم</label>
                    </div>
                    <div class="d-flex">
                        <input id="qa_communication_protocols" name="qa_communication_protocols" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label me-1" for="qa_communication_protocols">ارائه سند مرتبط با ارتباطات بین اجزای سیستم، پروتکل‌های ارتباطی، تکنولوژی و تمهیدات امنیتی و کیفیتی</label>
                    </div>
                    <div class="d-flex">
                        <input id="qa_programming_environment" name="qa_programming_environment" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label me-1" for="qa_programming_environment">زبان برنامه‌نویسی، محیط تولید و پیش نیازهای اجرایی محصول</label>
                    </div>

                    <h5 class="mt-5 mb-3">اسناد مربوط به پیش ارزیابی امنیتی و نفوذ</h5>
                    <div>
                        <input id="sa_product_catalog" name="sa_product_catalog" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_product_catalog">کاتالوگ معرفی کامل محصول</label>
                    </div>
                    <div>
                        <input id="sa_user_manual" name="sa_user_manual" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_user_manual">سند راهنمای کاربری</label>
                    </div>
                    <div>
                        <input id="sa_product_identity" name="sa_product_identity" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_product_identity">شناسنامه محصول</label>
                    </div>
                    <div>
                        <input id="sa_product_security_requirements" name="sa_product_security_requirements" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_product_security_requirements">سند الزامات امنیتی محصول</label>
                    </div>
                    <div>
                        <input id="sa_analysis_design_doc" name="sa_analysis_design_doc" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_analysis_design_doc">سند تحلیل و طراحی محصول</label>
                    </div>
                    <div>
                        <input id="sa_product_architecture" name="sa_product_architecture" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_product_architecture">سند معماری محصول</label>
                    </div>
                    <div>
                        <input id="sa_security_target_doc" name="sa_security_target_doc" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_security_target_doc">سند هدف امنیتی</label>
                    </div>
                    <div>
                        <input id="sa_product_release_version" name="sa_product_release_version" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_product_release_version">ارائه یک نسخه مناسب از محصول</label>
                    </div>
                    <div>
                        <input id="sa_agd" name="sa_agd" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_agd">سند راهنما (AGD)</label>
                    </div>
                    <div class="d-flex">
                        <input id="sa_alc" name="sa_alc" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label me-1" for="sa_alc">سند قابلیت‌ها و محدوده مدیریت پیکربندی (ALC)</label>
                    </div>
                    <div>
                        <input id="sa_adv" name="sa_adv" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label" for="sa_adv">سند توصیف مشخصات کارکردها (ADV)</label>
                    </div>
                    <div class="d-flex">
                        <input id="sa_crypto_capability_declaration" name="sa_crypto_capability_declaration" type="checkbox" value="1" class="form-check-input border-dark">
                        <label class="form-check-label me-1" for="sa_crypto_capability_declaration">سند خوداظهاری در خصوص قابلیت‌های رمزنگاری محصول</label>
                    </div>

                    <div class="d-flex justify-content-center my-4">
                        <button type="submit" class="btn btn-primary">ثبت فرم</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
