<?php $__env->startSection('title', 'Edit Product'); ?>
<?php $__env->startSection('data-page-id', 'adminProduct'); ?>

<?php $__env->startSection('content'); ?>

    <div class="add-product admin_shared grid-container full">

        <div class="grid-x grid-padding-x">
            <div class="cell">
                <h2 class="text-center">Edit - <?php echo e($products->name); ?></h2><hr>
            </div>
        </div>

        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <form action="/admin/product/edit" method="post" enctype="multipart/form-data">

            <div class="grid-x grid-padding-x">


                    
                    <div class="small-12 medium-6 cell">
                        <label for="name">Product Name</label>
                        <input type="text" name="name"  value="<?php echo e($products->name); ?>">
                    </div>

                    
                    <div class="small-12 medium-6 cell">
                        <label for="price">Product Price</label>
                        <input type="text" name="price" value="<?php echo e($products->price); ?> ">
                    </div>




                    
                    <div class="small-12 medium-6 cell">
                        <label for="category">Product Category</label>
                        <select name="category" id="product-category">
                            <option value="<?php echo e($products->category->id); ?>">
                                <?php echo e($products->category->name); ?>

                            </option>

                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"> <?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>


                    
                    <div class="small-12 medium-6 cell">
                        <label for="subcategory">Product Subcategory</label>
                        <select name="subcategory" id="product-subcategory">
                            <option value="<?php echo e($products->subCategory->id); ?>">
                                <?php echo e($products->subCategory->name); ?>

                            </option>
                        </select>
                    </div>





                    
                    <div class="small-12 medium-6 cell">
                        <label for="quantity">Product Quantity</label>
                        <select name="quantity" id="product-quantity">
                            <option value="<?php echo e($products->quantity); ?>">
                                <?php echo e($products->quantity); ?>

                            </option>

                            <?php for($i = 1; $i <= 50; $i++): ?>
                                <option value="<?php echo e($i); ?>"> <?php echo e($i); ?> </option>
                                <?php endfor; ?>

                        </select>
                    </div>


                    
                    <div class="small-12 medium-6 cell">
                        <br>
                        <div class="input-group">
                            <span class="input-group-label">Product Image</span>
                            <input type="file" name="productImage" class="input-group-field">
                        </div>
                    </div>


                    
                    <div class="small-12 cell">
                        <label for="description">Description</label>
                        <textarea name="description" id="" placeholder="Description"><?php echo e($products->description); ?></textarea>
                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        <input type="hidden" name="product_id" value="<?php echo e($products->id); ?>">
                        <input class="button warning float-right" type="submit" value="Update Product">
                    </div>



            </div>

        </form>

        
        <div class="grid-x grid-padding-x">

            <div class="small-12 medium-11 cell">
                <table data-form="deleteForm">
                    <tr style="border-style: hidden !important;">
                        <td style="border-style: hidden !important;">
                            <form action="/admin/product/<?php echo e($products->id); ?>/delete" method="post" class="delete-item">
                                <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                <button type="submit" class="button alert float-left">Delete Product</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>

        </div>


    </div>
        <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>




<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>