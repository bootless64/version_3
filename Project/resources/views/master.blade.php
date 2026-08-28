<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @yield('meta')

    @yield('title')

    <link href="{{ asset('bootstrap-5.3.3/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    @if ( config('app.env') === 'local' )
        <link href="{{ asset('css/master.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/master.css') }}?v={{ filemtime(config('app.server_css_files_path') . '/master.css') }}" rel="stylesheet">
    @endif

    @yield('style')

</head>

<body>
    <nav id="nav" class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top p-0">
        <div class="container-fluid px-1">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="d-flex" id="logo"><img src="{{ asset('icons/logo-white-name.png') }}" class="img-fluid p-1" alt="logo"></div>
            </a>

            <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <div class="d-flex w-100 justify-content-between">
                    <ul class="navbar-nav px-2">
                        <li class="nav-item">
                            <a class="nav-link me-2" href="{{ route('home') }}">صفحه اصلی</a>
                        </li>

                        <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                رسالت ما
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="{{ route('vision-and-goal') }}">اهداف و ماموریت‌ها</a></li>
                                <li><a class="dropdown-item" href="{{ route('activities') }}">فعالیت‌ها</a></li>
                                <li><a class="dropdown-item" href="{{ route('work-organization') }}">سازمان کاری</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                قوانین
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="{{ route('policies-and-guidelines') }}">قوانین و دستورالعمل‌ها</a></li>
                                <li><a class="dropdown-item" href="{{ route('executive-regulations') }}">آیین‌نامه‌های اجرایی</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">ضوابط و مقررات</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">آیین‌نامه‌های داخلی</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">فرم‌های عملیاتی</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                آکادمی
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">حوزه تنظیم و پایش اسناد</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">حوزه تست‌های امنیتی و نفوذ</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">حوزه رفع خطاهای امنیتی نرم‌افزار</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">استاندارد ISO/IEC 15408</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">استاندارد ISO/IEC 25000</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">سایر استانداردهای ISO/IEC</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#menuModal">منتورینگ، کوچینگ و مشاوره</a></li>
                            </ul>
                        </li>
                            <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                رویداد ها
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="{{ route('talent-scouting') }}">استعدادیابی و برگزاری رویداد</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                علمی
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="{{ route('scientific.research-international') }}">پژوهش‌های ملی/بین‌المللی</a></li>
                                <li><a class="dropdown-item" href="{{ route('scientific.articles-international') }}">مقالات ملی/بین‌المللی</a></li>
                                <li><a class="dropdown-item" href="{{ route('scientific.rnd') }}">تحقیق و توسعه</a></li>
                                <li><a class="dropdown-item" href="{{ route('submit-proposal.index') }}">پیشنهاد مقاله/پایان نامه/رساله</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link me-2" href="{{ route('news.index') }}">خبرها</a>
                        </li>
                        
                        <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                درخواست ها 
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#consultationModal">درخواست مشاوره</a></li>
                                <li>
                                    @auth
                                        <a class="dropdown-item" href="{{ route('dashboard.requests.index') }}">درخواست ثبت پروژه</a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('login') }}">درخواست ثبت پروژه</a>
                                    @endauth
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <form class="d-flex me-4 align-items-center">
                        <input class="form-control" id="formInput" type="text" placeholder="جستجو کنید...">
                        <button class="btn btn-primary" type="button" id="searchBtn">
                            <div id="searchIcon"><img src="{{ asset('icons/search-white.svg') }}" class="img-fluid" alt="search"></div>
                        </button>
                    </form>

                    @guest
                        <div id="loginRegisterLinks" class="d-flex align-items-center mx-4">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="btn btn-primary ms-2 d-flex justify-content-center align-items-center">ورود</a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-success d-flex justify-content-center align-items-center">عضویت</a>
                            @endif
                        </div>

                    @else
                        <ul class="navbar-nav p-0 me-4 ms-5 mb-lg-0 mb-3">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end text-center account-dropdown" aria-labelledby="navbarDropdown">

                                    @auth
                                        <div class="mb-1 mx-auto dropdown-avatar">
                                            <img src="{{ auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/no-avatar.png') }}"
                                                class="img-fluid dropdown-avatar">
                                        </div>

                                        <a class="dropdown-item" href="{{ route('dashboard.index') }}">
                                            {{ __('Dashboard') }}
                                        </a>
                                    @endauth

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    @endguest

                </div>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="menuModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="d-flex justify-content-end p-3">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center">
                    <h5>این بخش در حال تدوین می‌باشد...</h5>
                    <div class="w-50">
                        <img src="{{ asset('images/development.gif') }}" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('master_content')

    <footer class="bg-dark text-white py-2">
        <br>
        <div class="container">
            <div class="row gy-4">

                <div class="col-md-4 text-center">
                    <h5 class="mb-2">لینک‌های مفید</h5>

                    <ul class="list-unstyled p-0 useful-links">
                        <li><a href="https:
                        <li><a href="https:
                        <li><a href="https:
                        <li><a href="https:
                        <li><a href="https:
                    </ul>
                </div>

                <div class="col-md-4 text-center">
                    <h5 class="mb-2">پیوست‌ها</h5>

                    <ul class="list-unstyled p-0">
                        <li><a href="{{ route('about-us') }}" class="text-white">درباره ما</a></li>
                        <li><a href="#" class="text-white" data-bs-toggle="modal" data-bs-target="#menuModal">سوالات متداول</a></li>
                    </ul>
                </div>

                <div class="col-md-4 text-center">
                    <h5 class="mb-2">ما را دنبال کنید:</h5>

                    <div class="d-flex justify-content-center">
                        <a href="#">
                            <div class="footer-icon">
                                <img src="{{ asset('icons/social-networks/aparat-white.svg') }}" class="img-fluid">
                            </div>
                        </a>
                        <a href="#">
                            <div class="footer-icon">
                                <img src="{{ asset('icons/social-networks/linkedin-white.svg') }}" class="img-fluid">
                            </div>
                        </a>
                        <a href="#">
                            <div class="footer-icon">
                                <img src="{{ asset('icons/social-networks/telegram-white.svg') }}" class="img-fluid">
                            </div>
                        </a>
                        <a href="#">
                            <div class="footer-icon">
                                <img src="{{ asset('icons/social-networks/whatsapp-white.svg') }}" class="img-fluid">
                            </div>
                        </a>
                        <a href="#">
                            <div class="footer-icon">
                                <img src="{{ asset('icons/social-networks/eitaa-white.svg') }}" class="img-fluid">
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center mt-md-0 mt-3">
            <p>
                <span class="fs-5">© </span>
                تمامی حقوق مادی و معنوی این سایت متعلق به مرکز پژوهشی آسا شرق می‌باشد.
            </p>
        </div>

    </footer>

    <script src="{{asset('bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js')}}"></script>

    @yield('script')

    <div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header position-relative">
                    <h5 class="modal-title w-100 text-center" id="consultationModalLabel">درخواست خدمات مشاوره</h5>
                    <button type="button" class="btn-close position-absolute start-0 ms-3" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>

                @if(session('consultation_success'))
                    <div class="modal-body text-center py-4">
                        <div class="text-success fs-5 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </div>
                        <p class="fw-bold">{{ session('consultation_success') }}</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                    </div>
                @else
                    <form method="POST" action="{{ route('consultation.store') }}">
                        @csrf
                        <div class="modal-body">

                            @if($errors->hasBag('consultation'))
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->getBag('consultation')->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">نام شرکت <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">شماره تماس <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ایمیل</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">نوع خدمت <span class="text-danger">*</span></label>
                                <select name="service_type" class="form-select" required>
                                    <option value="">انتخاب کنید...</option>
                                    <option value="ISO15408"            {{ old('service_type') === 'ISO15408'            ? 'selected' : '' }}>استاندارد ISO/IEC 15408</option>
                                    <option value="ISO25000"            {{ old('service_type') === 'ISO25000'            ? 'selected' : '' }}>استاندارد ISO/IEC 25000</option>
                                    <option value="penetration_test"    {{ old('service_type') === 'penetration_test'    ? 'selected' : '' }}>تست نفوذ و امنیت</option>
                                    <option value="document_management" {{ old('service_type') === 'document_management' ? 'selected' : '' }}>تنظیم و پایش اسناد</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                            <button type="submit" class="btn btn-primary">ارسال درخواست</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    @if(session('consultation_success') || $errors->hasBag('consultation'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = new bootstrap.Modal(document.getElementById('consultationModal'));
                modal.show();
            });
        </script>
    @endif

</body>

</html>
