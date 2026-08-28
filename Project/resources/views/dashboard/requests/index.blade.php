@extends('dashboard.index')

@section('title')
    <title>درخواست‌ها</title>
@endsection

@section('dashboard_style')
    <link href="{{ asset('photoswipe-5.4.4/photoswipe.css') }}" rel="stylesheet">
@endsection

@section('dashboard_content')

    <div class="container py-4">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="{{ route('dashboard.index') }}">داشبورد</a><span class="px-1"> > </span>
            <a href="#">درخواست‌ها</a>
        </div>

        <h2 class="mb-4">درخواست‌ها</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-4 px-2" style="text-align: justify">
            <p>برای ثبت درخواست، آزمون مورد نظر را انتخاب کرده، موارد خواسته شده را با دقت تکمیل نمایید
                و اسناد مربوطه (لیست اسناد به مشروح، در بخش آپلود اسناد ذکر شده) را آپلود نمایید. پس از تایید درخواست، نتیجه و ادامه کار از بخش
                <i class="px-1">پروژه‌های من </i>
                قابل پیگیری است. برای اطلاع دقیق‌تر از روند پروژه می‌توانید به فلوچارت فرایند اجرایی مرکز مراجعه نمایید.
            </p>
        </div>

        <div class="mb-5 gallery1">
            <a href="{{ asset('images/diagrams/Process-Flowchart.jpg') }}" data-pswp-width="16384" data-pswp-height="5663">
                <img src="{{ asset('images/diagrams/Process-Flowchart.jpg') }}" class="img-fluid rounded shadow-lg" style="cursor:zoom-in" alt="گردش کاری">
            </a>
        </div>

        <div class="mb-5">
            <a href="{{ route('dashboard.requests.assessment') }}" class="btn btn-outline-primary">
                درخواست پیش ارزیابی
            </a>
        </div>

        <div>
            <a href="https://sec.ito.gov.ir/fa/news/130/%D9%81%D8%B1%D9%85%E2%80%8C%D9%87%D8%A7-%D8%AF%D8%B3%D8%AA%D9%88%D8%B1%D8%A7%D9%84%D8%B9%D9%85%D9%84%E2%80%8C%D9%87%D8%A7-
                %D9%88-%D8%A7%D8%B3%D8%AA%D8%A7%D9%86%D8%AF%D8%A7%D8%B1%D8%AF%D9%87%D8%A7-%D8%A7%D8%B1%D8%B2%DB%8C%D8%A7%D8%A8%DB%8C-%D8%A7%D9%85%D9%86%DB%8C%D8%AA%DB%8C-
                %D9%85%D8%AD%D8%B5%D9%88%D9%84%D8%A7%D8%AA-" target="_blank">راهنمای فرم‌ها، دستورالعمل‌ها و استانداردها (ارزیابی امنیتی محصولات) - وبسایت معاونت افتا</a>
        </div>
    </div>
@endsection

@section('dashboard_script')
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
    </script>
@endsection
