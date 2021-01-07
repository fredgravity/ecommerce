<?php $__env->startSection('title', 'Vendor Dashboard'); ?>
<?php $__env->startSection('data-page-id', 'vendorDashboard'); ?>

<?php $__env->startSection('content'); ?>

    <div class="dashboard admin_shared grid-container full" data-equalizer data-equalizer-on="medium">
        <div class="grid-padding-x grid-x medium-padding-collapse" >

            
            <div class="small-12 medium-4 cell summary" data-equalizer-watch>

                <div class="card">
                    <div class="card-section">
                        <div class="grid-padding-x grid-x">
                            <div class="small-3 cell">
                                <i class="fa fa-shopping-cart icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Total Orders</p> <h4><?php echo e($orders); ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-divider">
                        <div class="cell">
                            <a href="/vendor/orders">Order Details</a>
                        </div>
                    </div>
                </div>

            </div>

            
            <div class="small-12 medium-4 cell summary" data-equalizer-watch>

                <div class="card">
                    <div class="card-section">
                        <div class="grid-x grid-padding-x">
                            <div class="small-3 cell">
                                <i class="fa fa-truck-loading icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Pending Orders</p> <h4><?php echo e($ordersPending); ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-divider">
                        <div class="cell">
                            <a href="/vendor/orders">Order Details</a>
                        </div>
                    </div>
                </div>

            </div>


            
            <div class="small-12 medium-4 cell summary" data-equalizer-watch >

                <div class="card">
                    <div class="card-section">
                        <div class="grid-padding-x grid-x">
                            <div class="small-3 cell">
                                <i class="fa fa-hand-holding-usd icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Orders Sold</p> <h4>$<?php echo e(number_format($ordersPaid, 2)); ?></h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-divider">
                        <div class="cell">
                            <a href="/vendor/revenue">Payment Details</a>
                        </div>
                    </div>
                </div>

            </div>



        </div>

        <div class="grid-x grid-padding-x medium-padding-collapse graph">
            <div class="small-12 medium-6 cell monthly-sales">
                <div class="card">

                    <div class="card-section">
                        <h4>Monthly Orders</h4>
                        <canvas id="monthly-order"></canvas>
                    </div>

                </div>
            </div>

            <div class="small-12 medium-6 cell monthly-revenue">
                <div class="card">

                    <div class="card-section">
                        <h4>Monthly Renenue</h4>
                        <canvas id="monthly-revenue"></canvas>
                    </div>

                </div>
            </div>

        </div>
    </div>




    <?php $__env->stopSection(); ?>


<?php echo $__env->make('vendor.layout.vendor_base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>