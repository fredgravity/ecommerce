<?php $__env->startSection('body'); ?>


    <?php echo $__env->make('includes.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('includes.search-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



    <div class="site_wrapper">
         <?php echo $__env->yieldContent('content'); ?>



        <div class="notify text-center">

        </div>

    </div>


    <?php echo $__env->yieldContent('footer'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>