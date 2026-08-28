@extends('master')

@section('title')
    <title>سازمان کاری</title>
@endsection

@section('style')
    <link href="{{ asset('photoswipe-5.4.4/photoswipe.css') }}" rel="stylesheet">

    <style>
        .pswp__button {
            width: 65px;
            height: 65px;
        }
        .pswp__icn {
            width: 50px;
            height: 50px;
        }
    </style>
@endsection

@section('master_content')

    <div class="mx-5 mt-3 mb-5" style="text-align: justify;">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="#">سازمان کاری</a>
        </div>

        <h2 class="text-center">سازمان کاری</h2>
        <br>
        <h4 class="mb-3">خدمات:</h4>
        <p>
            خدمات مرکز آسا شرق به منظور ارزیابی محصول جهت تطبیق با
            "آیین نامه‌های اجرایی و مقررات "افتا"، استاندارد امنیت نرم‌افزار ISO/IEC 15408، استاندارد
            کیفیت نرم‌افزار ISO/IEC 25000، استانداردهای ایزو" طراحی شده است. در این فرآیند، به منظور انطباق محصول با این استانداردها، متقاضی
            امکان انتخاب یکی از چند گزینه را دارد.
        </p>
        <p>
            گزینه اول، استقرار استانداردها توسط متقاضی: متقاضی می‌تواند رأسا نسبت به استقرار استانداردها اقدام نماید. در صورت درخواست متقاضی برای توانمندسازی
            جهت استقرار این استانداردها، آکادمی آسا شرق طی قراردادی متولی توانمندسازی متقاضی در قالب مربیگری خواهد بود.
        </p>
        <p>
            گزینه دوم، استقرار استانداردها توسط مرکز: متقاضی می‌تواند طی قراردادی استانداردسازی محصول را تا نتیجه نهایی به مرکز محول نماید.
        </p>
        <p>
            در صورتی که استقرار استانداردها برای محصول ارائه شده توسط متقاضی
            نیازمند انجام پیش تست‌های نرم‌افزاری باشد، این پیش تست‌ها توسط مرکز انجام خواهد شد.
        </p>
        <br>

        <h4 class="mb-4">گردش کاری:</h4>
        <div class="mb-4 gallery1">
            <a href="{{ asset('images/diagrams/Process-Flowchart.jpg') }}" data-pswp-width="16384" data-pswp-height="5663">
                <img src="{{ asset('images/diagrams/Process-Flowchart.jpg') }}" class="img-fluid rounded shadow-lg" style="cursor:zoom-in" alt="گردش کاری">
            </a>
        </div>

        <ul class="list-unstyled text-end">
            <h5>استانداردهای ISO: </h5>
            <li dir="ltr"><a href="{{ asset('files/ISO-15408/1.INSO-ISO-IEC-15408-1.pdf') }}" target="_blank">1.INSO-ISO-IEC-15408-1.pdf</a></li>
            <li dir="ltr"><a href="{{ asset('files/ISO-15408/1.INSO-ISO-IEC-15408-2.pdf') }}" target="_blank">1.INSO-ISO-IEC-15408-2.pdf</a></li>
            <li dir="ltr"><a href="{{ asset('files/ISO-15408/1.INSO-ISO-IEC-15408-3.pdf') }}" target="_blank">1.INSO-ISO-IEC-15408-3.pdf</a></li>
            <li dir="ltr"><a href="{{ asset('files/ISO-15408/2.ISO_IEC_15408-Part1.pdf') }}" target="_blank">2.ISO_IEC_15408-Part1.pdf</a></li>
            <li dir="ltr"><a href="{{ asset('files/ISO-15408/2.ISO_IEC_15408-Part2.pdf') }}" target="_blank">2.ISO_IEC_15408-Part2.pdf</a></li>
            <li dir="ltr"><a href="{{ asset('files/ISO-15408/2.ISO_IEC_15408-Part3.pdf') }}" target="_blank">2.ISO_IEC_15408-Part3.pdf</a></li>
        </ul>

        <ul class="list-unstyled">
            <h5>پروفایل حفاظتی: </h5>
            <li><a href="{{ asset('files/protection-profile/web_application.pdf') }}" target="_blank">برنامه کاربردی (تحت وب)</a></li>
            <li><a href="{{ asset('files/protection-profile/desktop_application.pdf') }}" target="_blank">برنامه کاربردی (دسکتاپ)</a></li>
            <li><a href="{{ asset('files/protection-profile/content_management_portal.pdf') }}" target="_blank">مدیریت محتوی و پرتال</a></li>
        </ul>

        <ul class="list-unstyled">
            <h5>لینک‌های مفید: </h5>
            <li>
                <a href="https://sec.ito.gov.ir/fa/news/131/%D9%BE%D8%B1%D9%88%D9%81%D8%A7%DB%8C%D9%84%E2%80%8C%D9%87%D8%A7%DB%8C-
                    %D8%AD%D9%81%D8%A7%D8%B8%D8%AA%DB%8C-%D9%88-%D8%A7%D9%84%D8%B2%D8%A7%D9%85%D8%A7%D8%AA-
                    %D8%A7%D9%85%D9%86%DB%8C%D8%AA%DB%8C" target="_blank">پروفایل‌های حفاظتی و الزامات امنیتی - وبسایت معاونت افتا</a>
            </li>
            <li>
                <a href="https://sec.ito.gov.ir/fa/news/130/%D9%81%D8%B1%D9%85%E2%80%8C%D9%87%D8%A7-%D8%AF%D8%B3%D8%AA%D9%88%D8%B1%D8%A7%D9%84%D8%B9%D9%85%D9%84%E2%80%8C%D9%87%D8%A7-
                    %D9%88-%D8%A7%D8%B3%D8%AA%D8%A7%D9%86%D8%AF%D8%A7%D8%B1%D8%AF%D9%87%D8%A7-%D8%A7%D8%B1%D8%B2%DB%8C%D8%A7%D8%A8%DB%8C-%D8%A7%D9%85%D9%86%DB%8C%D8%AA%DB%8C-
                    %D9%85%D8%AD%D8%B5%D9%88%D9%84%D8%A7%D8%AA-" target="_blank">فرم‌ها، دستورالعمل‌ها و استانداردها (ارزیابی امنیتی محصولات) - وبسایت معاونت افتا</a>
            </li>
            <li>
                <a href="https:
            </li>
            <li>
                <a href="https:
            </li>
        </ul>

        <br>

        <h4 class="mb-3">چارت سازمانی:</h4>
        <div class="mb-5 gallery2">
            <a href="{{ asset('images/diagrams/Organizational-Chart.jpg') }}" data-pswp-width="2613" data-pswp-height="1433">
                <img src="{{ asset('images/diagrams/Organizational-Chart.jpg') }}" class="img-fluid rounded shadow-lg" style="cursor:zoom-in" alt="چارت سازمانی">
            </a>
        </div>
        <div class="mb-5">
            <a href="{{ asset('files/asa-shargh-center-responsibilities.pdf') }}" target="_blank"><b>شرح وظایف مرکز آسا شرق</b></a>
        </div>
        <br>

        <h4 class="mb-3">حوزه‌ی کاری:</h4>
        <ol>
            <li>ممیزی و پایش اولیه مستندات و اسناد نرم افزار در تطبیق با آیین‌نامه های اجرایی و مقررات "افتا"</li>
            <li>مربیگری رفع نقائص مستندات</li>
            <li>انجام پیش تست‌های امنیتی و نفوذ</li>
            <li>ارزیابی، ممیزی و پایش اولیه خدمات نرم‌افزار در تطبیق با آیین‌نامه‌های اجرایی و مقررات "افتا"</li>
            <li>مربیگری رفع نقائص و خطاهای امنیتی نرم افزار</li>
            <li>استقرار استاندارد امنیت نرم‌افزار (استاندارد 15408 ISO/IEC)</li>
            <li>استقرار استاندارد کیفیت نرم‌افزار (استاندارد 25000 ISO/IEC)</li>
            <li>توانمندسازی کارگاهی توسط آکادمی مرکز</li>
        </ol>

    </div>

@endsection

@section('script')
    <script src="{{ asset('photoswipe-5.4.4/umd/photoswipe.umd.min.js') }}"></script>
    <script src="{{ asset('photoswipe-5.4.4/umd/photoswipe-lightbox.umd.min.js') }}"></script>

    <script>
        const lightbox1 = new PhotoSwipeLightbox({
            gallery: '.gallery1',
            children: 'a',
            pswpModule: PhotoSwipe,
            wheelToZoom: true,
            initialZoomLevel: 'fit',
            maxZoomLevel: 0.5,
        });
        lightbox1.init();

        const lightbox2 = new PhotoSwipeLightbox({
            gallery: '.gallery2',
            children: 'a',
            pswpModule: PhotoSwipe,
            wheelToZoom: true,
            initialZoomLevel: 'fit',
            maxZoomLevel: 3,
        });
        lightbox2.init();
    </script>
@endsection
