@extends('layouts.app')
@section('title', 'Home Page')
@section('data-page-id', 'home')


@section('content')

<div class="home">

        <section class="hero">
            <div class="hero-slider">

                <div><img src="/images/sliders/slider_1.jpg" alt="slider one"></div>

                <div><img src="/images/sliders/slider_2.jpg" alt="slider two"></div>

                <div><img src="/images/sliders/slider_3.jpg" alt="slider three"></div>

            </div>
        </section>

    <section class="display-products" id="root" data-token="{{ $token }}">

        {{--FEATURED PRODUCTS--}}
        <h3>Featured Products</h3>
       <div class="grid-x grid-padding-x medium-up-3 large-up-4 ">

               <div class="small-12 cell"  v-cloak v-for="feature in featured">


                   <a :href="'/product/' + feature.id" class="featured-product-link-name">

                       <div class="card" data-equalizer-watch>

                                <div class="card-section">
                                    <img :src="'/' + feature.image_path" width="100%" height="200">
                                </div>

                                <div class="card-section">
                                    <p> @{{ stringLimit(feature.name, 15) }} </p>

                                    <a :href="'/product/' + feature.id" class="button more expanded" > See More </a>

                                    <button v-if="feature.quantity" @click.prevent="addToCart(feature.id)" class="button cart expanded secondary" disabled>
                                        $@{{ feature.price }} - Add to Cart
                                    </button>
                                    <button v-else class="button cart expanded secondary" disabled>
                                       Out of Stock
                                    </button>

                                </div>

                       </div>

                   </a>
                </div>
       </div>




        {{--NON FEATURED PRODUCTS--}}
        <h3>Products</h3>
        <div class="grid-x grid-padding-x medium-up-3 large-up-4">


            <div class="small-12 cell" v-cloak v-for="product in products">

                <a :href="'/product/' + product.id" class="featured-product-link-name">

                    <div class="card" data-equalizer-watch>

                        <div class="card-section">
                            <img :src="'/' + product.image_path" width="100%" height="200">
                        </div>

                        <div class="card-section">
                            <p> @{{ stringLimit(product.name, 15) }} </p>

                            <a :href="'/product/' + product.id" class="button more expanded" > See More </a>

                            <button v-if="product.quantity" @click.prevent="addToCart(product.id)" class="button cart expanded secondary" disabled>
                                $@{{ product.price }} - Add to Cart
                            </button>
                            <a v-else  class="button cart expanded secondary" disabled>
                                Out of Stock
                            </a>
                        </div>

                    </div>

                </a>

            </div>
        </div>

        {{--SHOW THE SPINNING ICON--}}
        <div class="text-center">
            <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" >
            {{--<i v-show="loading" class="fa fa-spinner fa-spin" style="font-size: 3rem; position:fixed; top: 60%; bottom: 20%; color: #1585f1;" ></i>--}}
        </div>

    </section>


</div>



@endsection