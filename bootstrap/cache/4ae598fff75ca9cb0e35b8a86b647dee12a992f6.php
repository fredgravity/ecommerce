
<div class="reveal contact-seller-modal row align-center" id="product-modal" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-up" >

    <h3 class="modal-title text-center column">Contact Vendor</h3>

    <div class="column">

        <form action="/contact-vendor/<?php echo e($product->user->id); ?>" method="post" class="small-12 medium-12" id="contact-seller-modal-form">

            <h5>Customer Info</h5>
            <hr>

            <?php if(isAuthenticated()): ?>
                <label for="username">Username: </label>
                <input type="text" id="username" name="username" value="<?php echo e(user()->username); ?>" readonly>

                <label for="email">Email: </label>
                <input type="text" id="email" name="email" value="<?php echo e(user()->email); ?>" readonly>
                <?php endif; ?>


            <h5>Vendor Info</h5>
            <hr>

            <label for="country">Vendor's Country </label>
            <input type="text" id="country" name="country" value="<?php echo e($product->user->country_name); ?>" readonly>


            <label for="product_name">Product: </label>
            <input type="text" id="product_name" name="product_name" value="<?php echo e($product->name); ?>" readonly>

            <label for="quantity">Product: </label>
            <select name="quantity" id="quantity">
                <?php for($i = 1; $i <= 50; $i++): ?>
                    <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>readonly
                    <?php endfor; ?>
            </select>

            <div>
                <div class="float-left">
                    <h2>$ <?php echo e($product->price); ?></h2>
                </div>

                <div class="float-right">
                    <?php if($product->quantity > 0): ?>
                        <input class="success hollow button " value="Order Now!" id="order-now" type="submit">
                        <?php else: ?>
                        <input class="success hollow button " value="Order Now!" id="order-now" type="submit" disabled="">
                        <?php endif; ?>

                    <button class="button warning hollow" data-close aria-label="close modal" type="button">Cancel</button>
                </div>

                <input type="hidden" name="token" value="<?php echo e(\App\Classes\CSRFToken::generate()); ?>">

            </div>

        </form>
    </div>



    
        
    



</div>