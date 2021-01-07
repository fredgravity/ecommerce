<?php $__env->startSection('title', 'Vendor Orders'); ?>
<?php $__env->startSection('data-page-id', 'vendorOrders'); ?>

<?php $__env->startSection('content'); ?>


    <div class="orders admin_shared grid-container full" id="orders">
        
        <div class="grid-padding-x grid-x">
            <div class="cell">
                <h2 class="text-center">Manage Orders</h2><hr>
            </div>
        </div>

            <div class="notify"></div>

        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-6 cell">
                <form action="" method="post">
                    <div class=" input-group">
                        <input type="text" class="input-group-field" placeholder="Search Order" id="searchOrder" name="search_field" value="<?php echo e(\App\classes\Request::oldData('post','search_field')); ?>" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        <div class="input-group-button">
                            <input type="button" value="Search" class="button search-order" @click.prevent="searchOrders">
                        </div>
                    </div>
                </form>

            </div>

            
            <div class="text-center">
                <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >

            </div>


            
            <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                <div class="small-12 medium-12 cell" v-if="showSearch">

                    <table class="hover unstriped search-table" data-form="deleteOrder" >
                        <thead>
                        <tr>
                            <td>Order No</td>
                            <td>Customer Name</td>
                            <td>Customer Email</td>
                            <td>Customer Phone#</td>
                            <td>Customer Location</td>
                            <td>Order Status</td>

                            <td width="100">Action</td>
                        </tr>
                        </thead>


                        <tbody>


                        <tr v-for="order in orderSearch" v-cloak>
                            
                            <td>{{ order.order_id }}</td>
                            <td>{{ order.user.fullname }}</td>
                            <td>{{ order.user.email }}</td>
                            <td>{{ order.user.phone }}</td>
                            <td>{{ order.user.country_name }}</td>
                            <td>{{ order.status }}</td>

                            <td  class="text-center">
                                <span data-tooltip class="has-tip top" tabindex="1" title="Show More">
                                    <a :data-open="'order-'+order.id"><i class="fa fa-plus"></i></a>
                                </span>
                                
                                
                                       
                                
                                &nbsp;
                                <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                    <form :action="'/admin/orders/'+ order.id + '/deleteorder'" method="post" class="delete-order">
                                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                        <button type="submit"><i class="fa fa-times delete"></i></button>
                                    </form>
                                </span>

                            </td>


                        </tr>
                        <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        </tbody>

                    </table>

                    <div v-if="orderSearch.length == 0">
                        <h2>The order you are looking for is not available</h2>
                    </div>

                    <div class="cell more-search-details" style="display: none;">
                        <div class="cell">
                            <h2 class="text-center">Manage Orders Details</h2><hr>
                        </div>
                    </div>





                </div>

                

                <div class="cell" v-else>


                        <?php if(count($orders)): ?>

                            
                            <table class="hover unstriped " data-form="deleteOrder">
                                <thead>
                                <tr>
                                    <td>Order No</td>
                                    <td>Customer Name</td>
                                    <td>Customer Email</td>
                                    <td>Customer Phone#</td>
                                    <td>Customer Location</td>
                                    <td>Order Status</td>
                                    <td width="100">Action</td>
                                </tr>
                                </thead>

                                <tbody>

                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                            <tr>
                                                
                                                <td><?php echo e($order->order_id); ?></td>
                                                <td><?php echo e($order->user->fullname); ?></td>
                                                <td><?php echo e($order->user->email); ?></td>
                                                <td><?php echo e($order->user->phone); ?></td>
                                                <td><?php echo e($order->user->country_name); ?></td>
                                                <td><?php echo e($order->status); ?></td>


                                                <td width="50" class="text-center">

                                                    <span data-tooltip class="has-tip top" tabindex="1" title="Show More">
                                                        <a data-open="order-<?php echo e($order->id); ?>"><i class="fa fa-plus"></i></a>
                                                    </span>
                                                    
                                                        
                                                    
                                                    &nbsp;
                                                    <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                                        <form action="/vendor/order/<?php echo e($order->order_id); ?>/deleteorder" method="post" class="delete-order">
                                                            <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                                            <button type="submit"><i class="fa fa-times delete" title="Delete Order"></i></button>
                                                        </form>
                                                    </span>

                                                </td>


                                            </tr>

                                            <?php echo $__env->make('includes.vendorOrder-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tbody>
                            </table>


                        <?php else: ?>
                            <div class="cell">
                                <h2>The order you are looking for is not available</h2>
                            </div>

                        <?php endif; ?>


                </div>


        </div>



    </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('vendor.layout.vendor_base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>