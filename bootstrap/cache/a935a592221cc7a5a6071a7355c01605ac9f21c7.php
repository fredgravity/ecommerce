<?php $__env->startSection('title', 'Register for Free'); ?>
<?php $__env->startSection('data-page-id', 'auth'); ?>


<?php $__env->startSection('content'); ?>

    <div class="auth" id="auth">

        
        
            

        

        
        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <section class="register_form grid-container full">

            <div class="grid-x grid-padding-x" style="padding-top: 30px;">

                <div class="medium-2 cell">

                </div>


                <div class="small-12 medium-7 cell medium-centered">
                    <h2 class="text-center">Create An Account</h2>



                    
                    <form action="" method="post">
                        <input type="text" name="fullname" placeholder="full name" value="<?php echo e(\App\classes\Request::oldData('post', 'fullname')); ?>">

                        <input type="text" name="email" placeholder="email address" value="<?php echo e(\App\classes\Request::oldData('post', 'email')); ?>">

                        <input type="text" name="username" placeholder="username" value="<?php echo e(\App\classes\Request::oldData('post', 'username')); ?>">

                        

                        <input type="password" name="password" placeholder="password">

                        <select name="country_name">
                            <option value="">Select your Country</option>
                            <option value="Ghana">Ghana</option>
                        </select>

                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">

                        <button class="button float-right success">Register</button>
                    </form>

                    <p>Already have an Account? <a href="/login"> Sign In </a></p>
                    <p>Want to Sell your African Brands? <a href="/vendor-register"> Sign up </a> now for a Vendor's Account</p>
                    
                </div>

            </div>

        </section>



    </div>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>