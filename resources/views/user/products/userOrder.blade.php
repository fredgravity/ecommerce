@extends('user.layout.user_base')
@section('title', 'Orders')
@section('data-page-id', 'userOrders')

@section('content')


    <div class="orders admin_shared grid-container full" id="orders" data-token="{{ \App\Classes\CSRFToken::generate() }}">

        <div class="grid-padding-x grid-x">
            <div class="cell">
                <h2 class="text-center">Manage Order Details</h2><hr>
            </div>
        </div>

        @include('includes.message')

        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-6 cell">
                <form action="" method="post" class="small-12 medium-5 cell">
                    <div class=" input-group">
                        <input type="text" class="input-group-field" placeholder="Search Order" id="searchOrder" name="search_field" value="{{ \App\classes\Request::oldData('post','search_field') }}" data-token="{{ \App\Classes\CSRFToken::generate() }}">
                        <div class="input-group-button">
                            <input type="button" value="Search" class="button search-order" @click.prevent="searchOrders">
                        </div>
                    </div>
                </form>

            </div>

            {{--DISPLAY SPINNER CUBE IF VUE JS LOADING IS TRUE--}}
            <div class="text-center">
                <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >
            </div>


            {{--INCLUDE MESSAGE--}}@include('includes.delete-model')


            <div class="cell " v-if="showSearch" v-cloak>
                <div class="cell" v-if="orderSearch" v-cloak>


                        {{--POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                        <table class="hover unstriped small-12" data-table="delete-user-Order">
                            <thead>
                            <tr>
                                <td>Product Image</td>
                                <td>Order No</td>
                                <td>Product Name</td>
                                <td>Order Qty</td>
                                <td>Order Amount</td>
                                <td>Order Status</td>
                                <td>Rate</td>
                                {{--<td>Rating</td>--}}
                                <td>Order Date</td>
                                <td width="30">Action</td>
                            </tr>
                            </thead>

                            <tbody v-for="order in orderSearch" v-cloak>

                            {{--<template v-for="order in orderSearch">--}}

                                <tr v-if="order.user_id === userId" v-cloak>

                                    <td><img :src="'/'+order.product.image_path" :alt="order.product.name" width="40" height="40"></td>
                                    <td>@{{ order.order_id }}</td>
                                    <td>@{{ order.product.name }}</td>
                                    <td>@{{ order.quantity}}</td>
                                    <td>GHS @{{ order.total }}</td>
                                    <td>@{{ order.status }}</td>
                                    <td>
                                        <select name="rating" id="rating-value" @change="sendRate(order.product.id, $event)">
                                            @for( $x = 1; $x<6; $x++ )
                                                <option value="{{ $x }}">{{ $x }}</option>
                                            @endfor
                                        </select>
                                    </td>

                                    {{--<td class="text-center"> <h3>5</h3></td>--}}

                                    <td>@{{ order.created_at }}</td>



                                    <td width="30" class="text-center">

                                        <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                            <form :action="'/user/orders/' + order.id + '/deleteorder'" method="post" class="deleteUser-order" >
                                                <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                                <button type="submit"><i class="fa fa-times delete" title="Delete Order" @click.prevent="deleteUserOrder" ></i></button>
                                            </form>

                                            {{--<span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">--}}
                                                {{--<form action="/user/orders/{{$item->id }}/deleteorder" method="post" class="delete-order">--}}
                                                    {{--<input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">--}}
                                                    {{--<button type="submit"><i class="fa fa-times delete" title="Delete Order"></i></button>--}}
                                                {{--</form>--}}
                                            {{--</span>--}}

                                        </span>

                                    </td>


                                </tr>
                            {{--</template>--}}


                            </tbody>
                        </table>


                </div>


                <div class="cell" v-if="orderSearch < 1">
                    <h2>The order you are looking for is not available</h2>
                </div>

            </div>


            {{---------------------------------------------------------------------------------------------------------------------------------------------------------}}


            <div class="cell " v-else>


                @if(count($orderDetails))

                     {{--POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                    <table class="hover unstriped small-12" data-form="deleteOrder">
                        <thead>
                        <tr>
                            <td>Product Image</td>
                            <td>Order No</td>
                            <td>Product Name</td>
                            <td>Order Qty</td>
                            <td>Order Amount</td>
                            <td>Order Status</td>
                            <td>Rate</td>
                            {{--<td>Rating</td>--}}
                            <td>Order Date</td>
                            <td width="30">Action</td>
                        </tr>
                        </thead>

                        <tbody>


                             @foreach( $orderDetailsWithProduct as $key => $item)
                                 {{--{{ pnd($item->product->rating[$key]->rating) }}--}}
                                        @if($item->user_id == user()->id)
                                        <tr>
                                            <td><img src="/{{ $item->product->image_path }}" alt="{{ $item->product->name }}" width="40" height="40"></td>
                                            <td>{{ $item->order_id }}</td>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>GHS {{ $item->total }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                <select name="rating" class="rating-value" @change="sendRate({{ $item->product->id }},$event)">
                                                    @for( $x = 1; $x<6; $x++ )
                                                        <option value="{{ $x }}">{{ $x }}</option>

                                                    @endfor
                                                </select>
                                            </td>


                                            <td>{{ $item->created_at->toFormattedDateString() }}</td>
                                            {{--<td>{{ $orderDetail['id'] }}</td>--}}


                                            <td width="30" class="text-center">
                                                <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                                    <form action="/user/orders/{{$item->id }}/deleteorder" method="post" class="delete-order">
                                                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                                        <button type="submit"><i class="fa fa-times delete" title="Delete Order"></i></button>
                                                    </form>
                                                </span>
                                            </td>


                                        </tr>



                                    @endif
                                @endforeach






                        {{--@endforeach--}}


                        </tbody>
                    </table>




                    @if($orderDetailsLinks)
                         {{--DISPLAY ORDER LINKS--}}
                        {!! $orderDetailsLinks !!}

                    @endif


                    {{--INCLUDE VUE MODAL--}}



                @else
                    <div class="cell">
                        <h2>The order you are looking for is not available</h2>
                    </div>

                @endif




            </div>
        </div>



    </div>


@endsection

