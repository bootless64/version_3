@extends('master')

@section('title')
    <title>صفحه اصلی</title>
@endsection

@section('style')
    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/home.css')}}" rel="stylesheet">
    @else
        <link href="{{ asset('css/home.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/home.css') }}" rel="stylesheet">
    @endif
@endsection

@section('master_content')

    <div class="container text-center py-3">
        <h1><strong>مرکز پژوهشی امنیت سایبری شرق</strong></h1>
    </div>

    <div class="container">

        <section id="mainCarousel" class="carousel slide mb-5" data-bs-ride="carousel">

            <div class="carousel-indicators d-none d-md-flex">
                @foreach ($slides as $index => $slide)
                    <button type="button" data-bs-target="#mainCarousel"
                        data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>

            <div class="carousel-inner">
                @foreach ($slides as $index => $slide)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/sliders/' . $slide->image) }}" class="w-100 h-100" alt="slide {{ $index }}">
                        @if ($slide->title || $slide->description || $slide->button_text)
                            <div class="carousel-caption">
                                <h3>{{ $slide->title }}</h3>
                                <p class="d-sm-block d-none px-5">{{ $slide->description }}</p>
                                <a href="{{ $slide->button_link }}" class="btn btn-primary">{{ $slide->button_text }}</a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </section>

        <section class="mb-5">
            <hr>
            <h4 class="text-center my-3"><strong>فعالیت‌های مرکز</strong></h4>
            <hr>
            <div class="row gy-4 justify-content-center">
                
                <div class="col-lg-4 col-sm-6">
                    <div class="card shadow-lg">
                        <img src="{{ asset('images/cyber-security-10.jpg') }}" class="card-img-top" alt="پیش ارزیابی">
                        <div class="card-body">
                            <h5 class="card-title text-center">پیش ارزیابی محصولات نرم‌افزاری</h5>
                            <p class="card-text">طبق قوانین معاونت امنیت فضای تولید و تبادل اطلاعات، کلیه نرم‌افزارهای قابل اجرا در فضای مجازی ملزم به رعایت استانداردهای امنیتی می‌باشند. پیش ارزیابی محصولات نرم‌افزاری جهت بررسی تطابق عملکرد آن‌ها با این استانداردها از جمله وظایف این بخش است.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card shadow-lg">
                        <img src="{{ asset('images/training-1.jpg') }}" class="card-img-top" alt="پیش تست امنیتی و نفوذ">
                        <div class="card-body">
                            <h5 class="card-title text-center">توانمندسازی نیروی انسانی</h5>
                            <p class="card-text">واحد آکادمی این مرکز در راستای تحقق فرهنگ افتا، با برگزاری دوره‌های آموزشی و کارگاه‌های تخصصی، افزایش سطح دانش نیروهای انسانی داخل و خارج مرکز را تحقق می‌بخشد.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card shadow-lg">
                        <img src="{{ asset('images/seminar-1.jpg') }}" class="card-img-top" alt="پایش استانداردها">
                        <div class="card-body">
                            <h5 class="card-title text-center">برگزاری رویدادها و استعدادیابی</h5>
                            <p class="card-text">برگزاری کنفرانس‌ها، سمینارهای تخصصی و مسابقات علمی با هدف ترویج فرهنگ افتا و استعدادیابی از جمله اهداف این مرکز به شمار می‌آید.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-4 py-4">
            <div class="row gy-4">
                <div class="col-lg-3 col-6">
                    <div class="text-center border rounded pt-3 px-2 shadow-lg custom-card">
                        <h4>آکادمی</h4>
                        <p>این بخش، ماموریت توانمندسازی نیروی انسانی را در راستای اهداف افتا بر عهده دارد.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="text-center border rounded pt-3 px-2 shadow-lg custom-card">
                        <h4>پروژه‌</h4>
                        <p>در این مرکز، درخواست‌های متقاضیان، در قالب پروژه تعریف و اجرا می‌گردد.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="text-center border rounded pt-3 px-2 shadow-lg custom-card">
                        <h4>علمی</h4>
                        <p>این بخش، دسترسی به منابع علمی مرتبط با امنیت سایبری را فراهم می‌نماید.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="text-center border rounded pt-3 px-2 shadow-lg custom-card">
                        <h4>فرم‌های عملیاتی</h4>
                        <p>کلیه فرم‌های عملیاتی مرتبط با پروژه‌ها و فرایندهای اجرایی مرکز از طریق این سامانه برای متقاضیان در دسترس می‌باشد.</p>
                    </div>
                </div>
            </div>
        </section>

    </div>

@endsection
