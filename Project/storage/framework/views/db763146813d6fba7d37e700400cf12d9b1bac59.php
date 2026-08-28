

<?php $__env->startSection('title'); ?>
    <title>خبرها</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
    <?php if( config('app.env') === 'local' ): ?>
        <link href="<?php echo e(asset('css/news/index.css')); ?>" rel="stylesheet">
    <?php else: ?>
        <link href="<?php echo e(asset('css/news/index.css')); ?>?v=<?php echo e(filemtime(config('app.server_css_files_path') . '/news/index.css')); ?>" rel="stylesheet">
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('master_content'); ?>

    <div class="container my-5">

        <div class="page-path mb-3">
            <a href="<?php echo e(route('home')); ?>">صفحه اصلی</a><span class="px-1"> > </span>
            <a href="#">خبرها</a>
        </div>

        <h2 class="mb-5 text-center">خبرها</h2>

        <div class="row gy-4 mb-5">
            <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex col-lg-4 col-sm-6">
                    <div class="card shadow-lg">
                        <img src="<?php echo e($item->image ? asset('storage/news/' . $item->image) : asset('images/no-image.jpg')); ?>" class="card-img-top" alt="<?php echo e($item->title); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($item->title); ?></h5>

                            <p class="card-text"><?php echo e(Str::limit( strip_tags($item->content), 100, '...' )); ?></p>

                            <div class="d-flex justify-content-center">
                                <a href="<?php echo e(route('news.show', $item->id)); ?>" class="btn btn-primary">مشاهده خبر</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="d-flex justify-content-center">
            <?php echo e($news->links('pagination::bootstrap-5')); ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\2\ASA\version_3\Project\resources\views/news/index.blade.php ENDPATH**/ ?>