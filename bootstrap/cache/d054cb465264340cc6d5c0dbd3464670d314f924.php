<?php $__env->startSection('title', 'Users Dashboard'); ?>
<?php $__env->startSection('data-page-id', 'usersDashboard'); ?>

<?php $__env->startSection('content'); ?>

    <div class="admin_shared users dashboard">

        <div class="grid-x grid-padding-x medium-padding-collapse" data-equalizer data-equalizer-on="medium">

            <div class="small-12 medium-4 cell summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="grid-x grid-padding-x">
                            <div class="small-3 cell">
                                <i class="fa fa-user icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Users</p><h4><?php echo e($totalUsers); ?></h4>
                            </div>
                        </div>

                    </div>

                    <div class="card-divider">
                        <a href="/admin/users-details">Users Details</a>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-4 cell summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="grid-x grid-padding-x">
                            <div class="small-3 cell">
                                <i class="fa fa-toolbox icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Vendors</p><h4><?php echo e($totalVendors); ?></h4>
                            </div>
                        </div>

                    </div>

                    <div class="card-divider">
                        <a href="/admin/vendors-details">Vendors Details</a>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-4 cell summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="grid-x grid-padding-x">
                            <div class="small-3 cell">
                                <i class="fa fa-users icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Subscribers</p><h4><?php echo e($allUsers); ?></h4>
                            </div>
                        </div>

                    </div>

                    <div class="card-divider">
                        <a href="#">Subscribers</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="grid-container">
        <div class="grid-x grid-padding-x" >
            <div class="small-12 medium-6 cell graph">
                <div class="card">

                    <div class="card-section monthly-revenue">
                        <h4>Users</h4>
                        <canvas id="total-users"></canvas>
                    </div>

                </div>
            </div>

            <div class="small-12 medium-6 cell graph">
                <div class="card">

                    <div class="card-section monthly-revenue">
                        <h4>Vendors</h4>
                        <canvas id="total-vendors"></canvas>
                    </div>

                </div>
            </div>

        </div>

        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-12 cell graph">
                <div class="card">

                    <div class="card-section monthly-revenue">
                        <h4>Subscribers</h4>
                        <canvas id="total-subscribers"></canvas>
                    </div>

                </div>

            </div>
        </div>


    </div>





    <?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>