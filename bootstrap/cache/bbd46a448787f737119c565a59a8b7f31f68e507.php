<?php $__env->startSection('title'); ?> <?php echo e($subItemName); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('data-page-id', 'subItem'); ?>


<?php $__env->startSection('content'); ?>

<div class="search-container" >


    <section class="display-product-search" id="root" data-token="<?php echo e($token); ?>" id="display-cat-items" >


        
        <div class="row medium-up-3 large-up-4">
            <h4 class="text-center">Subcategory - <?php echo e($subItemName); ?></h4>
            <div v-if="subItems == false"><p>No Category and Sub Category items</p></div>

            <div v-else class="small-12 column" v-cloak v-for="subItem in subItems">

                <a :href="'/product/' + subItem.id" class="featured-product-link-name">

                    <div class="card" data-equalizer-watch>

                        <div class="card-section">
                            <img :src="'/' + subItem.image_path" width="100%" height="200">
                        </div>

                        <div class="card-section">
                            <p> {{ stringLimit(subItem.name, 15) }} </p>

                            <a :href="'/product/' + subItem.id" class="button more expanded" > See More </a>

                            <a v-if="subItem.quantity" @click.prevent="addToCart(subItem.id)" class="button cart expanded secondary" >
                                ${{ subItem.price }} - Add to Cart
                            </a>
                            <a v-else  class="button cart expanded secondary" >
                                Out of Stock
                            </a>
                        </div>

                    </div>

                </a>

            </div>
        </div>

        
        <div class="text-center">
            <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" >
            
        </div>

    </section>


</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.search-base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>