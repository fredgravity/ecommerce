<?php $__env->startSection('title', 'Manage Inventory'); ?>
<?php $__env->startSection('data-page-id', 'adminProduct'); ?>

<?php $__env->startSection('content'); ?>

    <div class="products admin_shared grid-container">

        <div class="cell">
                <h2 class="text-center">Search Inventory Results (<?php echo e($total); ?>)</h2><hr>
        </div>


        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-7 cell">
                <form action="" method="post" class="grid-x grid-padding-x">

                    <div class="input-group medium-6 cell">
                        <input type="text" class="input-group-field" placeholder="Search by name" name="search_field" value="<?php echo e(\App\classes\Request::oldData('post','search_field')); ?>">
                        <div class="input-group-button">
                            <input type="submit" value="Search" class="button search-product" >
                        </div>

                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                    </div>

                    <div class="medium-3 cell">
                        <select name="category" id="product-category">
                            <option value="<?php echo e(\App\classes\Request::oldData('post', 'category')? : ''); ?>">
                                <?php echo e('Select Category'); ?>

                            </option>

                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"> <?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="medium-3 cell">
                        <select name="subCategory" id="product-subcategory">
                            <option value="<?php echo e(\App\classes\Request::oldData('post', 'subcategory')? : ''); ?>">
                                <?php echo e('Select Subcategory'); ?>

                            </option>
                        </select>
                    </div>

                </form>
            </div>

        </div>

        
        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


        <div class="grid-x grid-padding-x">
            <div class="cell search-table">

                <?php if(count($products)): ?>
                    
                    <table class="hover unstriped table-data-scroll" data-form="deleteForm">

                        <thead>
                        <tr>
                            <td>Image</td>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Category</td>
                            <td>Subcategory</td>
                            <td>Created On</td>
                            <td width="70">Action</td>
                        </tr>

                        <tbody id="body-scroll">

                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr>
                                        <td><img src="/<?php echo e($product['image_path']); ?>" alt="<?php echo e($product['name']); ?>" width="40" height="40"></td>
                                        <td><?php echo e($product['name']); ?></td>
                                        <td><?php echo e($product['price']); ?></td>
                                        <td><?php echo e($product['quantity']); ?></td>
                                        <td><?php echo e($product['category']['name']); ?></td>
                                        <td><?php echo e($product['subCategory']['name']); ?></td>
                                        <td><?php echo e($product['created_at']); ?></td>

                                        <td width="70" class="text-right">

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit Product">
                                                <a href="/admin/product/<?php echo e($product['id']); ?>/edit"> Edit <i class="fa fa-edit"></i></a>
                                            </span>

                                        </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>

                        </tbody>

                    </table>
                    
                        
                        

                    


                    <?php else: ?>
                    <div class="cell">
                        <h2>There is no Product Available</h2>
                    </div>

                <?php endif; ?>

            </div>
        </div>

    </div>





<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>