@extends('master')

@section('title')
    <title>اهداف و ماموریت‌ها</title>
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
            <a href="#">اهداف و ماموریت‌ها</a>
        </div>

        <h2 class="mb-4 text-center">اهداف و ماموریت‌ها</h2>

        <div class="row gy-4 justify-content-center">
            <div class="d-flex col-md-3 col-6">
                <div class="card shadow-lg">
                    <img src="{{ asset('icons/vision-and-goal/target-aim-blue.svg') }}" class="card-img-top p-md-5 p-4 bg-white" alt="هدف اصلی">
                    <div class="card-body text-center">
                        <h4 class="card-title">هدف اصلی (vision)</h4>
                        <h5 class="card-text">ارتقا و تقویت امنیت فضای تبادل اطلاعات</h5>
                    </div>
                </div>
            </div>
            <div class="d-flex col-md-3 col-6">
                <div class="card shadow-lg">
                    <img src="{{ asset('icons/vision-and-goal/target-dart-board-blue.svg') }}" class="card-img-top p-md-5 p-4 bg-white" alt="هدف فرعی">
                    <div class="card-body text-center">
                        <h4 class="card-title">هدف فرعی (goal)</h4>
                        <h5 class="card-text">کارآفرینی و ترویج فرهنگ افتا</h5>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
