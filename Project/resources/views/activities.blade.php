@extends('master')

@section('title')
    <title>فعالیت‌ها</title>
@endsection

@section('style')
    <style>
        .card:hover {
            color: white;
            background-color: #343a40;
            transform: translateY(-10px);
            transition: background-color 0.5s ease, color 0.5s ease, transform 0.5s ease;
        }
    </style>
@endsection

@section('master_content')

    <div class="mx-5 mt-3 mb-5">

        <div class="page-path mb-3">
            <a href="{{ route('home') }}">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="#">فعالیت‌ها</a>
        </div>

        <h2 class="mb-4 text-center">فعالیت‌ها</h2>

        <div class="row justify-content-center gy-4 mb-4">
            <div class="d-flex col-md-3 col-6">
                <div class="card shadow-lg">
                    <img src="{{ asset('icons/activities/software-platform.svg') }}" class="card-img-top p-md-5 p-4 bg-white" alt="پیش ارزیابی محصولات نرم‌افزاری">
                    <div class="card-body">
                        <h5 class="card-title text-center">پیش ارزیابی محصولات نرم‌افزاری</h5>
                    </div>
                </div>
            </div>

            <div class="d-flex col-md-3 col-6">
                <div class="card shadow-lg">
                    <img src="{{ asset('icons/activities/learning.svg') }}" class="card-img-top p-4 bg-white" alt="توانمندسازی نیروی انسانی">
                    <div class="card-body">
                        <h5 class="card-title text-center">توانمندسازی نیروی انسانی</h5>
                    </div>
                </div>
            </div>

            <div class="d-flex col-md-3 col-6">
                <div class="card shadow-lg">
                    <img src="{{ asset('icons/activities/talent-discovery.svg') }}" class="card-img-top p-4 bg-white" alt="برگزاری رویدادها و استعدادیابی">
                    <div class="card-body">
                        <h5 class="card-title text-center">برگزاری رویدادها و استعدادیابی</h5>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
