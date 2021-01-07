<?php $__env->startSection('title', 'Orders'); ?>
<?php $__env->startSection('data-page-id', 'userOrders'); ?>

<?php $__env->startSection('content'); ?>


    <div class="orders admin_shared grid-container full" id="orders" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">

        <div class="grid-padding-x grid-x">
            <div class="cell">
                <h2 class="text-center">Manage Order Details</h2><hr>
            </div>
        </div>

        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-6 cell">
                <form action="" method="post" class="small-12 medium-5 cell">
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


            <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


            <div class="cell " v-if="showSearch" v-cloak>
                <div class="cell" v-if="orderSearch" v-cloak>


                        
                        <table class="hover unstriped small-12" data-table="delete-user-Order">
                            <thead>
                            <tr>
                                <td>Product Image</td>
                                <td>Order No</td>
                                <td>Product Name</td>
                                <td>Order Qty</td>
                                <td>Order Amount</td>
                                <td>Order Status</td>
                                <td>Rate</td>
                                
                                <td>Order Date</td>
                                <td width="30">Action</td>
                            </tr>
                            </thead>

                            <tbody v-for="order in orderSearch" v-cloak>

                            

                                <tr v-if="order.user_id === userId" v-cloak>

                                    <td><img :src="'/'+order.product.image_path" :alt="order.product.name" width="40" height="40"></td>
                                    <td>{{ order.order_id }}</td>
                                    <td>{{ order.product.name }}</td>
                                    <td>{{ order.quantity}}</td>
                                    <td>GHS {{ order.total }}</td>
                                    <td>{{ order.status }}</td>
                                    <td>
                                        <select name="rating" id="rating-value" @change="sendRate(order.product.id, $event)">
                                            <?php for( $x = 1; $x<6; $x++ ): ?>
                                                <option value="<?php echo e($x); ?>"><?php echo e($x); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>

                                    

                                    <td>{{ order.created_at }}</td>



                                    <td width="30" class="text-center">

                                        <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                            <form :action="'/user/orders/' + order.id + '/deleteorder'" method="post" class="deleteUser-order" >
                                                <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                                <button type="submit"><i class="fa fa-times delete" title="Delete Order" @click.prevent="deleteUserOrder" ></i></button>
                                            </form>

                                            
                                                
                                                    
                                                    
                                                
                                            

                                        </span>

                                    </td>


                                </tr>
                            


                            </tbody>
                        </table>


                </div>


                <div class="cell" v-if="orderSearch < 1">
                    <h2>The order you are looking for is not available</h2>
                </div>

            </div>


            


            <div class="cell " v-else>


                <?php if(count($orderDetails)): ?>

                     
                    <table class="hover unstriped small-12" data-form="deleteOrder">
                        <thead>
                        <tr>
                            <td>Product Image</td>
                            <td>Order No</td>
                            <td>Product Name</td>
                            <td>Order Qty</td>
                            <td>Order Amount</td>
                            <td>Order Status</td>
                            <td>Rate</td>
                            
                            <td>Order Date</td>
                            <td width="30">Action</td>
                        </tr>
                        </thead>

                        <tbody>


                             <?php $__currentLoopData = $orderDetailsWithProduct; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 
                                        <?php if($item->user_id == user()->id): ?>
                                        <tr>
                                            <td><img src="/<?php echo e($item->product->image_path); ?>" alt="<?php echo e($item->product->name); ?>" width="40" height="40"></td>
                                            <td><?php echo e($item->order_id); ?></td>
                                            <td><?php echo e($item->product->name); ?></td>
                                            <td><?php echo e($item->quantity); ?></td>
                                            <td>GHS <?php echo e($item->total); ?></td>
                                            <td><?php echo e($item->status); ?></td>
                                            <td>
                                                <select name="rating" class="rating-value" @change="sendRate(<?php echo e($item->product->id); ?>,$event)">
                                                    <?php for( $x = 1; $x<6; $x++ ): ?>
                                                        <option value="<?php echo e($x); ?>"><?php echo e($x); ?></option>

                                                    <?php endfor; ?>
                                                </select>
                                            </td>


                                            <td><?php echo e($item->created_at->toFormattedDateString()); ?></td>
                                            


                                            <td width="30" class="text-center">
                                                <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                                    <form action="/user/orders/<?php echo e($item->id); ?>/deleteorder" method="post" class="delete-order">
                                                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                                        <button type="submit"><i class="fa fa-times delete" title="Delete Order"></i></button>
                                                    </form>
                                                </span>
                                            </td>


                                        </tr>



                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>






                        


                        </tbody>
                    </table>




                    <?php if($orderDetailsLinks): ?>
                         
                        <?php echo $orderDetailsLinks; ?>


                    <?php endif; ?>


                    



                <?php else: ?>
                    <div class="cell">
                        <h2>The order you are looking for is not available</h2>
                    </div>

                <?php endif; ?>




            </div>
        </div>



    </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('user.layout.user_base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>