<?php $__env->startSection('title', 'Create Product'); ?>
<?php $__env->startSection('data-page-id', 'adminProduct'); ?>

<?php $__env->startSection('content'); ?>

    <div class="add-product admin_shared grid-container full" >

        <div class="grid-x grid-padding-x">
            <div class="cell medium-12">
                <h2 class="text-center">Add Product</h2><hr>
            </div>
        </div>

        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <form action="/admin/product/create/update" method="post" enctype="multipart/form-data">

            <div class="grid-x grid-padding-x">


                    
                    <div class="small-12 medium-6 cell">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" placeholder="Product Name" value="<?php echo e(\App\classes\Request::oldData('post', 'name')); ?>">
                    </div>

                    
                    <div class="small-12 medium-6 cell">
                        <label for="price">Product Price</label>
                        <input type="text" name="price" placeholder="Product Price" value="<?php echo e(\App\classes\Request::oldData('post', 'price')); ?>">
                    </div>




                    
                    <div class="small-12 medium-6 cell">
                        <label for="product-category">Product Category</label>
                        <select name="category" id="product-category">
                            <option value="<?php echo e(\App\classes\Request::oldData('post', 'category')? : ''); ?>">
                                <?php echo e('Select Category'); ?>

                            </option>

                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"> <?php echo e($category->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    
                    <div class="small-12 medium-6 cell">
                        <label for="subcategory">Product Subcategory</label>
                        <select name="product-subcategory" id="product-subcategory">
                            <option value="<?php echo e(\App\classes\Request::oldData('post', 'subcategory')? : ''); ?>">
                                <?php echo e('Select Subcategory'); ?>

                            </option>
                        </select>
                    </div>





                    
                    <div class="small-12 medium-6 cell">
                        <label for="quantity">Product Quantity</label>
                        <select name="quantity" id="product-quantity">
                            <option value="<?php echo e(\App\classes\Request::oldData('post', 'quantity')? : ''); ?>">
                                <?php echo e(\App\classes\Request::oldData('post', 'quantity')? : 'Select Quantity'); ?>

                            </option>

                            <?php for($i = 1; $i <= 50; $i++): ?>
                                <option value="<?php echo e($i); ?>"> <?php echo e($i); ?> </option>
                                <?php endfor; ?>

                        </select>
                    </div>

                    <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">

                    
                    <div class="small-12 medium-6 cell">
                        <br>
                        <div class="input-group">
                            

                            <label for="upload-file" class="button"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Upload Image</label>
                            <input type="file" name="productImage" class="input-group-field show-for-sr" id="upload-file" >
                        </div>
                    </div>

                    
                    <div class="cell">
                        <label for="description">Description</label>
                        <textarea name="description" id="" placeholder="Description"><?php echo e(\App\classes\Request::oldData('post', 'description')); ?></textarea>
                        <button class="button alert" type="reset">Reset</button>
                        <input class="button success float-right" type="submit" value="Save Product">
                    </div>



            </div>

        </form>



    </div>
        <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>