

<?php $__env->startSection('title'); ?>
    <title>تحقیق و توسعه | مرکز آسا</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('meta'); ?>
    <meta name="description" content="تحقیق و توسعه مرکز پژوهشی آسا شرق">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <style>
        .page-header {
            background: linear-gradient(135deg, #0c2340, #1a4a7a, #2d7fc1);
            color: white;
            padding: 80px 0 50px;
        }
        .content-section {
            padding: 40px 0;
        }
        .rnd-card {
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            background: white;
            transition: all 0.3s ease;
        }
        .rnd-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .rnd-card .icon {
            font-size: 2.2rem;
            margin-bottom: 12px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('master_content'); ?>

    <div class="page-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">تحقیق و توسعه (R&D)</h1>
            <p class="lead">واحد تحقیق و توسعه مرکز آسا شرق، متولی نوآوری و خلق فناوری‌های نوین در حوزه امنیت سایبری</p>
        </div>
    </div>

    <div class="content-section">
        <div class="container">

            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-primary">
                        <h5>درباره واحد تحقیق و توسعه</h5>
                        <p>
                            واحد تحقیق و توسعه (R&D) مرکز آسا شرق با هدف <strong>نوآوری، تولید دانش فنی و توسعه فناوری‌های روز</strong> 
                            در حوزه امنیت سایبری فعالیت می‌نماید. این واحد با بهره‌گیری از تیم متخصص و همکاری با مراکز علمی و صنعتی، 
                            به دنبال حل چالش‌های امنیتی و ارائه راهکارهای نوین است.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-4">
                    <div class="rnd-card text-center">
                        <div class="icon"> </div>
                        <h5>هوش مصنوعی در امنیت</h5>
                        <p class="small text-muted">توسعه الگوریتم‌های یادگیری ماشین برای تشخیص تهدیدات</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="rnd-card text-center">
                        <div class="icon"> </div>
                        <h5>امنیت بلاک‌چین</h5>
                        <p class="small text-muted">بررسی و توسعه راهکارهای امنیتی برای فناوری بلاک‌چین</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="rnd-card text-center">
                        <div class="icon"> </div>
                        <h5>امنیت ابری</h5>
                        <p class="small text-muted">ارائه راهکارهای امنیتی برای محیط‌های ابری</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="rnd-card text-center">
                        <div class="icon"> </div>
                        <h5>امنیت موبایل</h5>
                        <p class="small text-muted">توسعه ابزارهای امنیتی برای برنامه‌های موبایل</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="rnd-card text-center">
                        <div class="icon"> </div>
                        <h5>امنیت وب</h5>
                        <p class="small text-muted">شناسایی آسیب‌پذیری‌ها و ارائه راهکارهای مقابله</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="rnd-card text-center">
                        <div class="icon"> </div>
                        <h5>رمزنگاری پیشرفته</h5>
                        <p class="small text-muted">تحقیق بر روی الگوریتم‌های رمزنگاری نسل جدید</p>
                    </div>
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">پروژه‌های جاری R&D</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">توسعه سامانه تشخیص نفوذ مبتنی بر هوش مصنوعی</li>
                                <li class="list-group-item">طراحی و پیاده‌سازی پروتکل امنیتی برای اینترنت اشیا</li>
                                <li class="list-group-item">پژوهش در زمینه رمزنگاری پساکوانتومی</li>
                                <li class="list-group-item">توسعه ابزار خودکار ارزیابی امنیت وب‌سایت‌ها</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="<?php echo e(route('home')); ?>" class="btn btn-secondary">بازگشت به صفحه اصلی</a>
            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\2\ASA\version_3\Project\resources\views/scientific/rnd.blade.php ENDPATH**/ ?>