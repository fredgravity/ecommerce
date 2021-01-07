<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo e(getenv('HOME_NAME')); ?> - <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="stylesheet" href="/css/all.css">
    <link rel="shortcut icon" type="image/png" href="/favicon.png">

</head>

<body data-page-id="<?php echo $__env->yieldContent('data-page-id'); ?>" >
<?php echo $__env->make('includes.preloader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


    <!-- Your page content lives here -->

<div id="hide-div" style="display: none">
    <!-- Your page content lives here -->
    <?php echo $__env->yieldContent('body'); ?>
</div>






    <script src="/fontawesome/js/allfonts.js"></script>
    <script src="/js/all.js"></script>

</body>
</html>

