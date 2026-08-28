

<?php $__env->startSection('title'); ?>
    <title>استعدادیابی و برگزاری رویداد | مرکز آسا</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('style'); ?>
<style>
    .page-header {
        background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        color: white;
        padding: 70px 0 50px;
    }

    .ctf-section {
        min-height: calc(100vh - 220px);
        display: flex;
        align-items: center;
        background: #f4f6fb;
    }

    .ctf-card {
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 320px;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
    }

    .ctf-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.25) !important;
    }

    .ctf-card .ctf-label {
        font-size: 3.5rem;
        font-weight: 900;
        letter-spacing: 4px;
        color: #fff;
        text-shadow: 0 2px 12px rgba(0,0,0,0.3);
        user-select: none;
    }

    .ctf1-card {
        background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
        box-shadow: 0 10px 35px rgba(15, 52, 96, 0.45);
    }

    .ctf2-card {
        background: linear-gradient(135deg, #134e5e, #1a7a4a, #2ecc71);
        box-shadow: 0 10px 35px rgba(46, 204, 113, 0.35);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('master_content'); ?>

    <div class="page-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">استعدادیابی و برگزاری رویداد</h1>
            <p class="lead mt-2 opacity-75">رویدادهای امنیت سایبری مرکز پژوهشی آسا شرق</p>
        </div>
    </div>

    <div class="ctf-section py-5">
        <div class="container">
            <div class="row g-4 justify-content-center">

                <div class="col-md-5">
                    <a href="#" class="ctf-card ctf1-card w-100">
                        <span class="ctf-label">CTF1</span>
                    </a>
                </div>

                <div class="col-md-5">
                    <a href="#" class="ctf-card ctf2-card w-100">
                        <span class="ctf-label">CTF2</span>
                    </a>
                </div>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\2\ASA\version_3\Project\resources\views/talent-scouting.blade.php ENDPATH**/ ?>