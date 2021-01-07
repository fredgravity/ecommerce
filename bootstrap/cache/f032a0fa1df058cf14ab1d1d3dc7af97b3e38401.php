
<div class="reveal" id="add-subcategory-<?php echo e($category['id']); ?>" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up" >
    <div class="notification callout primary"></div>
    <h2>Add Sub Category</h2>
    
    <form>
        <div class="input-group">

            <input type="text" id="subcategory-name-<?php echo e($category['id']); ?>">
            <div>
                <input type="submit" id="<?php echo e($category['id']); ?>" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>" value="Create" class="button add-subcategory"                                                                     update-category" id="<?php echo e($category['id']); ?>" >
            </div>

        </div>
    </form>
    

    <a href="/admin/product/categories" class="close-button" aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
