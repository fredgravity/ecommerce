<?php $__env->startSection('title', 'Manage Inventory'); ?>
<?php $__env->startSection('data-page-id', 'adminProduct'); ?>

<?php $__env->startSection('content'); ?>

    <div class="products admin_shared">

        <div class="row expanded">
            <div class="column medium-11">
                <h2 class="text-center">Manage Inventory</h2><hr>
            </div>
        </div>


        <div class="row expanded">
            <div class="small-12 medium-11">
                <form action="" method="post" class="small-12 medium-5 column">
                    <div class=" input-group">
                        <input type="text" class="input-group-field" placeholder="Search by name" name="search-field" id="search-field">
                        <div class="input-group-button">
                            <input type="button" value="Search" class="button search-product" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        </div>
                    </div>
                </form>

                <div class="small-12 medium-4 column">
                    <a href="/admin/product/create" class="button float-right"> <i class="fa fa-plus"></i> Add New Product </a>
                </div>
            </div>

        </div>

        
        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="row expanded">
            <div class="small-12 medium-11 column">

                <?php if(count($products)): ?>

                    
                    <table class="hover unstriped" data-form="deleteForm">
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
                        </thead>

                        <tbody>

                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><img src="/<?php echo e($product['image_path']); ?>" alt="<?php echo e($product['name']); ?>" width="40" height="40"></td>
                                        <td><?php echo e($product['name']); ?></td>
                                        <td><?php echo e($product['price']); ?></td>
                                        <td><?php echo e($product['quantity']); ?></td>
                                        <td><?php echo e($product['category_name']); ?></td>
                                        <td><?php echo e($product['sub_category_name']); ?></td>
                                        <td><?php echo e($product['added']); ?></td>

                                        <td width="70" class="text-right">

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit Product">
                                                <a href="/admin/product/<?php echo e($product['id']); ?>/edit"> Edit <i class="fa fa-edit"></i></a>
                                            </span>

                                        </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>

                        </tbody>
                    </table>
                    <?php if($productLinks): ?>
                        
                        <?php echo $productLinks; ?>


                    <?php endif; ?>

                    <?php else: ?>
                    <div class="column">
                        <h2>There is no Category Available</h2>
                    </div>

                <?php endif; ?>

            </div>
        </div>

    </div>





<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>