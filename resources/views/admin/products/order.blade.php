@extends('admin.layout.base')
@section('title', 'Orders')
@section('data-page-id', 'productOrders')

@section('content')


    <div class="orders admin_shared grid-container full" id="orders">
        {{--{{ dnd($products) }}--}}
        <div class="grid-x grid-padding-x">
            <div class="cell">
                <h2 class="text-center">Manage Orders</h2><hr>
            </div>
        </div>


        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-6 cell">
                <form action="" method="post">
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


            {{--INCLUDE MESSAGE--}}
            @include('includes.message')

            {{--<div class="grid-padding-x grid-x" >--}}
                <div class="small-12 medium-12 cell" v-if="showSearch">

                    <table class="hover unstriped search-table" data-form="deleteOrder" >
                        <thead>
                        <tr>
                            <td>Order No</td>
                            <td>Customer Name</td>
                            <td>Customer Email</td>
                            <td>Customer Phone#</td>
                            <td>Customer Location</td>

                            <td width="100">Action</td>
                        </tr>
                        </thead>


                        <tbody>


                        <tr v-for="order in orderSearch" v-cloak>
                            {{--<td><img src="/{{ $product['image_path'] }}" alt="{{ $product['name'] }}" width="40" height="40"></td>--}}
                            <td>@{{ order.order_id }}</td>
                            <td>@{{ order.user.fullname }}</td>
                            <td>@{{ order.user.email }}</td>
                            <td>@{{ order.user.phone }}</td>
                            <td>@{{ order.user.country_name }}</td>

                            <td  class="text-center">
                                        <span data-tooltip class="has-tip top" tabindex="1" title="View more" >
                                            <i class="fa fa-angle-double-down" data-token="{{ \App\Classes\CSRFToken::generate() }}" id="more-search" title="View more" @click="searchMoreOrders(order.id)" style="cursor:pointer;"></i>
                                        </span>
                                &nbsp;
                                <span data-tooltip class="has-tip top" tabindex="1" title="hide more" >
                                            <i class="fa fa-angle-double-up" title="hide more" @click="searchLessOrders" style="cursor:pointer;"></i>
                                        </span>
                                &nbsp;
                                <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                    <form :action="'/admin/orders/'+ order.id + '/deleteorder'" method="post" class="delete-order">
                                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                        <button type="submit"><i class="fa fa-times delete"></i></button>
                                    </form>
                                </span>

                            </td>


                        </tr>
                        @include('includes.delete-model')

                        </tbody>

                    </table>

                    <div v-if="orderSearch.length == 0">
                        <h2>The order you are looking for is not available</h2>
                    </div>

                    <div class="grid-x grid-padding-x more-search-details" style="display: none;">
                        <div class="cell">
                            <h2 class="text-center">Manage Orders Details</h2><hr>
                        </div>
                    </div>


                    <div class="cell  more-search-details" data-token="{{ \App\Classes\CSRFToken::generate() }}"  style="display: none;" >
                        <table data-form="deleteOrder">
                            <tr>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date Ordered</th>
                                <th width="70">Action</th>
                            </tr>


                            <tbody v-cloak v-for="(order) in orderDetails">
                            <tr>
                                <td>@{{ order.quantity }}</td>
                                <td>@{{ order.unit_price }}</td>
                                <td>@{{ order.total }}</td>
                                <td>@{{ order.status }}</td>
                                <td>@{{ order.created_at }}</td>

                                <td class="text-center">

                                     <span data-tooltip class="has-tip top" tabindex="1" title="Edit Order">
                                            <a :href="'/admin/orders/'+ order.id + '/edit'" ><i class="fa fa-edit"></i></a>
                                     </span>
                                    &nbsp;
                                    <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                        <form :action="'/admin/orders/'+ order.id + '/deleteorderdetails'" method="post" class="delete-order">
                                            <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                            <button type="submit"><i class="fa fa-times delete"></i></button>
                                        </form>
                                    </span>
                                </td>
                            </tr>



                            </tbody>
                        </table>



                    </div>


                </div>

                {{---------------------------------------------------------------------------------------------------------------------------------------------------------}}

                <div class="cell small-12 medium-12" v-else>


                        @if(count($orders))

                            {{-- POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                            <table class="hover unstriped small-12" data-form="deleteOrder">
                                <thead>
                                <tr>
                                    <td>Order No</td>
                                    <td>Customer Name</td>
                                    <td>Customer Email</td>
                                    <td>Customer Phone#</td>
                                    <td>Customer Location</td>
                                    <td width="100">Action</td>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($orders as $order)

                                    @foreach($users as $user)

                                        @if($order['user_id'] == $user->id)
                                            <tr>
                                                {{--<td><img src="/{{ $product['image_path'] }}" alt="{{ $product['name'] }}" width="40" height="40"></td>--}}
                                                <td>{{ $order['order_id'] }}</td>
                                                <td>{{ $user->fullname }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->country_name }}</td>


                                                <td width="50" class="text-center">
                                                    <span data-tooltip class="has-tip top" tabindex="1" title="View more" >
                                                        <i class="fa fa-angle-double-down" title="View more" @click="moreOrders({{ $order['id'] }})" style="cursor:pointer;"></i>
                                                    </span>
                                                    &nbsp;
                                                    <span data-tooltip class="has-tip top" tabindex="1" title="hide more" >
                                                        <i class="fa fa-angle-double-up" title="hide more" @click="lessOrders({{ $order['id'] }})" style="cursor:pointer;"></i>
                                                    </span>
                                                    &nbsp;
                                                    <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                                        <form action="/admin/orders/{{ $order['id'] }}/deleteorder" method="post" class="delete-order">
                                                            <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                                            <button type="submit"><i class="fa fa-times delete" title="Delete Order"></i></button>
                                                        </form>
                                                    </span>

                                                </td>


                                            </tr>



                                        @endif

                                    @endforeach



                                @endforeach


                                </tbody>
                            </table>




                            @if($orderLinks)
                                {{-- DISPLAY ORDER LINKS --}}
                                {!! $orderLinks !!}

                            @endif


                            <div class="cell moreOrder" style="display: none;">
                                <div class="cell">
                                    <h2 class="text-center" >Manage Orders Details</h2>
                                </div>
                            </div>

                            <div id="more" data-token="{{ \App\Classes\CSRFToken::generate() }}" v-if="orderDetails" style="display: none;"  class="moreOrder cell">
                                <table data-form="deleteOrder">
                                    <tr>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date Ordered</th>
                                        <th width="70">Action</th>
                                    </tr>



                                    <tbody v-cloak v-for="(detail) in orderDetails">
                                    <tr>
                                        <td>@{{ detail.quantity }}</td>
                                        <td>@{{ detail.unit_price }}</td>
                                        <td>@{{ detail.total }}</td>
                                        <td>@{{ detail.status }}</td>
                                        <td>@{{ detail.created_at }}</td>
                                        <td class="text-center">
                                        <span data-tooltip class="has-tip top" tabindex="1" title="Edit Detail">
                                            <a :href="'/admin/orders/'+ detail.id + '/edit'" ><i class="fa fa-edit" title="Edit Detail"></i></a>
                                        </span>
                                            &nbsp;

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Delete Order">
                                            <form :action="'/admin/orders/'+detail.id+'/deleteorderdetails'" method="post" class="delete-order">
                                                <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                                <button type="submit"><i class="fa fa-times delete" title="Delete Detail"></i></button>
                                            </form>
                                        </span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>



                            {{--INCLUDE VUE MODAL--}}



                        @else
                            <div class="cell">
                                <h2>The order you are looking for is not available</h2>
                            </div>

                        @endif

                    </div>
                </div>

            {{--</div>--}}
        </div>



    </div>


@endsection

