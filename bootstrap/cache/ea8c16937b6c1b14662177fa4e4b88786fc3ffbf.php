<?php $__env->startSection('title', 'Your Shopping Cart'); ?>
<?php $__env->startSection('data-page-id', 'cart'); ?>
<?php $__env->startSection('paypal-checkout'); ?>

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <?php $__env->stopSection(); ?>




<?php $__env->startSection('content'); ?>

    <div class="shopping_cart" id="shopping_cart" >

        
        <div class="text-center">
            <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >

        </div>
        <?php echo $__env->make('.includes.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        
        <section class="items" >

            <div class="row">

                <div class="small-12">

                    
                    <h2 v-if="failed" v-text="message"></h2>

                    
                    <div v-else v-cloak>
                        <h2 class="text-left column">Your Cart</h2>
                        <button @click="emptyCart" class="float-right warning button" style="cursor:pointer; margin-bottom: 3px; border-radius: 50px; border-style: none;">
                            Empty Cart &nbsp; <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                        </button>

                            <table class="hover unstriped small-centered">

                                <thead class="text-left">
                                    <tr>
                                        <th>#</th> <th>Product Name</th>
                                        <th>($) Unit Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>

                                <tbody>
                                    <tr v-for="item in items">
                                        
                                        <td class="medium-text-center">
                                            <a :href="'/product/' + item.id" >
                                                <img :src="'/' + item.image" :alt="item.name" height="60px" width="60px" >
                                            </a>
                                        </td>
                                        
                                        <td>
                                            <h5><a :href="'/product/' + item.id"> {{ item.name }} </a></h5>
                                            Status: <span v-if="item.stock > item.quantity" style="color:#1b7e25"> In Stock </span>
                                                    <span v-else style="color: #ff3800;"> Out of Stock </span>
                                                    <span v-if="item.newStock > 0">({{ item.newStock }})</span>

                                        </td>

                                        <td>{{ item.price }}</td>

                                        <td>
                                            {{ item.quantity }}
                                            <button v-if="item.stock > item.quantity" @click="updateQuantity(item.id, '+')" style="cursor:pointer; color: green;">
                                                <i class="fa fa-arrow-alt-circle-up" aria-hidden="true"></i>
                                            </button>
                                            <button v-if="item.quantity > 1" @click="updateQuantity(item.id, '-')" style="cursor:pointer; color: #ff3800;">
                                                <i class="fa fa-arrow-alt-circle-down" aria-hidden="true"></i>
                                            </button>
                                        </td>

                                        <td>{{ item.total }}</td>

                                        
                                        <td class="text-center">
                                            <button @click="removeItem(item.index)" style="cursor:pointer;">
                                                <i class="fa fa-trash-alt" aria-hidden="true"></i>
                                            </button>
                                        </td>

                                    </tr>
                                </tbody>

                            </table>

                        <table>

                            <tr>

                                <td valign="top">
                                    <div class="input-group">
                                        <input type="text" name="coupon" class="input-group-field" placeholder="Enter Coupon code">
                                        <div class="input-group-button">
                                            <button class="button">Apply Coupon</button>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <table>
                                        <tr>
                                            <td><h6>Subtotal:</h6></td>
                                            <td class="text-right"><h6>${{ cartTotal }}</h6></td>
                                        </tr>

                                        <tr>
                                            <td><h6>Discount:</h6></td>
                                            <td class="text-right"><h6>$0.00</h6></td>
                                        </tr>

                                        <tr>
                                            <td><h6>Tax:</h6></td>
                                            <td class="text-right"><h6>$0.00</h6></td>
                                        </tr>

                                        <tr>
                                            <td><h6>Total:</h6></td>
                                            <td class="text-right"><h6>${{ cartTotal }}</h6></td>
                                        </tr>
                                    </table>
                                </td>

                            </tr>

                        </table>
                        <div class="row cart-buttons" style="padding: 0 16px; min-width: 390px;">
                            <div class="float-left">
                                <a href="/" class="button secondary"> <i class="fa fa-arrow-left"></i> Continue Shopping <i class="fa fa-shopping-basket" aria-hidden="true"></i> </a>
                            </div>

                            <span class="float-right" v-if="authenticated"  >
                                
                                    
                                
                                &nbsp;
                                
                                <a  href="#" class="button success float-right"   data-open="myipay">
                                    Ipay &nbsp;<i class="fa fa-credit-card" aria-hidden="true"> </i>
                                </a>


                                
                                
                            </span>
                            <div v-else class="float-right">
                                <a href="/login" class="button success">
                                    Checkout &nbsp;<i class="fa fa-credit-card"> </i>
                                </a>
                            </div>

                            

                        </div>

                    </div>

                </div>

            </div>

        </section>


    </div>





<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>