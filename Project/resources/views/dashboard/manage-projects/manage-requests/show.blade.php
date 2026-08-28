@extends('dashboard.index')

@section('title')
    <title>نمایش درخواست</title>
@endsection

@section('dashboard_style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/dashboard/requests/assessment.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/dashboard/requests/assessment.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/dashboard/requests/assessment.css') }}" rel="stylesheet">
    @endif
@endsection

@section('dashboard_content')

    <div class="container p-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.manage-projects.index') }}">مدیریت پروژه‌ها</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.manage-projects.manage-requests.index') }}">مدیریت درخواست‌ها</a><span class="px-1"> > </span>
            <a href="#">نمایش درخواست</a>
        </div>

        <h2 class="mb-4">نمایش درخواست</h2>

        <div class="container py-3 shadow-lg rounded overflow-hidden border border-secondary">

            <div class="row align-items-center form-header">
                <div class="d-flex col-3">
                    <div id="formLogo" class="me-2"><img src="{{ asset('icons/logo-black-name.png') }}" class="img-fluid" alt="logo"></div>
                </div>

                <h3 class="text-center col-6">فرم ۱: درخواست پیش ارزیابی</h3>

                <div class="col-3">
                    <div>شماره: {{ $fa_id }}</div>
                    <div>تاریخ: {{ $fa_date }}</div>
                </div>
            </div>

            <div class="my-4 px-2">
                <div>
                    <p style="text-align: justify;">
                        مرکز محترم پژوهشی آسا شرق<br>
                        با سلام<br>
                        احتراما در خصوص پیش ارزیابی سامانه این شرکت با مشخصات ذیل به منظور ایجاد تسهیلات در
                        اخذ مجوز افتا، دستور مقتضی صادر فرمایید. در این اقدام، فعالیت‌های زیر مورد درخواست است:
                    </p>
                </div>
            </div>

            <div class="row px-2 py-3 gx-5">
                <div class="col-md-6 align-items-center">
                    <img src="{{ $assessment_request->security_assessment ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                    پیش ارزیابی امنیتی و نفوذ <small>(Security Assessment)</small>
                </div>
                <div class="col-md-6">
                    <img src="{{ $assessment_request->quality_assessment ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                    ارزیابی کیفیت <small>(Quality Assessment)</small>
                </div>
            </div>

            <div class="row px-2 py-3 text-center">
                <h4 class="m-0">مشخصات متقاضی</h4>
            </div>

            <div class="row px-2 py-3 gx-5">
                <div class="col-md-2 col-4">
                    <img src="{{ $assessment_request->person_type === 'natural_person' ? asset('icons/radio-button-selected.svg') : asset('icons/radio-button.svg')}}" width="20">
                    حقیقی
                </div>
                <div class="col-md-2 col-4">
                    <img src="{{ $assessment_request->person_type === 'legal_person' ? asset('icons/radio-button-selected.svg') : asset('icons/radio-button.svg')}}" width="20">
                    حقوقی
                </div>
            </div>

            <div class="row px-2 py-3 gx-5 bg-secondary bg-opacity-50">
                <div class="col-md-6 mb-md-0 mb-2">
                    نام متقاضی: <span><b>{{ $assessment_request->applicant_name }}</b></span>
                </div>

               <div class="col-md-6">
                    کد ملی: <span><b>{{ $assessment_request->applicant_national_id}}</b></span>
                </div>
            </div>

            <div class="row px-2 py-3 gx-5">
                <div class="col-md-6 mb-md-0 mb-2">
                    کد اقتصادی: <span><b>{{ $assessment_request->applicant_economic_code }}</b></span>
                </div>

                <div class="col-md-6">
                    تلفن ثابت: <span><b>{{ $assessment_request->applicant_landline_phone }}</b></span>
                </div>
            </div>

            <div class="row px-2 py-3 gx-5 bg-secondary bg-opacity-50">
                <div class="col-md-6 mb-md-0 mb-2">
                    تلفن همراه: <span><b>{{ $assessment_request->applicant_mobile_phone }}</b></span>
                </div>

                <div class="col-md-6">
                    ایمیل: <span><b>{{ $assessment_request->applicant_email }}</b></span>
                </div>
            </div>

            <div class="row px-2 py-3 gx-5">
                <div class="col-md-6">
                    فکس: <span><b>{{ $assessment_request->applicant_fax }}</b></span>
                </div>
            </div>

            <div class="{{ $assessment_request->person_type === 'natural_person' ? 'opacity-50' : '' }}">
                <div class="row px-2 py-3 gx-5 bg-secondary bg-opacity-50">
                    <div class="col-md-6 mb-md-0 mb-2">
                        نام و نام خانوادگی مدیر عامل/مسئول: <span><b>{{ $assessment_request->manager_name }}</b></span>
                    </div>

                    <div class="col-md-6">
                        کد ملی مدیر عامل/مسئول: <span><b>{{ $assessment_request->manager_national_id }}</b></span>
                    </div>
                </div>

                <div class="row px-2 py-3 gx-5">
                    <div class="col-md-6 mb-md-0 mb-2">
                        شماره تماس مدیر عامل/مسئول: <span><b>{{ $assessment_request->manager_phone }}</b></span>
                    </div>

                    <div class="col-md-6">
                        شماره تماس مدیر عامل/مسئول: <span><b>{{ $assessment_request->manager_email }}</b></span>
                    </div>
                </div>

                <div class="row px-2 py-3 gx-5 bg-secondary bg-opacity-50">
                    <div class="col-md-6 mb-md-0 mb-2">
                        نام و نام خانوادگی مسئول فنی: <span><b>{{ $assessment_request->technical_manager_name }}</b></span>
                    </div>

                    <div class="col-md-6">
                        کد ملی مسئول فنی: <span><b>{{ $assessment_request->technical_manager_national_id }}</b></span>
                    </div>
                </div>

                <div class="row px-2 py-3 gx-5">
                    <div class="col-md-6 mb-md-0 mb-2">
                        شماره تماس مسئول فنی: <span><b>{{ $assessment_request->technical_manager_phone }}</b></span>
                    </div>

                    <div class="col-md-6">
                        پست الکترونیک مسئول فنی: <span><b>{{ $assessment_request->technical_manager_email }}</b></span>
                    </div>
                </div>
            </div>

            <div class="row text-center mt-2 p-2">
                <h4 class="m-0">مشخصات محصول</h4>
            </div>

            <div class="row px-2 py-3 bg-secondary bg-opacity-50">
                <div class="col-md-2 col-4">
                    <img src="{{ $assessment_request->product_type === 'local' ? asset('icons/radio-button-selected.svg') : asset('icons/radio-button.svg')}}" width="20">
                    بومی
                </div>
                <div class="col-md-2 col-4">
                    <img src="{{ $assessment_request->product_type === 'non_local' ? asset('icons/radio-button-selected.svg') : asset('icons/radio-button.svg')}}" width="20">
                    غیر بومی
                </div>
            </div>

            <div class="row px-2 py-3 gx-5">
                <div class="col-md-6 mb-md-0 mb-2">
                    نام محصول: <span><b>{{ $assessment_request->product_name }}</b></span>
                </div>
                <div class="col-md-6">
                    نام تجاری محصول: <span><b>{{ $assessment_request->product_brand_name }}</b></span>
                </div>
            </div>

            <div class="row px-2 py-3 gx-5 bg-secondary bg-opacity-50">
                <h5 dir="ltr" class="text-center">Software</h5>
                <div class="col-md-6">
                    Version: <span><b>{{ $assessment_request->software_version }}</b></span>
                </div>
            </div>

            <div class="row px-2 py-3">
                <div class="col-md-3">
                    <img src="{{ $assessment_request->client_server ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                    Client-Server
                </div>
                <div class="col-md-3">
                    <img src="{{ $assessment_request->mobile_application ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                    Mobile Application
                </div>
                <div class="col-md-3">
                    <img src="{{ $assessment_request->desktop_application ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                    Desktop Application
                </div>
                <div class="col-md-3">
                    <img src="{{ $assessment_request->web_application ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                    Web Application
                </div>
            </div>

            <div class="row px-2 py-3 bg-secondary bg-opacity-50">
                <div>
                    توصیف فنی محصول: <span><b>{{ $assessment_request->product_description }}</b></span>
                </div>
            </div>

            <div class="row d-flex align-items-center px-2 py-3">

                @if ($assessment_request->file)
                    <div>
                        فایل آپلود شده:
                        <a dir="ltr" href="{{ route('dashboard.manage-projects.manage-requests.download-file', $assessment_request->file) }}">
                            <img src="{{ asset('icons/winrar.png') }}" width="25px">
                            {{ $assessment_request->file }}
                        </a>
                    </div>
                @else
                    <span>فایل آپلود شده: -</span>
                @endif
            </div>
        </div>

        <div class="card mx-md-5 mx-2 my-5">
            <div class="card-header">چک لیست درخواست پیش ارزیابی</div>
            <div class="card-body">

                @if ($assessment_request_checklist)

                    <h5 class="mb-3">اسناد مربوط به آزمون کیفیت</h5>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_product_catalog ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        کاتالوگ معرفی کامل محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_user_manual ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند راهنمای کاربری شامل نام، توصیف نرم‌افزار، مجوز، نسخه
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_basic_procedures_description ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        توصیف رویه‌ها و توابع پایه‌ای
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_product_security_requirements ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند قابلیت‌های امنیتی محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_product_release_version ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        ارائه یک نسخه مناسب از محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_product_architecture ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند معماری محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_database_documentation ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        ارائه سند پایگاه داده سیستم
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_non_functional_requirements ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        ارائه سند نیازمندی‌های غیر کارکردی
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_system_diagrams ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        ارائه نمودارهای جریان داده، نمودارهای ساختار، فلوچارت‌های سیستم، دایرة‌المعارف داده
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_questionnaire ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        تکمیل پرسشنامه
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_manufacturer_info ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        نام، آدرس فیزیکی و کد ثبتی تولیدکننده نرم‌افزار
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_maintenance_manual ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        ارائه سند راهنمای نگهداری سیستم
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_communication_protocols ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        ارائه سند مرتبط با ارتباطات بین اجزای سیستم، پروتکل‌های ارتباطی، تکنولوژی و تمهیدات امنیتی و کیفیتی
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->qa_programming_environment ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        زبان برنامه‌نویسی، محیط تولید و پیش نیازهای اجرایی محصول
                    </div>

                    <h5 class="mt-5 mb-3">اسناد مربوط به پیش ارزیابی امنیتی و نفوذ</h5>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_product_catalog ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        کاتالوگ معرفی کامل محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_user_manual ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند راهنمای کاربری
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_product_identity ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        شناسنامه محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_product_security_requirements ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند الزامات امنیتی محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_analysis_design_doc ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند تحلیل و طراحی محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_product_architecture ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند معماری محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_security_target_doc ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند هدف امنیتی
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_product_release_version ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        ارائه یک نسخه مناسب از محصول
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_agd ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند راهنما (AGD)
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_alc ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند قابلیت‌ها و محدوده مدیریت پیکربندی (ALC)
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_adv ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند توصیف مشخصات کارکردها (ADV)
                    </div>
                    <div>
                        <img src="{{ $assessment_request_checklist->sa_crypto_capability_declaration ? asset('icons/checkbox-selected.svg') : asset('icons/checkbox.svg')}}" width="20">
                        سند خوداظهاری در خصوص قابلیت‌های رمزنگاری محصول
                    </div>

                @else
                    <div>چک لیستی برای این درخواست ثبت نشده است.</div>
                @endif

            </div>
        </div>

    </div>

@endsection
