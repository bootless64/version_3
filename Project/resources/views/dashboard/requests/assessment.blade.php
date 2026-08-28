@extends('dashboard.index')

@section('title')
    <title>درخواست پیش ارزیابی</title>
@endsection

@section('dashboard_style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/dashboard/requests/assessment.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/dashboard/requests/assessment.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/dashboard/requests/assessment.css') }}" rel="stylesheet">
    @endif
@endsection

@section('dashboard_content')

    <div class="conatiner p-4 mx-auto">

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

        <div class="container py-3 shadow-lg rounded overflow-hidden border border-secondary">
            <form method="POST" action="{{ route('dashboard.requests.assessment.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row align-items-center form-header">
                    <div class="d-flex col-3">
                        <div id="formLogo" class="me-2"><img src="{{ asset('icons/logo-black-name.png') }}" class="img-fluid" alt="logo"></div>
                    </div>

                    <h3 class="text-center col-6">فرم ۱: درخواست پیش ارزیابی</h3>

                    <div class="col-3">
                        <div>شماره <small>(موقت):</small> {{ $temp_number }}</div>
                        <div>تاریخ: {{ $date }}</div>
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

                <div class="row p-2 gx-5">
                    <div class="col-md-6">
                        <input id="security_assessment" name="security_assessment" type="checkbox" value="1" {{ old('security_assessment') ? 'checked' : '' }} class="form-check-input border-dark">
                        <label for="security_assessment" class="form-check-label">پیش ارزیابی امنیتی و نفوذ <small>(Security Assessment)</small></label>
                    </div>
                    <div class="col-md-6">
                        <input id="quality_assessment" name="quality_assessment" type="checkbox" value="1" {{ old('quality_assessment') ? 'checked' : '' }} class="form-check-input border-dark">
                        <label for="quality_assessment" class="form-check-label">ارزیابی کیفیت <small>(Quality Assessment)</small></label>
                    </div>
                    <div class="mt-3 text-muted">(بر اساس ISO/IEC 25000)</div>
                </div>

                <div class="row p-2 text-center">
                    <h4 class="m-0">مشخصات متقاضی</h4>
                </div>

                <div class="row p-2 gx-5">
                    <div class="col-md-2 col-4">
                        <input id="natural_person" name="person_type" type="radio" value="natural_person" {{ old('person_type') === 'natural_person' ? 'checked' : '' }} class="form-check-input border-dark">
                        <label for="natural_person" class="form-check-label">حقیقی</label>
                    </div>
                    <div class="col-md-2 col-4">
                        <input id="legal_person" name="person_type" type="radio" value="legal_person" {{ old('person_type') === 'legal_person' ? 'checked' : '' }} class="form-check-input border-dark">
                        <label for="legal_person" class="form-check-label">حقوقی</label>
                    </div>
                </div>

                <div class="row p-2 gx-5 bg-secondary bg-opacity-50">
                    <label for="applicant_name" class="col-md-3 col-6 col-form-label">نام متقاضی:</label>
                    <div class="col-md-3 col-6 mb-md-0 mb-2">
                        <input id="applicant_name" name="applicant_name" type="text" value="{{ old('applicant_name') }}" class="form-control border-secondary">
                    </div>

                    <label for="applicant_national_id" class="col-md-3 col-6 col-form-label">کد ملی:</label>
                    <div class="col-md-3 col-6">
                        <input id="applicant_national_id" name="applicant_national_id" type="text" value="{{ old('applicant_national_id') }}" class="form-control border-secondary">
                    </div>
                </div>

                <div class="row p-2 gx-5">
                    <label for="applicant_economic_code" class="col-md-3 col-6 col-form-label">کد اقتصادی:</label>
                    <div class="col-md-3 col-6 mb-md-0 mb-2">
                        <input id="applicant_economic_code" name="applicant_economic_code" type="text" value="{{ old('applicant_economic_code') }}" class="form-control border-secondary">
                    </div>

                    <label for="applicant_landline_phone" class="col-md-3 col-6 col-form-label">تلفن ثابت:</label>
                    <div class="col-md-3 col-6">
                        <input id="applicant_landline_phone" name="applicant_landline_phone" type="tel" value="{{ old('applicant_landline_phone') }}" class="form-control border-secondary">
                    </div>
                </div>

                <div class="row p-2 gx-5 bg-secondary bg-opacity-50">
                    <label for="applicant_mobile_phone" class="col-md-3 col-6 col-form-label">تلفن همراه:</label>
                    <div class="col-md-3 col-6 mb-md-0 mb-2">
                        <input id="applicant_mobile_phone" name="applicant_mobile_phone" type="tel" value="{{ old('applicant_mobile_phone') }}" class="form-control border-secondary">
                    </div>

                    <label for="applicant_email" class="col-md-3 col-6 col-form-label">ایمیل:</label>
                    <div class="col-md-3 col-6">
                        <input id="applicant_email" name="applicant_email" type="text" value="{{ old('applicant_email') }}" class="form-control border-secondary">
                    </div>
                </div>

                <div class="row p-2 gx-5">
                    <label for="applicant_fax" class="col-md-3 col-6 col-form-label">فکس:</label>
                    <div class="col-md-3 col-6">
                        <input id="applicant_fax" name="applicant_fax" type="text" value="{{ old('applicant_fax') }}" class="form-control border-secondary">
                    </div>
                </div>

                <div id="legalPersonFields" class="row collapse {{ old('person_type') === 'legal_person' ? 'show' : '' }}">
                    <div>
                        <div class="row p-2 gx-5 bg-secondary bg-opacity-50">
                            <label for="manager_name" class="col-md-3 col-6 col-form-label">نام و نام خانوادگی مدیر عامل/مسئول:</label>
                            <div class="col-md-3 col-6 mb-md-0 mb-2">
                                <input id="manager_name" name="manager_name" type="text" value="{{ old('manager_name') }}" class="form-control border-secondary">
                            </div>

                            <label for="manager_national_id" class="col-md-3 col-6 col-form-label">کد ملی مدیر عامل/مسئول:</label>
                            <div class="col-md-3 col-6">
                                <input id="manager_national_id" name="manager_national_id" type="text" value="{{ old('manager_national_id') }}" class="form-control border-secondary">
                            </div>
                        </div>

                        <div class="row p-2 gx-5">
                            <label for="manager_phone" class="col-md-3 col-6 col-form-label">شماره تماس مدیر عامل/مسئول:</label>
                            <div class="col-md-3 col-6 mb-md-0 mb-2">
                                <input id="manager_phone" name="manager_phone" type="text" value="{{ old('manager_phone') }}" class="form-control border-secondary">
                            </div>

                            <label for="manager_email" class="col-md-3 col-6 col-form-label">پست الکترونیک مدیر عامل/مسئول:</label>
                            <div class="col-md-3 col-6">
                                <input id="manager_email" name="manager_email" type="text" value="{{ old('manager_email') }}" class="form-control border-secondary">
                            </div>
                        </div>

                        <div class="row p-2 gx-5 bg-secondary bg-opacity-50">
                            <label for="technical_manager_name" class="col-md-3 col-6 col-form-label">نام و نام خانوادگی مسئول فنی:</label>
                            <div class="col-md-3 col-6 mb-md-0 mb-2">
                                <input id="technical_manager_name" name="technical_manager_name" type="text" value="{{ old('technical_manager_name') }}" class="form-control border-secondary">
                            </div>

                            <label for="technical_manager_national_id" class="col-md-3 col-6 col-form-label">کد ملی مسئول فنی:</label>
                            <div class="col-md-3 col-6">
                                <input id="technical_manager_national_id" name="technical_manager_national_id" type="text" value="{{ old('technical_manager_national_id') }}" class="form-control border-secondary">
                            </div>
                        </div>

                        <div class="row p-2 gx-5">
                            <label for="technical_manager_phone" class="col-md-3 col-6 col-form-label">شماره تماس مسئول فنی:</label>
                            <div class="col-md-3 col-6 mb-md-0 mb-2">
                                <input id="technical_manager_phone" name="technical_manager_phone" type="text" value="{{ old('technical_manager_phone') }}" class="form-control border-secondary">
                            </div>

                            <label for="technical_manager_email" class="col-md-3 col-6 col-form-label">پست الکترونیک مسئول فنی:</label>
                            <div class="col-md-3 col-6">
                                <input id="technical_manager_email" name="technical_manager_email" type="text" value="{{ old('technical_manager_email') }}" class="form-control border-secondary">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-center mt-2 p-2">
                    <h4 class="m-0">مشخصات محصول</h4>
                </div>

                <div class="row p-2 bg-secondary bg-opacity-50">
                    <div class="col-md-2 col-4">
                        <input id="local" name="product_type" type="radio" value="local" {{ old('product_type') === 'local' ? 'checked' : '' }} class="form-check-input border-dark">
                        <label class="form-check-label" for="local">بومی</label>
                    </div>
                    <div class="col-md-2 col-4">
                        <input id="non_local" name="product_type" type="radio" value="non_local" {{ old('product_type') === 'non_local' ? 'checked' : '' }} class="form-check-input border-dark">
                        <label class="form-check-label" for="non_local">غیر بومی</label>
                    </div>
                </div>

                <div class="row p-2 gx-5">
                    <label for="product_name" class="col-md-3 col-6 col-form-label">نام محصول:</label>
                    <div class="col-md-3 col-6 mb-md-0 mb-2">
                        <input id="product_name" name="product_name" type="text" value="{{ old('product_name') }}" class="form-control border-secondary">
                    </div>
                    <label for="product_brand_name" class="col-md-3 col-6 col-form-label">نام تجاری محصول:</label>
                    <div class="col-md-3 col-6">
                        <input id="product_brand_name" name="product_brand_name" type="text" value="{{ old('product_brand_name') }}" class="form-control border-secondary">
                    </div>
                </div>

                <div class="row p-2 gx-5 bg-secondary bg-opacity-50">
                    <h5 dir="ltr" class="text-center">Software</h5>
                    <label for="software_version" class="col-md-3 col-6 col-form-label">Version:</label>
                    <div class="col-md-3 col-6">
                        <input id="software_version" name="software_version" type="text" value="{{ old('software_version') }}" class="form-control border-secondary">
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-3">
                        <input id="client_server" name="client_server" type="checkbox" value="1" {{ old('client_server') ? 'checked' : '' }} class="form-check-input border-dark">
                        <label class="form-check-label" for="client_server">Client-Server</label>
                    </div>
                    <div class="col-md-3">
                        <input id="mobile_application" name="mobile_application" type="checkbox" value="1" {{ old('mobile_application') ? 'checked' : '' }} class="form-check-input border-dark">
                        <label class="form-check-label" for="mobile_application">Mobile Application</label>
                    </div>
                    <div class="col-md-3">
                        <input id="desktop_application" name="desktop_application" type="checkbox" value="1" {{ old('desktop_application') ? 'checked' : '' }} class="form-check-input border-dark">
                        <label class="form-check-label" for="desktop_application">Desktop Application</label>
                    </div>
                    <div class="col-md-3">
                        <input id="web_application" name="web_application" type="checkbox" value="1" {{ old('web_application') ? 'checked' : '' }} class="form-check-input border-dark">
                        <label class="form-check-label" for="web_application">Web Application</label>
                    </div>
                </div>

                <div class="row p-2 bg-secondary bg-opacity-50">
                    <label for="product_description" class="col-form-label">توصیف فنی محصول:</label>
                    <div>
                        <input id="product_description" name="product_description" type="text" value="{{ old('product_description') }}" class="form-control border-secondary">
                    </div>
                </div>

                <div class="row p-2">
                    <div id="mainAccordion" class="accordion mb-4">
                        <div class="accordion-item">
                            <h4 class="accordion-header">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#section1">
                                    <span class="mx-2">اسناد مربوط به آزمون کیفیت</span>
                                </button>
                            </h4>
                            <div id="section1" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div>
                                        <ol>
                                            <li>کاتالوگ معرفی کامل محصول</li>
                                            <li>سند راهنمای کاربری شامل نام، توصیف نرم‌افزار، مجوز، نسخه</li>
                                            <li>توصیف رویه‌ها و توابع پایه‌ای</li>
                                            <li>سند قابلیت‌های امنیتی محصول</li>
                                            <li>ارائه یک نسخه مناسب از محصول</li>
                                            <li>سند معماری محصول (چنانچه محصول تولید داخل باشد)</li>
                                            <li>ارائه سند پایگاه داده سیستم</li>
                                            <li>ارائه سند نیازمندی‌های غیر کارکردی (شامل: سند fault tolerance، راه حل‌های در نظر گرفته شده به جهت فراهم شدن performance بالای نرم‌افزار، <u>ادعای مطرح شده</u> در رابطه با performance نرم‌افزار، محدودیت‌های طراحی)</li>
                                            <li>ارائه نمودارهای جریان داده، نمودارهای ساختار، فلوچارت‌های سیستم، دایرة‌المعارف داده</li>
                                            <li>تکمیل پرسشنامه (در صورت نیاز)</li>
                                            <li>نام، آدرس فیزیکی و کد ثبتی تولیدکننده نرم‌افزار</li>
                                            <li>ارائه سند راهنمای نگهداری سیستم</li>
                                            <li>ارائه سند مرتبط با ارتباطات بین اجزای سیستم، پروتکل‌های ارتباطی، تکنولوژی و تمهیدات امنیتی و کیفیتی</li>
                                            <li>زبان برنامه‌نویسی، محیط تولید و پیش نیازهای اجرایی محصول</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h4 class="accordion-header">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#section2">
                                    <span class="mx-2">اسناد مربوط به پیش ارزیابی امنیتی و نفوذ</span>
                                </button>
                            </h4>
                            <div id="section2" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <div>
                                        <ol>
                                            <li><a href="{{ asset('files/product-documentation/product-catalog.docx') }}">کاتالوگ معرفی کامل محصول</a><small> (متقاضی محترم، با دانلود فایل نسبت به تکمیل سند و آپلود آن اقدام فرمایید)</small></li>
                                            <li><a href="{{ asset('files/product-documentation/product-manual.docx') }}">سند راهنمای کاربری</a><small> (متقاضی محترم، با دانلود فایل نسبت به تکمیل سند و آپلود آن اقدام فرمایید)</small></li>
                                            <li><a href="{{ asset('files/product-documentation/product-profile.docx') }}">شناسنامه محصول</a><small> (متقاضی محترم، با دانلود فایل نسبت به تکمیل سند و آپلود آن اقدام فرمایید)</small></li>
                                            <li><a href="{{ asset('files/product-documentation/product-security-requirements.docx') }}">سند الزامات امنیتی محصول</a><small> (متقاضی محترم، با دانلود فایل نسبت به تکمیل سند و آپلود آن اقدام فرمایید)</small></li>
                                            <li>سند تحلیل و طراحی محصول</li>
                                            <li>سند معماری محصول</li>
                                            <li>سند هدف امنیتی</li>
                                            <li>ارائه یک نسخه مناسب از محصول</li>
                                            <li>سند راهنما (AGD)</li>
                                            <li>سند قابلیت‌ها و محدوده مدیریت پیکربندی (ALC)</li>
                                            <li>سند توصیف مشخصات کارکردها (ADV)</li>
                                            <li>سند خوداظهاری در خصوص قابلیت‌های رمزنگاری محصول</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2" style="text-align: justify">
                        لطفا پس از تکمیل اسناد ارزیابی، تمامی فایل‌ها را به صورت یک فایل فشرده بدون رمز آپلود کنید.
                        حداکثر حجم مجاز فایل، ۲۵ مگابایت است.
                    </div>

                    <div class="p-2 mb-2">
                        <label for="file" class="form-label">آپلود اسناد ارزیابی:</label>
                        <input id="file" name="file" type="file" class="form-control" accept=".zip, .rar">
                    </div>

                    <div class="mb-4" style="text-align: justify">
                        پس از تایید درخواست، می‌توانید برای مشاهده نتیجه درخواست و ادامه پروژه، از بخش
                        <i class="px-1">پروژه‌های من </i>
                        پیگیری نمایید.
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="{{ route('dashboard.requests.index') }}" class="btn btn-outline-secondary">بازگشت</a>

                        <button type="submit" class="btn btn-primary mx-2">ثبت درخواست</button>

                        <a href="{{ route('dashboard.index') }}" class="btn btn-outline-secondary">انصراف</a>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection

@section('dashboard_script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const naturalPersonButton = document.getElementById('natural_person');
            const legalPersonButton = document.getElementById('legal_person');
            const legalPersonFields = document.getElementById('legalPersonFields');
            const collapse = new bootstrap.Collapse(document.getElementById('legalPersonFields'), {
                toggle: false
            });

            function toggleCollapse() {
                if (legalPersonButton.checked) {
                    collapse.show();
                }
                else {
                    collapse.hide();
                }
            }

            naturalPersonButton.addEventListener('change', toggleCollapse);
            legalPersonButton.addEventListener('change', toggleCollapse);
        });
    </script>
@endsection
