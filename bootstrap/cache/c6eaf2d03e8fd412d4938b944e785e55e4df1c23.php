<?php $__env->startSection('title', 'Contact Us'); ?>
<?php $__env->startSection('data-page-id', 'contact_us'); ?>


<?php $__env->startSection('content'); ?>

<div class="home">

    <div class="grid-container">

            <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="grid-padding-x grid-x">

            <div class="medium-2 cell">

            </div>

            <div class="small-12 medium-8 cell">


                <form action="/contactus/send" method="post" id="contact-us-form">

                    <h3 class="text-center contact-artisao-heading">Contact Artisao</h3>

                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" value="<?php echo e(\App\classes\Request::oldData('post', 'fullname')); ?>">

                    <label for="email">Email Address</label>
                    <input type="text" id="email" name="email" value="<?php echo e(\App\classes\Request::oldData('post', 'email')); ?>">

                    <label for="phone">Phone Number (optional)</label>
                    <input type="text" id="phone" name="phone" value="<?php echo e(\App\classes\Request::oldData('post', 'phone')); ?>">

                    <label for="message">Message to Us</label>
                    <textarea id="message"  cols="10" rows="10" name="message" ></textarea>

                    <input type="submit" class="button primary" value="Send">
                    <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">

                </form>

            </div>

            <div class="medium-2 column">

            </div>

        </div>

    </div>

</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>