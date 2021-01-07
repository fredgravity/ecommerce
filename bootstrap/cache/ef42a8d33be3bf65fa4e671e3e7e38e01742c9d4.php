
<div class="reveal" id="item-subcategory-<?php echo e($subcategory['id']); ?>" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up" >
    <div class="notification callout primary"></div>
    <h2>Edit Sub Category</h2>
    
    <form>
        <div class="input-group">

            <input type="text" name="name" id="item-subcategory-name-<?php echo e($subcategory['id']); ?>" value="<?php echo e($subcategory['name']); ?>">

            <label >Change Category
                <select  id="item-category-<?php echo e($subcategory['category_id']); ?>">

                    <?php $__currentLoopData = \App\Models\Category::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($category->id == $subcategory['category_id']): ?>
                            <option selected="selected" value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                            <?php endif; ?>

                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </select>
            </label>

            <div>
                <input type="submit" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>" value="Update" class="button update-subcategory" id="<?php echo e($subcategory['id']); ?>" data-category-id="<?php echo e($subcategory['category_id']); ?>" >
            </div>

        </div>
    </form>
    

    <a href="/admin/product/categories" class="close-button hollow" aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
