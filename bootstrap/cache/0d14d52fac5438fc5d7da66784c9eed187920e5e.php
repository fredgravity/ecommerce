<?php $__env->startSection('title', 'Product Category'); ?>
<?php $__env->startSection('data-page-id', 'adminCategory'); ?>

<?php $__env->startSection('content'); ?>

    <div class="category admin_shared grid-container full">

        <div class="grid-x grid-padding-x">
            <div class="cell">
                <h2 class="text-center">Product Categories</h2><hr>
            </div>
        </div>


        <div class="grid-padding-x grid-x">
            
            <div class="small-12 medium-6 cell">
                
                <form action="" method="post">
                    
                    <div class="input-group">
                        <input type="text" class="input-group-field" placeholder="Search by name">

                        <div class="input-group-button">
                            <input type="submit" value="Search" class="button">
                        </div>
                    </div>

                    
                </form>
                
            </div>
            

            
            <div class="small-12 medium-6 end cell">
                
                <form action="" method="post">
                    
                    <div class="input-group">
                        <input type="text" class="input-group-field" name="name" placeholder="Category Name">
                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        <div class="input-group-button">
                            <input type="submit" value="Create" class="button">
                        </div>
                    </div>

                    
                </form>
                
            </div>
            

        </div>
        

        <div class="cell">
            <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>


        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-12 cell">

                <?php if(count($categories)): ?>

                    
                    <table class="hover unstriped" data-form="deleteForm">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Slug</td>
                                <td>Created On</td>
                                <td width="70">Action</td>
                            </tr>
                        </thead>

                        <tbody>

                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($category['name']); ?></td>
                                        <td><?php echo e($category['slug']); ?></td>
                                        <td><?php echo e($category['added']); ?></td>

                                        <td width="70" class="text-right">
                                            <span data-tooltip class="has-tip top" tabindex="1" title="Add Sub-Category">
                                                <a data-open="add-subcategory-<?php echo e($category['id']); ?>"><i class="fa fa-plus"></i></a>
                                            </span>

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit Category">
                                                <a data-open="item-<?php echo e($category['id']); ?>"><i class="fa fa-edit"></i></a>
                                            </span>

                                            <span style="display: inline-block" data-tooltip class="has-tip top" tabindex="1" title="Delete Category">
                                                <form action="/admin/product/categories/<?php echo e($category['id']); ?>/delete" method="post" class="delete-item">
                                                    <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                                    <button type="submit"><i class="fa fa-times delete"></i></button>
                                                </form>

                                            </span>

                                            <?php echo $__env->make('includes.add-subcategory-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <?php echo $__env->make('includes.edit-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>

                        </tbody>
                    </table>
                    <?php if($catLinks): ?>
                        
                        <?php echo $catLinks; ?>


                    <?php endif; ?>

                    <?php else: ?>
                    <div class="cell">
                        <h2>There is no Category Available</h2>
                    </div>

                <?php endif; ?>

            </div>
        </div>

    </div>



    <div class="subcategory admin_shared grid-container full">

        <div class="grid-x grid-padding-x">
            <div class="cell medium-11">
                <h2 class="text-center">Product Sub Categories</h2><hr>
            </div>

        </div>



        <div class="grid-padding-x grid-x">
            <div class="small-12 medium-16 cell">

                <?php if(count($subcategories)): ?>

                    
                    <table class="hover unstriped" data-form="deleteForm">
                        <thead>
                        <tr>
                            <td>Name</td>
                            <td>Slug</td>
                            <td>Created On</td>
                            <td width="50">Action</td>
                        </tr>
                        </thead>

                        <tbody>

                        <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($subcategory['name']); ?></td>
                                <td><?php echo e($subcategory['slug']); ?></td>
                                <td><?php echo e($subcategory['added']); ?></td>

                                <td width="50" class="text-right">

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit Sub Category">
                                                <a data-open="item-subcategory-<?php echo e($subcategory['id']); ?>"><i class="fa fa-edit"></i></a>
                                            </span>
                                            
                                            <span style="display: inline-block" data-tooltip class="has-tip top" tabindex="1" title="Delete Sub Category">
                                                <form action="/admin/product/subcategory/<?php echo e($subcategory['id']); ?>/delete" method="post" class="delete-item">
                                                    <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                                    <button type="submit"><i class="fa fa-times delete"></i></button>
                                                </form>

                                            </span>

                                    <?php echo $__env->make('includes.edit-subcategory-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                    <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                        </tbody>
                    </table>

                    

                    <?php echo $subcategoryLinks; ?>


                <?php else: ?>
                        <h3>There is no Sub Category Available</h3>

                <?php endif; ?>

            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>