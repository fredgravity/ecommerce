<?php $__env->startSection('title', 'Login to your Account'); ?>
<?php $__env->startSection('data-page-id', 'auth'); ?>


<?php $__env->startSection('content'); ?>

    <div class="auth " id="auth">

        
        
            

        

        <section class="login_form grid-container">

            <div class="grid-x grid-padding-x" style="padding-top: 30px;">

                <div class="medium-2 cell">

                </div>

                <div class="cell small-12 medium-7 ">
                    <h2 class="text-center">Login</h2>

                    
                    <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    
                    <form action="" method="post" >


                        

                        <input type="text" name="username" placeholder="username or email" value="<?php echo e(\App\classes\Request::oldData('post', 'username')); ?>">

                        

                        <input type="password" name="password" placeholder="password">

                        
                        <label for="remember"> <input type="checkbox" name="remember_me" id="remember"> Remember Me </label>


                        <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">

                        <button class="button float-right success">Login</button>
                    </form>

                    <p>Don't have an Account? <a href="/register"> Register Here </a></p>
                    
                </div>

            </div>

        </section>



    </div>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>