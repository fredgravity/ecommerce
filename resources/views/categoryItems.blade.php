@extends('layouts.search-base')
@section('title') {{ $categoryItemName }} @endsection
@section('data-page-id', 'categoryItem')


@section('content')

<div class="search-container grid-container full" >


    <section class="display-product-search" id="root" data-token="{{ $token }}"  >

        {{--SUB PRODUCTS--}}
        <div class="grid-x grid-padding-x medium-up-3 large-up-4" id="display-cat-items">

            {{--<h3 class="text-center">{{ $categoryItemName }}</h3>--}}

            <div v-if="categoryItems == false"><h3>No Category and Sub Category items</h3></div>

            <div v-else class="small-12 cell" v-cloak v-for="categoryItem in categoryItems">

                <a :href="'/product/' + categoryItem.id" class="featured-product-link-name">

                    <div class="card" data-equalizer-watch>

                        <div class="card-section">
                            <img :src="'/' + categoryItem.image_path" width="100%" height="200">
                        </div>

                        <div class="card-section">
                            <p> @{{ stringLimit(categoryItem.name, 15) }} </p>

                            <a :href="'/product/' + categoryItem.id" class="button more expanded" > See More </a>

                            <a v-if="categoryItem.quantity" @click.prevent="addToCart(categoryItem.id)" class="button cart expanded secondary" >
                                $@{{ categoryItem.price }} - Add to Cart
                            </a>
                            <a v-else  class="button cart expanded secondary" >
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