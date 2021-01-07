@extends('admin.layout.base')
@section('title', 'Edit Orders')
@section('data-page-id', 'editOrders')

@section('content')

    <div class="edit-orderDetails admin_shared grid-container full" id="edit-orderDetails">

        @foreach($orderDetails as $orderDetail)

            <div class="grid-x grid-padding-x">
                <div class="cell medium-12">
                    <h2 class="text-center">Edit Order - {{ $orderDetail->order_id }}</h2><hr>
                </div>
            </div>

            @include('includes.message')

            <div class="grid-x grid-padding-x medium-padding-collapse">
                {{--<div class="cell  align-center">--}}
                    <div class="small-12 medium-6 cell" >
                        <div class="text-center">
                            <img src="/{{ $orderDetail->product->image_path }}" class="edit-order-image" alt="order-image">
                            <h4> {{ $orderDetail->product->name }}</h4>
                        </div>
                        <div class="grid-x order-details-info">
                            <div class="small-12  medium-6 cell text-left">

                                <p><strong>Unit Price:</strong>$ {{ $orderDetail->product->price }}</p>
                                <p><strong>Order Quantity:</strong> {{ $orderDetail->quantity }}</p>
                                <p><strong>Order Status:</strong> {{ $orderDetail->status }}</p>
                            </div>
                            <div class="small-12  medium-6 cell  end text-left">
                                <p><strong>User Name:</strong> {{ $orderDetail->user->fullname }}</p>
                                <p><strong>User Phone:</strong> {{ $orderDetail->user->phone }}</p>
                                <p><strong>User Location:</strong> {{ $orderDetail->user->country_name }}</p>
                            </div>
                        </div>
                        <div class="cell text-center">
                            <div class="cell order-details-desc">
                                <h6><strong>Product Description:</strong> </h6>
                                <p>{{ $orderDetail->product->description }}</p>
                            </div>
                        </div>


                    </div>

                    <div class="small-12 medium-5 cell  order-update-form" >
                        <div class="input-group cell order-update-form">
                            <form action="/admin/orders/{{ $orderDetail->id }}/update" method="post">

                                <div class="cell small-12">

                                    <label for="quantity">Change Order Quantity:</label>
                                        <select name="quantity" id="quantity">
                                            @for($i=1; $i <= 50; $i++ )
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>

                                </div>
                                <div class="cell small-12 ">
                                    <label for="status">Change Order Status:</label>
                                    <select name="status" id="status">
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                    </select>
                                </div>

                                <div class="cell text-center">
                                    <div class="small-12">
                                        <h1><strong>${{ number_format($orderDetail->total, 2)  }}</strong></h1>
                                    </div>

                                    <div class="small-12 align-center">
                                        <input type="submit" class="button primary expanded" value="Update">
                                    </div>

                                    <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                    <input type="hidden" name="unit_price" value="{{ $orderDetail->unit_price }}">

                                </div>

                            </form>
                        </div>


                    </div>
                </div>

            </div>

        @endforeach






    </div>

    @include('includes.delete-model')



@endsection

