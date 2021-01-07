<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Artisao - <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="stylesheet" href="/css/all.css">
    
</head>
<body data-page-id="<?php echo $__env->yieldContent('data-page-id'); ?>">
<?php echo $__env->make('includes.preloader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<?php echo $__env->make('includes.search-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>




    <div class="off-canvas-content admin_title_bar" data-off-canvas-content>

        
        <div class="title-bar">
            <div class="title-bar-left">
                <button class="menu-icon hide-for-large" type="button" data-open="offCanvas"></button>
                <?php if($advance): ?>
                    <h5 class="title-bar-title text-center">Search Artisao Product - "<?php echo e($advance); ?>"</h5>
                    <?php elseif($searchWord): ?>
                    <h5 class="title-bar-title text-center">Search Artisao Product - "<?php echo e($searchWord); ?>"</h5>
                    <?php endif; ?>

            </div>
        </div>

        <!-- Your page content lives here -->
        <?php echo $__env->yieldContent('content'); ?>
    </div>


<script src="/fontawesome/js/allfonts.js"></script>
<script src="/js/all.js"></script>

</body>
</html>

