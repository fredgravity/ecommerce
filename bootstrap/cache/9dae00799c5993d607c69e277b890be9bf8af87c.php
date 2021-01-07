
<!-- SIDE BAR -->
<div class="off-canvas position-left reveal-for-large nav searchCanvas" id="offCanvas" data-off-canvas >

    <a href="/"><img src="/images/logo.png" alt="Artisao" ></a>




    <?php if(count($categories)): ?>
        <hr>
        <ul>
            <li><p class="-divide">Categories</p></li>
        </ul>
        <hr>
        <ul class="side-nav">

            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <li><a href="/category_items/<?php echo e($category->id); ?>"><?php echo e($category->name); ?>  ( <?php echo e($totalItems[$index]); ?> )</a></li>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <br>

        </ul>

    <?php endif; ?>
    <hr>
    <ul>
        <li class=""><p>Advance Search</p></li>
    </ul>
    <hr>

    <div class="row align-right searchCanvasForm">
        <div class="column small-12">
            <form action="/product-advance-search" method="post" id="searchCanvasForm">
                <label for="search">Search Term Required</label>
                <input type="text" id="search" name="search" placeholder="Search" value="<?php echo e(\App\classes\Request::oldData('post', 'search')); ?>">

                <label for="search-category">Select Category</label>
                <select name="category" id="search-category">
                    <option value="">Select Category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <label for="search-subCategory">Select Subcategory</label>
                <select name="subCategory" id="search-subCategory">
                    <option value="" >Select Subcategory</option>

                </select>

                <div class="row align-right">
                    <div class="small-6 column">
                        <input type="text" id="min" name="min" placeholder="min price" value="<?php echo e(\App\classes\Request::oldData('post', 'min')); ?>">
                    </div>

                    <div class="small-6 column">
                        <input type="text" id="max" name="max" placeholder="max price" value="<?php echo e(\App\classes\Request::oldData('post', 'max')); ?>">
                    </div>
                </div>

                <label for="country">Choose Country</label>
                <select name="country" id="country">
                    <option value="ghana" selected >Ghana</option>
                </select>

                <input type="submit" value="Search" class="button primary expanded">
                <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">

            </form>
        </div>

    </div>



</div>