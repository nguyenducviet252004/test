<?php $__env->startSection('title'); ?>
    Dashboard
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1 class="text-center">Xin chào, <?php echo e(Auth::user()->fullname ?? Auth::user()->email); ?>!</h1>

        <!-- User Info Section -->
        <div class="row">
               <marquee behavior="" direction="">Chúc bạn một ngày mua sắm thật vui vẻ </marquee> 
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\New folder (2)\backend\resources\views/user/dashboard.blade.php ENDPATH**/ ?>