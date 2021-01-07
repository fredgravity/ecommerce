<?php $__env->startSection('title', 'Manage Vendor Inventory'); ?>
<?php $__env->startSection('data-page-id', 'vendorProduct'); ?>

<?php $__env->startSection('content'); ?>

    <div class="products admin_shared grid-container full" id="vendor_inventory">

        <div class="grid-padding-x grid-x">
            <div class="cell">
                <h2 class="text-center">Manage Inventory</h2><hr>
            </div>
        </div>


        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-6 cell">
                <form action="" method="post">
                    <div class=" input-group">
                        <input type="text" class="input-group-field" placeholder="Search by name" name="search_field" id="searchVendorProduct" value="<?php echo e(\App\classes\Request::oldData('post','search_field')); ?>" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        <div class="input-group-button">
                            <input type="submit" value="Search" class="button search-product" @click.prevent="search">
                        </div>
                        <input type="hidden">
                    </div>
                </form>
            </div>

            <div class="small-12 medium-6 cell">
                <a href="/vendor/product/create" class="button float-right"> <i class="fa fa-plus"></i> Add New Product </a>
            </div>


        </div>

        
        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="grid-padding-x grid-x" v-if="showSearch">
            <div class="cell" v-if="searchProduct">



                
                <table class="hover unstriped" data-form="deleteOrder">
                    <thead>
                    <tr>
                        <td>Image</td>
                        <td>Name</td>
                        <td>Price</td>
                        <td>Stock</td>
                        <td>Category</td>
                        <td>Subcategory</td>
                        <td>Created On</td>
                        <td width="70">Action</td>
                    </tr>
                    </thead>

                    <tbody>

                    <template v-for="product in searchProduct">
                        <tr v-if="product.user_id === userId">

                            <td><img :src="'/'+product.image_path" :alt="product.name" width="40" height="40"></td>
                            <td>{{ product.name }}</td>
                            <td>GHS {{ product.price }}</td>
                            <td>{{ product.quantity }}</td>
                            <td>{{ product.category.name}}</td>
                            <td>{{ product.sub_category.name}}</td>
                            <td>{{ product.created_at }}</td>



                            <td width="30" class="text-center">

                                        <span data-tooltip class="has-tip top" tabindex="1" title="Edit Product">
                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit Product">
                                                <a :href="'/vendor/product/'+product.id+'/edit'"> Edit <i class="fa fa-edit"></i></a>
                                            </span>
                                        </span>

                            </td>


                        </tr>
                    </template>


                    </tbody>
                </table>




            </div>


            <div class="cell" v-if="searchProduct < 1">
                <h2>The Product you are looking for is not available</h2>
            </div>

        </div>

        

        <div class="grid-x grid-padding-x" v-else>
            <div class="cell">

                <?php if(count($products)): ?>

                    
                    <table class="hover unstriped" data-form="deleteForm">
                        <thead>
                            <tr>
                                <td>Image</td>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Stock</td>
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
                                        <td>GHS     <?php echo e($product['price']); ?></td>
                                        <td><?php echo e($product['quantity']); ?></td>
                                        <td><?php echo e($product['category_name']); ?></td>
                                        <td><?php echo e($product['sub_category_name']); ?></td>
                                        <td><?php echo e($product['added']); ?></td>

                                        <td width="70" class="text-right">

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit Product">
                                                <a href="/vendor/product/<?php echo e($product['id']); ?>/edit"> Edit <i class="fa fa-edit"></i></a>
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
                    <div class="cell">
                        <h2>The Product you are looking for is not available</h2>
                    </div>

                <?php endif; ?>

            </div>
        </div>

    </div>





<?php $__env->stopSection(); ?>


<?php echo $__env->make('vendor.layout.vendor_base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>