<?php $__env->startSection('title', 'Edit User'); ?>
<?php $__env->startSection('data-page-id', 'editUser'); ?>

<?php $__env->startSection('content'); ?>

    <div class="edit-user admin_shared" id="edit-user">

        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="row expanded">
            <div class="column medium-11">
                <h2 class="text-center">Edit <?php echo e(ucfirst($user->role)); ?></h2>
                <hr>
            </div>
        </div>

        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="row expanded">

            <div class="column small-12 medium-6">
                <form action="/admin/user/<?php echo e($user->id); ?>/update" method="post" enctype="multipart/form-data">

                    <fieldset class="fieldset">
                        <legend><h2><?php echo e(ucfirst($user->role)); ?> Details</h2></legend>

                        <div>
                            <label for="username">Username:</label>
                            <input type="text" name="username" value="<?php echo e($user->username); ?>" readonly="readonly">
                        </div>

                        <div>
                            <label for="fullname">Fullname:</label>
                            <input type="text" name="fullname" value="<?php echo e($user->fullname); ?>">
                        </div>

                        <div>
                            <label for="email">Email:</label>
                            <input type="text" name="email" value="<?php echo e($user->email); ?>" disabled>
                        </div>

                        <div>
                            <label for="country">Country:</label>
                            <input type="text" name="country" value="<?php echo e($user->country_name); ?>">
                        </div>

                        <div>
                            <label for="state">State Name:</label>
                            <input type="text" name="state" value="<?php echo e($user->state_name); ?>">
                        </div>


                        <div>
                            <label for="phone">Phone #:</label>
                            <input type="text" name="phone" value="<?php echo e($user->phone); ?>">
                        </div>


                        <div>
                            <label for="city">Address:</label>
                            <input type="text" name="city" value="<?php echo e($user->city); ?>">
                        </div>


                        <div>
                            <label for="upload" class="button">Upload Picture</label>
                            <input type="file" id="upload" name="upload" class="show-for-sr" >
                        </div>

                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        <input type="submit" value="Update" class="button warning float-right">


                    </fieldset>

                </form>
            </div>



            <div class="column small-12 medium-5 end">

                <form action="/admin/user/<?php echo e($user->id); ?>/changepassword" method="post" >
                    <fieldset class="fieldset">
                        <legend><h2>Change Password</h2></legend>
                        <div>
                            <label for="old_password">Old Password:</label>
                            <input type="password" name="old_password" placeholder="type in the old password">
                        </div>

                        <div>
                            <label for="new_password">New Password:</label>
                            <input type="password" name="new_password" placeholder="type in the new password">
                        </div>

                        <div>
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" name="confirm_password" placeholder="confirm password">
                        </div>

                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">
                        <input type="submit"  value="Change" class="button warning float-right">
                    </fieldset>
                </form>

            </div>

        </div>



        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>













    <?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>