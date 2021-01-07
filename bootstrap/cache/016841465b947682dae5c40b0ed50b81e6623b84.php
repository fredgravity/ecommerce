<?php $__env->startSection('title', 'Register for Vendor Account'); ?>
<?php $__env->startSection('data-page-id', 'auth'); ?>


<?php $__env->startSection('content'); ?>

    <div class="auth" id="auth">

        
        
            

        

        <section class="register_form grid-container full">

            <div class="grid-x grid-padding-x" style="padding-top: 30px;">

                <div class="medium-2 cell">

                </div>

                <div class="small-12 medium-7 cell">
                    <h2 class="text-center">Create A Vendor Account</h2>

                    
                    <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    
                    <form action="/register/vendor" method="post">

                        <input type="text" name="fullname" placeholder="full name" value="<?php echo e(\App\classes\Request::oldData('post', 'fullname')); ?>">

                        <input type="text" name="email" placeholder="email address" value="<?php echo e(\App\classes\Request::oldData('post', 'email')); ?>">

                        <input type="text" name="username" placeholder="username or brand name" value="<?php echo e(\App\classes\Request::oldData('post', 'username')); ?>">

                        

                        <input type="password" name="password" placeholder="password">

                        <select name="country_name" id="">
                            <option value="">Select your Country</option>
                            <option value="Ghana">Ghana</option>
                        </select>

                        <select name="state_name">
                            <option value="">Select your Region/State</option>
                            <option value="Greater Accra">Greater Accra</option>
                        </select>

                        <input type="text" name="phone" placeholder="Phone No. (eg. 0244001234)" value="<?php echo e(\App\classes\Request::oldData('post', 'phone')); ?>">

                        <input type="text" name="city"  placeholder="City" value="<?php echo e(\App\classes\Request::oldData('post', 'city')); ?>">

                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">

                        <button class="button float-right success">Register</button>
                    </form>

                    <p>Already have an Account? <a href="/login"> Sign In </a></p>

                    
                </div>

            </div>

        </section>



    </div>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>