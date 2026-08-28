

<?php $__env->startSection('meta'); ?>
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('master_content'); ?>
    <div id="app">

        <main>
            <?php echo $__env->yieldContent('content'); ?>
        </main>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\2\ASA\version_3\Project\resources\views/layouts/app.blade.php ENDPATH**/ ?>