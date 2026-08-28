

<?php $__env->startSection('title'); ?>
    <title>نمایش خبر</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <?php if( config('app.env') === 'local' ): ?>
        <link href="<?php echo e(asset('css/news/show.css')); ?>" rel="stylesheet">
    <?php else: ?>
        <link href="<?php echo e(asset('css/news/show.css')); ?>?v=<?php echo e(filemtime(config('app.server_css_files_path') . '/news/show.css')); ?>" rel="stylesheet">
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('master_content'); ?>

    <div class="container mt-5 mb-5">

        <div class="page-path mb-3">
            <a href="<?php echo e(route('home')); ?>">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="<?php echo e(route('news.index')); ?>">خبرها</a></a><span class="px-1"> > </span>
            <a href="#">مشاهده خبر</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <h2 class="card-title"><?php echo e($news->title); ?></h2>
                <p class="text-muted small">نوشته شده در <?php echo e($news->getCreatedAt()); ?></p>
                <hr>

                <div class="d-flex mb-5 justify-content-center main-image">
                    <img src="<?php echo e($news->image ? asset('storage/news/' . $news->image) : asset('images/no-image.jpg')); ?>"
                        class="h-100 shadow-lg" alt="<?php echo e($news->title); ?>">
                </div>

                <div class="news-content mb-5">
                    <?php echo $news->content; ?>

                </div>

                <?php if($news->slider_images): ?>
                    <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <?php $__currentLoopData = $news->slider_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" data-bs-target="#newsCarousel"
                                    data-bs-slide-to="<?php echo e($index); ?>" class="<?php echo e($index === 0 ? 'active' : ''); ?>"></button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="carousel-inner">
                            <?php $__currentLoopData = $news->slider_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                    <img src="<?php echo e(asset('storage/news/' . $img)); ?>" class="w-100 h-100">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="mt-5">
            <h4>نظرات کاربران</h4>

            <?php $__empty_1 = true; $__currentLoopData = $news->approvedComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar m-1 shadow">
                                <img src="<?php echo e($comment->user->avatar ? asset('storage/avatars/' . $comment->user->avatar) : asset('images/no-avatar.png')); ?>"
                                    class="img-fluid avatar">
                            </div>
                            <h6 class="card-subtitle text-muted mx-1"><?php echo e($comment->user->name); ?></h6>
                        </div>
                        <p class="card-text px-2"><?php echo nl2br(e($comment->content)); ?></p>
                        <small class="text-muted"><?php echo e($comment->created_at->diffForHumans()); ?></small>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-muted">تاکنون نظری ثبت نشده است.</div>
            <?php endif; ?>
        </div>

        <?php if(auth()->user()): ?>
            
            <div class="mt-5">
                <h5>ارسال نظر:</h5>
                <div class="d-flex align-items-center">
                    <div class="avatar m-1 shadow">
                        <img src="<?php echo e(auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/no-avatar.png')); ?>"
                            class="img-fluid avatar">
                    </div>
                    <h6 class="mx-1 my-0 text-muted"><?php echo e(auth()->user()->name . ':'); ?></h6>
                </div>
                <form action="<?php echo e(route('news.comment', $news->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <textarea class="form-control" name="content" rows="3" placeholder="نظر خود را بنویسید..." required><?php echo e(old('content')); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">ارسال نظر</button>
                </form>
            </div>

        <?php else: ?>
            <div class="mt-5 d-flex">
                <h5 class="ms-3">برای ارسال نظر باید وارد شوید.</h5>
                <a href="<?php echo e(route('redirect-after-login', ['redirect_to' => url()->current()])); ?>">ورود</a>
            </div>
        <?php endif; ?>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\2\ASA\version_3\Project\resources\views/news/show.blade.php ENDPATH**/ ?>