@extends('layouts.search-base')
@section('title', 'Search Product')
@section('data-page-id', 'searchProduct')


@section('content')

    <div class="search-container grid-container full" >
{{--{{ pnd($searchWord) }}--}}

        <section class="display-product-search" id="root-search" data-token="{{ $token }}" data-word="{{ $searchWord }}" >

            {{--SUB PRODUCTS--}}
            <div class="grid-x grid-padding-x medium-up-3 large-up-4" id="display-search-items" v-if="products">
                {{--<h3 class="text-center">{{ $categoryItemName }}</h3>--}}


                    <div v-if="show" class="small-12 cell" v-cloak v-for="categoryItem in products">

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
                    <div v-else><p>No Category and Sub Category items</p></div>




            </div>



            {{------------------------------------------------------------------------------------------------------------------------------}}

            <div v-else class="grid-padding-x grid-x medium-up-3 large-up-4" id="display-products">
{{--                {{ pnd($results) }}--}}
                @foreach($results as $result)
                <div class="small-12 cell">

                    <a href="/product/{{ $result->id }}" class="featured-product-link-name">

                        <div class="card">

                            <div class="card-section">
                                <img src="/{{ $result->image_path }}" width="100%" height="200">
                            </div>

                            <div class="card-section">
                                <p>{{ $result->name }}</p>
                                <a href="/product/{{ $result->id }}" class="button more expanded" > See More </a>

                                @if($result->quantity)
                                    <a  @click.prevent="addToCart(categoryItem.id)" class="button cart expanded secondary" >
                                        ${{ $result->price }}- Add to Cart
                                    </a>
                                    @else
                                    <a  class="button cart expanded secondary" >
                                        Out of Stock
                                    </a>
                                    @endif

                            </div>

                        </div>

                    </a>

                </div>
                @endforeach

                @if(!count($results))
                    <h3>The product your are searching for isn't available</h3>
                @endif
            </div>


            {{--SHOW THE SPINNING ICON--}}
            <div class="text-center">
                <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" >
                {{--<i v-show="loading" class="fa fa-spinner fa-spin" style="font-size: 3rem; position:fixed; top: 60%; bottom: 20%; color: #1585f1;" ></i>--}}
            </div>


        </section>


    </div>



@endsection