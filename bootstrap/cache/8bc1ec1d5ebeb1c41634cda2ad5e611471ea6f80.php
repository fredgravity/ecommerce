<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vendor Panel - <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="stylesheet" href="/css/all.css">
    <link rel="shortcut icon" type="image/png" href="/favicon.png">
</head>
<body data-page-id="<?php echo $__env->yieldContent('data-page-id'); ?>" >
<?php echo $__env->make('includes.preloader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<div id="hide-div" style="display: none">
    <?php echo $__env->make('includes.vendor-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    

    
    <div class="off-canvas-content admin_title_bar" data-off-canvas-content>

        
        <div class="title-bar">
            <div class="title-bar-left">
                <button class="menu-icon hide-for-large" type="button" data-open="offCanvas"></button>
                <span class="title-bar-title"><?php echo e(getenv('APP_NAME')); ?></span>
            </div>
        </div>

        <!-- Your page content lives here -->
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    
</div>


<script src="/fontawesome/js/allfonts.js"></script>
<script src="/js/all.js"></script>

</body>
</html>

