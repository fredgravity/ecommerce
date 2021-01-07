
<div class="reveal" id="item-<?php echo e($category['id']); ?>" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up" >
    <div class="notification callout primary"></div>
    <h2>Edit Category</h2>
    
    <form>
        <div class="input-group">

            <input type="text" name="name" id="item-name-<?php echo e($category['id']); ?>" value="<?php echo e($category['name']); ?>">
            <div>
                <input type="submit" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>" value="Update" class="button update-category" id="<?php echo e($category['id']); ?>" >
            </div>

        </div>
    </form>
    

    <a href="/admin/product/categories" class="close-button" aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
