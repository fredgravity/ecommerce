<?php $__env->startSection('title', 'Search Product'); ?>
<?php $__env->startSection('data-page-id', 'searchProduct'); ?>


<?php $__env->startSection('content'); ?>

    <div class="search-container" >


        <section class="display-product-search" id="root-search" data-token="<?php echo e($token); ?>" data-word="<?php echo e($searchWord); ?>" >

            
            <div class="row medium-up-3 large-up-4" id="display-search-items" v-if="products">
                


                    <div v-if="show" class="small-12 column" v-cloak v-for="categoryItem in products">

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
                    <div v-else><p>No Category and Sub Category items</p></div>




            </div>



            

            <div v-else class="row medium-up-3 large-up-4" id="display-products">

                <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="small-12 column">

                    <a href="/product/<?php echo e($result->id); ?>" class="featured-product-link-name">

                        <div class="card">

                            <div class="card-section">
                                <img src="/<?php echo e($result->image_path); ?>" width="100%" height="200">
                            </div>

                            <div class="card-section">
                                <p><?php echo e($result->name); ?></p>
                                <a href="/product/<?php echo e($result->id); ?>" class="button more expanded" > See More </a>

                                <?php if($result->quantity): ?>
                                    <a  @click.prevent="addToCart(categoryItem.id)" class="button cart expanded secondary" >
                                        $<?php echo e($result->price); ?>- Add to Cart
                                    </a>
                                    <?php else: ?>
                                    <a  class="button cart expanded secondary" >
                                        Out of Stock
                                    </a>
                                    <?php endif; ?>

                            </div>

                        </div>

                    </a>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if(!count($results)): ?>
                    <h3>The product your are searching for isn't available</h3>
                <?php endif; ?>
            </div>


            
            <div class="text-center">
                <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" >
                
            </div>


        </section>


    </div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.search-base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>