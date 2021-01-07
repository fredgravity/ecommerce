
<div class="reveal" :id="'orderItem-'+order.id" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up" >
    <div class="notification callout primary"></div>
    <h2>Edit Order Details</h2>
    
    <form>
        <div class="input-group">

            <input type="text" name="id" :id="'order-name-'+order.id" :value="order.order_id">
            <div>
                <input type="submit" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>" value="Update" class="button update-category" :id="order.id" >
            </div>

        </div>
    </form>
    

    <a href="/admin/orders" class="close-button" aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
