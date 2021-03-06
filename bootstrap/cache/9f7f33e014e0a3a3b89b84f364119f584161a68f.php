<?php $__env->startSection('title'); ?> <?php echo e($product->name); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('data-page-id', 'product'); ?>


<?php $__env->startSection('content'); ?>



    <div class="product grid-container full" id="product" data-token="<?php echo e($token); ?>" data-id="<?php echo e($product->id); ?>" style="padding: 6rem">

        
        <div class="text-center">
            <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >

        </div>

        <?php echo $__env->make('includes.contactSeller-model', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('includes.contactSeller-model-no', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>



        <section class="item-container grid-x grid-padding-x"  v-if="loading == false">
            <div class=" cell">

                <nav aria-label="You are here:" role="navigation">
                    <ul class="breadcrumbs">
                        <li><a :href="'/category_items/' + category.id">{{ category.name }}</a></li>
                        <li><a :href="'/all_sub_items/' + subCategory.id">{{ subCategory.name }}</a></li>
                        <li>{{ product.name }}</li>
                    </ul>
                </nav>

                <div class="grid-x grid-padding-x medium-padding-collapse">

                    <div class="small-12 medium-4 cell">

                             <img :src="'/' + product.image_path" :alt="product.name" class="text-center product-view-image">

                    </div>

                    <div class="small-12 medium-4 cell">
                        <div class="product-details">
                            <h3>{{ product.name }}</h3>
                            <p id="product-details-p">{{ product.description }}</p>
                            <h2>${{ product.price }}</h2>
                            

                                <?php if(isAuthenticated()): ?>
                                    <button class="button contact-seller-button" @click="contactModal">Contact Seller</button>
                                    <?php else: ?>
                                    <button class="button contact-seller-button" @click="contactModalNo">Contact Seller</button>
                                <?php endif; ?>
                                <button  v-if="product.quantity" @click.prevent="addToCart(product.id)" class="button secondary" disabled>Add to cart</button>
                                <button v-else  class="button secondary" disabled>Out of Stock</button>
                            </div>

                        
                    </div>



                    <div class="small-12 medium-4 cell">

                        <div class="grid-x">
                            <div class="medium-6 cell">
                                <img :src="'/' + product.user.image_path" :alt="product.user.username" class="text-center user-view-image">
                            </div>

                            <div class="cell medium-5">
                               <h1>{{ rating }} <sup><i class="fa fa-star" style="font-size: 1.5rem; color: #dadb3b;"></i> </sup></h1>
                            </div>
                        </div>

                        <div class="small-12 medium-7 cell ">
                            <table class="info-table" cellspacing="0">

                                <tr>
                                    <td>Brand :</td>
                                    <td>{{ product.user.username }}</td>
                                </tr>
                                <tr>
                                    <td>Country :</td>
                                    <td>{{ product.user.country_name }}</td>
                                </tr>
                                <tr>
                                    <td>City :</td>
                                    <td>{{ product.user.city }}</td>
                                </tr>


                            </table>
                            
                             
                            
                            <div>
                                <button class="hollow button small " @click.prevent="reveal" id="number-reveal-btn">Show Number</button>
                                <div><h5 style="font-size: 15px; font-weight: bold; display: none;" id="number-reveal">+233 {{ product.user.phone }}</h5></div>
                            </div>

                        </div>


                    </div>




                </div>


            </div>

        </section>

        <section class="map-location grid-container full" data-id="<?php echo e($product->id); ?>">

            <div class="grid-x grid-padding-x" id="map">


                <div id="map-frame" style="width: 100%; height: 400px;">

                </div>
            </div>
        </section>



        <?php if(isAuthenticated()): ?>
            <section class="grid-container full home">

                <h4>See what buyers are saying about this product</h4>


                <div class="display-comments" v-if="comments">
                    <template v-for="comment in comments">
                        <div class="grid-x grid-padding-x mema">
                            <table class="display-comments-table unstriped" >
                                <tr>
                                    <td width="200">
                                        <table class="display-comments-table">
                                            <td>
                                                <img :src="'/'+comment.user.image_path" alt="" style="height: 50px; width: 50px; border-radius: 10px;" />
                                            </td>
                                            <td>
                                                <table class="display-comments-table">
                                                    <tr>
                                                        <td>By: {{ comment.user.username }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ comment.created_at }}</td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </table>

                                    </td>

                                    <td>{{ comment.comment }}</td>
                                </tr>
                            </table>
                            
                                
                            
                            
                        </div>
                    </template>

                </div>

                
                <div class="grid-x grid-padding-x new-comments">
                    <label for="comment">Your Comments</label>
                    <textarea name="comment" id="comment" data-token="<?php echo e(\App\Classes\CSRFToken::generate()); ?>"></textarea>
                    <div class="clearfix cell">
                        <button class="button success float-right new-comments-btn" @click="postcomment(product.user.id)">Post Comment</button>
                    </div>

                </div>


            </section>
            <?php else: ?>
            <div class="text-center home">
                <h4>Please login to comment on this product <i class="fa fa-comments"></i> </h4>
            </div>


            <?php endif; ?>




        <section class="home grid-container full" v-if="loading == false">
            <div class="display-products">
                <h3>Similar Products</h3>
                <div class="grid-x grid-padding-x medium-up-2 large-up-4">


                    <div class="small-12 cell" v-cloak v-for="similar in similarProducts">

                        <a :href="'/product/' + similar.id" class="featured-product-link-name">

                            <div class="card" data-equalizer-watch>

                                <div class="card-section">
                                    <img :src="'/' + similar.image_path" width="100%" height="200">
                                </div>

                                <div class="card-section align-center" >
                                    <p> {{ stringLimit(similar.name, 15) }} </p>

                                    <a :href="'/product/' + similar.id" class="button more expanded" > See More </a>

                                    <button v-if="similar.quantity" @click.prevent="addToCart(similar.id)" class="button cart expanded secondary" disabled>
                                        ${{ similar.price }} - Add to Cart
                                    </button>
                                    <button v-else  class="button cart expanded secondary" disabled>
                                        Out of Stock
                                    </button>

                                </div>

                            </div>

                        </a>

                    </div>
                </div>
            </div>
        </section>

    </div>



    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDFmK9Qc-RqsPgD4A3R8WU-0AtvyvlViSs&callback=loadMap"
            async defer></script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>