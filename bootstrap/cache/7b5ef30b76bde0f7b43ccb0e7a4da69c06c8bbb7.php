<?php $__env->startSection('title', 'Mail to Mailing List'); ?>
<?php $__env->startSection('data-page-id', 'broadcast'); ?>


<?php $__env->startSection('content'); ?>



    <div class="grid-container full admin_shared">

            <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="grid-padding-x grid-x">

            <div class="medium-2 cell">

            </div>

            <div class="small-12 medium-8 cell">


                <form action="/admin/send/broadcast" method="post" id="contact-us-form">

                    <h3 class="text-center contact-artisao-heading">Send To Mailing List</h3>

                    <label for="email">From</label>
                    <input type="text" id="email" name="email" value="<?php echo e(user()->email); ?>">

                    <label for="mailList">To</label>
                    <select name="mailList" id="mailList">
                        <option value="user">Users</option>
                        <option value="vendor">Vendors</option>
                    </select>


                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" value="<?php echo e(\App\classes\Request::oldData('post', 'subject')); ?>">

                    <label for="message">Message</label>
                    <textarea id="message"  cols="10" rows="10" name="message" ><?php echo e(\App\classes\Request::oldData('post', 'message')); ?></textarea>

                    <input type="submit" class="button primary" value="Send">
                    <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">

                </form>

            </div>

            <div class="medium-2 column">

            </div>

        </div>

    </div>





<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>