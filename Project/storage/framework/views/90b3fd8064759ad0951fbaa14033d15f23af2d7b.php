<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo $__env->yieldContent('meta'); ?>

    <?php echo $__env->yieldContent('title'); ?>

    <link href="<?php echo e(asset('bootstrap-5.3.3/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">

    <?php if( config('app.env') === 'local' ): ?>
        <link href="<?php echo e(asset('css/master.css')); ?>" rel="stylesheet">
    <?php else: ?>
        <link href="<?php echo e(asset('css/master.css')); ?>?v=<?php echo e(filemtime(config('app.server_css_files_path') . '/master.css')); ?>" rel="stylesheet">
    <?php endif; ?>

    <?php echo $__env->yieldContent('style'); ?>

</head>

<body>
    <nav id="nav" class="navbar navbar-expand-lg bg-dark navbar-dark fixed-top p-0">
        <div class="container-fluid px-1">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <div class="d-flex" id="logo"><img src="<?php echo e(asset('icons/logo-white-name.png')); ?>" class="img-fluid p-1" alt="logo"></div>
            </a>

            <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <div class="d-flex w-100 justify-content-between">
                    <ul class="navbar-nav px-2">
                        <li class="nav-item">
                            <a class="nav-link me-2" href="<?php echo e(route('home')); ?>">صفحه اصلی</a>
                        </li>

                        <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                رسالت ما
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="<?php echo e(route('vision-and-goal')); ?>">اهداف و ماموریت‌ها</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('activities')); ?>">فعالیت‌ها</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('work-organization')); ?>">سازمان کاری</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                قوانین
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="<?php echo e(route('policies-and-guidelines')); ?>">قوانین و دستورالعمل‌ها</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('executive-regulations')); ?>">آیین‌نامه‌های اجرایی</a></li>
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
                                <li><a class="dropdown-item" href="<?php echo e(route('talent-scouting')); ?>">استعدادیابی و برگزاری رویداد</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                علمی
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="<?php echo e(route('scientific.research-international')); ?>">پژوهش‌های ملی/بین‌المللی</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('scientific.articles-international')); ?>">مقالات ملی/بین‌المللی</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('scientific.rnd')); ?>">تحقیق و توسعه</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('submit-proposal.index')); ?>">پیشنهاد مقاله/پایان نامه/رساله</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link me-2" href="<?php echo e(route('news.index')); ?>">خبرها</a>
                        </li>
                        
                        <li class="nav-item dropdown dropdown-hover position-relative">
                            <a class="nav-link me-2 dropdown-toggle" href="#" id="hoverDropdown" role="button" aria-expanded="false">
                                درخواست ها 
                            </a>
                            <ul class="dropdown-menu dropdown-hover-menu text-end" aria-labelledby="hoverDropdown">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#consultationModal">درخواست مشاوره</a></li>
                                <li>
                                    <?php if(auth()->guard()->check()): ?>
                                        <a class="dropdown-item" href="<?php echo e(route('dashboard.requests.index')); ?>">درخواست ثبت پروژه</a>
                                    <?php else: ?>
                                        <a class="dropdown-item" href="<?php echo e(route('login')); ?>">درخواست ثبت پروژه</a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </li>
                    </ul>

                    <form class="d-flex me-4 align-items-center">
                        <input class="form-control" id="formInput" type="text" placeholder="جستجو کنید...">
                        <button class="btn btn-primary" type="button" id="searchBtn">
                            <div id="searchIcon"><img src="<?php echo e(asset('icons/search-white.svg')); ?>" class="img-fluid" alt="search"></div>
                        </button>
                    </form>

                    <?php if(auth()->guard()->guest()): ?>
                        <div id="loginRegisterLinks" class="d-flex align-items-center mx-4">
                            <?php if(Route::has('login')): ?>
                                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary ms-2 d-flex justify-content-center align-items-center">ورود</a>
                            <?php endif; ?>

                            <?php if(Route::has('register')): ?>
                                <a href="<?php echo e(route('register')); ?>" class="btn btn-success d-flex justify-content-center align-items-center">عضویت</a>
                            <?php endif; ?>
                        </div>

                    <?php else: ?>
                        <ul class="navbar-nav p-0 me-4 ms-5 mb-lg-0 mb-3">
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <?php echo e(Auth::user()->name); ?>

                                </a>

                                <div class="dropdown-menu dropdown-menu-end text-center account-dropdown" aria-labelledby="navbarDropdown">

                                    <?php if(auth()->guard()->check()): ?>
                                        <div class="mb-1 mx-auto dropdown-avatar">
                                            <img src="<?php echo e(auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/no-avatar.png')); ?>"
                                                class="img-fluid dropdown-avatar">
                                        </div>

                                        <a class="dropdown-item" href="<?php echo e(route('dashboard.index')); ?>">
                                            <?php echo e(__('Dashboard')); ?>

                                        </a>
                                    <?php endif; ?>

                                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <?php echo e(__('Logout')); ?>

                                    </a>

                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                        <?php echo csrf_field(); ?>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    <?php endif; ?>

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
                        <img src="<?php echo e(asset('images/development.gif')); ?>" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php echo $__env->yieldContent('master_content'); ?>

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
                        <li><a href="<?php echo e(route('about-us')); ?>" class="text-white">درباره ما</a></li>
                        <li><a href="#" class="text-white" data-bs-toggle="modal" data-bs-target="#menuModal">سوالات متداول</a></li>
                    </ul>
                </div>

                <div class="col-md-4 text-center">
                    <h5 class="mb-2">ما را دنبال کنید:</h5>

                    <div class="d-flex justify-content-center">
                        <a href="#">
                            <div class="footer-icon">
                                <img src="<?php echo e(asset('icons/social-networks/aparat-white.svg')); ?>" class="img-fluid">
                            </div>
                        </a>
                        <a href="#">
                            <div class="footer-icon">
                                <img src="<?php echo e(asset('icons/social-networks/linkedin-white.svg')); ?>" class="img-fluid">
                            </div>
                        </a>
                        <a href="#">
                            <div class="footer-icon">
                                <img src="<?php echo e(asset('icons/social-networks/telegram-white.svg')); ?>" class="img-fluid">
                            </div>
                        </a>
                        <a href="#">
                            <div class="footer-icon">
                                <img src="<?php echo e(asset('icons/social-networks/whatsapp-white.svg')); ?>" class="img-fluid">
                            </div>
                        </a>
                        <a href="#">
                            <div class="footer-icon">
                                <img src="<?php echo e(asset('icons/social-networks/eitaa-white.svg')); ?>" class="img-fluid">
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

    <script src="<?php echo e(asset('bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js')); ?>"></script>

    <?php echo $__env->yieldContent('script'); ?>

    <div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header position-relative">
                    <h5 class="modal-title w-100 text-center" id="consultationModalLabel">درخواست خدمات مشاوره</h5>
                    <button type="button" class="btn-close position-absolute start-0 ms-3" data-bs-dismiss="modal" aria-label="بستن"></button>
                </div>

                <?php if(session('consultation_success')): ?>
                    <div class="modal-body text-center py-4">
                        <div class="text-success fs-5 mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </div>
                        <p class="fw-bold"><?php echo e(session('consultation_success')); ?></p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                    </div>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('consultation.store')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">

                            <?php if($errors->hasBag('consultation')): ?>
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <?php $__currentLoopData = $errors->getBag('consultation')->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">نام شرکت <span class="text-danger">*</span></label>
                                <input type="text" name="company_name" class="form-control" value="<?php echo e(old('company_name')); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">شماره تماس <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone')); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">ایمیل</label>
                                <input type="email" name="email" class="form-control" value="<?php echo e(old('email')); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">نوع خدمت <span class="text-danger">*</span></label>
                                <select name="service_type" class="form-select" required>
                                    <option value="">انتخاب کنید...</option>
                                    <option value="ISO15408"            <?php echo e(old('service_type') === 'ISO15408'            ? 'selected' : ''); ?>>استاندارد ISO/IEC 15408</option>
                                    <option value="ISO25000"            <?php echo e(old('service_type') === 'ISO25000'            ? 'selected' : ''); ?>>استاندارد ISO/IEC 25000</option>
                                    <option value="penetration_test"    <?php echo e(old('service_type') === 'penetration_test'    ? 'selected' : ''); ?>>تست نفوذ و امنیت</option>
                                    <option value="document_management" <?php echo e(old('service_type') === 'document_management' ? 'selected' : ''); ?>>تنظیم و پایش اسناد</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                            <button type="submit" class="btn btn-primary">ارسال درخواست</button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if(session('consultation_success') || $errors->hasBag('consultation')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = new bootstrap.Modal(document.getElementById('consultationModal'));
                modal.show();
            });
        </script>
    <?php endif; ?>

</body>

</html>
<?php /**PATH C:\wamp64\www\2\ASA\version_3\Project\resources\views/master.blade.php ENDPATH**/ ?>