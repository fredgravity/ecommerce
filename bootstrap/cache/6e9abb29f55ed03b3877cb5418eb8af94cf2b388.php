<?php $__env->startSection('title', 'Orders'); ?>
<?php $__env->startSection('data-page-id', 'productOrders'); ?>

<?php $__env->startSection('content'); ?>


    <div class="orders admin_shared grid-container full" id="orders">
        
        <div class="grid-x grid-padding-x">
            <div class="cell">
                <h2 class="text-center">Manage Orders</h2><hr>
            </div>
        </div>


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

                            <td  class="text-center">
                                        <span data-tooltip class="has-tip top" tabindex="1" title="View more" >
                                            <i class="fa fa-angle-double-down" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>" id="more-search" title="View more" @click="searchMoreOrders(order.id)" style="cursor:pointer;"></i>
                                        </span>
                                &nbsp;
                                <span data-tooltip class="has-tip top" tabindex="1" title="hide more" >
                                            <i class="fa fa-angle-double-up" title="hide more" @click="searchLessOrders" style="cursor:pointer;"></i>
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

                    <div class="grid-x grid-padding-x more-search-details" style="display: none;">
                        <div class="cell">
                            <h2 class="text-center">Manage Orders Details</h2><hr>
                        </div>
                    </div>


                    <div class="cell  more-search-details" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>"  style="display: none;" >
                        <table data-form="deleteOrder">
                            <tr>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date Ordered</th>
                                <th width="70">Action</th>
                            </tr>


                            <tbody v-cloak v-for="(order) in orderDetails">
                            <tr>
                                <td>{{ order.quantity }}</td>
                                <td>{{ order.unit_price }}</td>
                                <td>{{ order.total }}</td>
                                <td>{{ order.status }}</td>
                                <td>{{ order.created_at }}</td>

                                <td class="text-center">

                                     <span data-tooltip class="has-tip top" tabindex="1" title="Edit Order">
                                            <a :href="'/admin/orders/'+ order.id + '/edit'" ><i class="fa fa-edit"></i></a>
                                     </span>
                                    &nbsp;
                                    <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                        <form :action="'/admin/orders/'+ order.id + '/deleteorderdetails'" method="post" class="delete-order">
                                            <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                            <button type="submit"><i class="fa fa-times delete"></i></button>
                                        </form>
                                    </span>
                                </td>
                            </tr>



                            </tbody>
                        </table>



                    </div>


                </div>

                

                <div class="cell small-12 medium-12" v-else>


                        <?php if(count($orders)): ?>

                            
                            <table class="hover unstriped small-12" data-form="deleteOrder">
                                <thead>
                                <tr>
                                    <td>Order No</td>
                                    <td>Customer Name</td>
                                    <td>Customer Email</td>
                                    <td>Customer Phone#</td>
                                    <td>Customer Location</td>
                                    <td width="100">Action</td>
                                </tr>
                                </thead>

                                <tbody>

                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php if($order['user_id'] == $user->id): ?>
                                            <tr>
                                                
                                                <td><?php echo e($order['order_id']); ?></td>
                                                <td><?php echo e($user->fullname); ?></td>
                                                <td><?php echo e($user->email); ?></td>
                                                <td><?php echo e($user->phone); ?></td>
                                                <td><?php echo e($user->country_name); ?></td>


                                                <td width="50" class="text-center">
                                                    <span data-tooltip class="has-tip top" tabindex="1" title="View more" >
                                                        <i class="fa fa-angle-double-down" title="View more" @click="moreOrders(<?php echo e($order['id']); ?>)" style="cursor:pointer;"></i>
                                                    </span>
                                                    &nbsp;
                                                    <span data-tooltip class="has-tip top" tabindex="1" title="hide more" >
                                                        <i class="fa fa-angle-double-up" title="hide more" @click="lessOrders(<?php echo e($order['id']); ?>)" style="cursor:pointer;"></i>
                                                    </span>
                                                    &nbsp;
                                                    <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                                        <form action="/admin/orders/<?php echo e($order['id']); ?>/deleteorder" method="post" class="delete-order">
                                                            <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                                            <button type="submit"><i class="fa fa-times delete" title="Delete Order"></i></button>
                                                        </form>
                                                    </span>

                                                </td>


                                            </tr>



                                        <?php endif; ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                </tbody>
                            </table>




                            <?php if($orderLinks): ?>
                                
                                <?php echo $orderLinks; ?>


                            <?php endif; ?>


                            <div class="cell moreOrder" style="display: none;">
                                <div class="cell">
                                    <h2 class="text-center" >Manage Orders Details</h2>
                                </div>
                            </div>

                            <div id="more" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>" v-if="orderDetails" style="display: none;"  class="moreOrder cell">
                                <table data-form="deleteOrder">
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date Ordered</th>
                                        <th width="70">Action</th>
                                    </tr>



                                    <tbody v-cloak v-for="(detail) in orderDetails">
                                    <tr>
                                        <td>{{ detail.quantity }}</td>
                                        <td>{{ detail.unit_price }}</td>
                                        <td>{{ detail.total }}</td>
                                        <td>{{ detail.status }}</td>
                                        <td>{{ detail.created_at }}</td>
                                        <td class="text-center">
                                        <span data-tooltip class="has-tip top" tabindex="1" title="Edit Detail">
                                            <a :href="'/admin/orders/'+ detail.id + '/edit'" ><i class="fa fa-edit" title="Edit Detail"></i></a>
                                        </span>
                                            &nbsp;

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                            <form :action="'/admin/orders/'+detail.id+'/deleteorderdetails'" method="post" class="delete-order">
                                                <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                                <button type="submit"><i class="fa fa-times delete" title="Delete Detail"></i></button>
                                            </form>
                                        </span>
                                        </td>
                                    </tr>

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



    </div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>