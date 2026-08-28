@extends('master')

@section('title')
    <title>قوانین و دستورالعمل‌ها</title>
@endsection

@section('master_content')

    <div class="mx-5 mt-3 mb-5" style="text-align: justify;">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="#">قوانین و دستورالعمل‌ها</a>
        </div>

        <h2 class="text-center mb-4">قوانین و دستورالعمل‌ها</h2>

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

    </div>

@endsection
