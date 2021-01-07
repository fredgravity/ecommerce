<?php $__env->startSection('title'); ?> <?php echo e($categoryItemName); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('data-page-id', 'categoryItem'); ?>


<?php $__env->startSection('content'); ?>

<div class="search-container" >


    <section class="display-product-search" id="root" data-token="<?php echo e($token); ?>"  >

        
        <div class="row medium-up-3 large-up-4" id="display-cat-items">

            

            <div v-if="categoryItems == false"><p>No Category and Sub Category items</p></div>

            <div v-else class="small-12 column" v-cloak v-for="categoryItem in categoryItems">

                <a :href="'/product/' + categoryItem.id" class="featured-product-link-name">

                    <div class="card" data-equalizer-watch>

                        <div class="card-section">
                            <img :src="'/' + categoryItem.image_path" width="100%" height="200">
                        </div>

                        <div class="card-section">
                            <p> {{ stringLimit(categoryItem.name, 15) }} </p>

                            <a :href="'/product/' + categoryItem.id" class="button more expanded" > See More </a>

                            <a v-if="categoryItem.quantity" @click.prevent="addToCart(categoryItem.id)" class="button cart expanded secondary" >
                                ${{ categoryItem.price }} - Add to Cart
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