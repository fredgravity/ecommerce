
<div class="reveal" id="order-<?php echo e($order->id); ?>" data-reveal data-close-on-click="true" data-close-on-esc="false" data-animation-in="scale-in-up" >
    <div class="notification callout primary"></div>
    <h3 class="text-center"> <?php echo e($order->order_id); ?></h3>
    <div class="grid-x grid-padding-x vendor-order-modal">
        <div class="small-12 medium-6 cell image">
            <div >
                <img src="/<?php echo e($order->product->image_path); ?>" alt="<?php echo e($order->product->name); ?>">
            </div>
        </div>
        <div class="small-12 medium-6 cell details">
            <p>Product Name: &nbsp;  <?php echo e($order->product->name); ?> </p>
            <p>Product Price:   GHS <?php echo e(number_format($order->product->price,2)); ?></p>
            <p>Quantity Bought: <?php echo e($order->quantity); ?></p>
            <p>Total Amount:   GHS <?php echo e(number_format($order->total, 2)); ?></p>
            <p>Status:
                <select name="status" id="vendor-order-status">
                    <option value="<?php echo e($order->status); ?>" selected disabled><?php echo e($order->status); ?></option>
                    <option value="pending">pending</option>
                    <option value="paid">paid</option>

                </select>
            </p>

            <input type="hidden" id="vendor-order-modal-token" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>"  >

            <input type="hidden" id="vendor-order-modal-invoiceId" value="<?php echo e($order->order_id); ?>" >

            <input type="hidden" id="vendor-order-modal-productId" value="<?php echo e($order->product->id); ?>" >

        </div>
    </div>
    <div class="text-center"> <h4>Date Ordered:   <?php echo e($order->created_at->toFormattedDateString()); ?></h4></div>

    <a href="/vendor/orders" class="close-button" aria-label="Close modal" type="button" data-close-on-click="true">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
