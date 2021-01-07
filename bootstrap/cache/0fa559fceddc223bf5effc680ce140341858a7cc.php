<?php $__env->startSection('title', 'Edit Orders'); ?>
<?php $__env->startSection('data-page-id', 'editOrders'); ?>

<?php $__env->startSection('content'); ?>

    <div class="edit-orderDetails admin_shared grid-container full" id="edit-orderDetails">

        <?php $__currentLoopData = $orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="grid-x grid-padding-x">
                <div class="cell medium-12">
                    <h2 class="text-center">Edit Order - <?php echo e($orderDetail->order_id); ?></h2><hr>
                </div>
            </div>

            <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="grid-x grid-padding-x medium-padding-collapse">
                
                    <div class="small-12 medium-6 cell" >
                        <div class="text-center">
                            <img src="/<?php echo e($orderDetail->product->image_path); ?>" class="edit-order-image" alt="order-image">
                            <h4> <?php echo e($orderDetail->product->name); ?></h4>
                        </div>
                        <div class="grid-x order-details-info">
                            <div class="small-12  medium-6 cell text-left">

                                <p><strong>Unit Price:</strong>$ <?php echo e($orderDetail->product->price); ?></p>
                                <p><strong>Order Quantity:</strong> <?php echo e($orderDetail->quantity); ?></p>
                                <p><strong>Order Status:</strong> <?php echo e($orderDetail->status); ?></p>
                            </div>
                            <div class="small-12  medium-6 cell  end text-left">
                                <p><strong>User Name:</strong> <?php echo e($orderDetail->user->fullname); ?></p>
                                <p><strong>User Phone:</strong> <?php echo e($orderDetail->user->phone); ?></p>
                                <p><strong>User Location:</strong> <?php echo e($orderDetail->user->country_name); ?></p>
                            </div>
                        </div>
                        <div class="cell text-center">
                            <div class="cell order-details-desc">
                                <h6><strong>Product Description:</strong> </h6>
                                <p><?php echo e($orderDetail->product->description); ?></p>
                            </div>
                        </div>


                    </div>

                    <div class="small-12 medium-5 cell  order-update-form" >
                        <div class="input-group cell order-update-form">
                            <form action="/admin/orders/<?php echo e($orderDetail->id); ?>/update" method="post">

                                <div class="cell small-12">

                                    <label for="quantity">Change Order Quantity:</label>
                                        <select name="quantity" id="quantity">
                                            <?php for($i=1; $i <= 50; $i++ ): ?>
                                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                            <?php endfor; ?>
                                        </select>

                                </div>
                                <div class="cell small-12 ">
                                    <label for="status">Change Order Status:</label>
                                    <select name="status" id="status">
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                    </select>
                                </div>

                                <div class="cell text-center">
                                    <div class="small-12">
                                        <h1><strong>$<?php echo e(number_format($orderDetail->total, 2)); ?></strong></h1>
                                    </div>

                                    <div class="small-12 align-center">
                                        <input type="submit" class="button primary expanded" value="Update">
                                    </div>

                                    <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                                    <input type="hidden" name="unit_price" value="<?php echo e($orderDetail->unit_price); ?>">

                                </div>

                            </form>
                        </div>


                    </div>
                </div>

            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>






    </div>

    <?php echo $__env->make('includes.delete-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>