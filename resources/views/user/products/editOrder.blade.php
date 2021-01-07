@extends('admin.layout.base')
@section('title', 'Edit Orders')
@section('data-page-id', 'editOrders')

@section('content')

    <div class="edit-orderDetails admin_shared">

        @foreach($orderDetails as $orderDetail)

            <div class="row expanded">
                <div class="column medium-11">
                    <h2 class="text-center">Edit Order - {{ $orderDetail->order_id }}</h2><hr>
                </div>
            </div>

            @include('includes.message')

            <div class="row column">
                <div class="column collapse align-center">
                    <div class="small-12 medium-6 column text-center" >
                        <div>
                            <img src="/{{ $orderDetail->product->image_path }}" class="edit-order-image" alt="order-image">
                            <h4> {{ $orderDetail->product->name }}</h4>
                        </div>
                        <div class="row order-details-info">
                            <div class="small-12  medium-6 column text-left">

                                <p><strong>Unit Price:</strong>$ {{ $orderDetail->product->price }}</p>
                                <p><strong>Order Quantity:</strong> {{ $orderDetail->quantity }}</p>
                                <p><strong>Order Status:</strong> {{ $orderDetail->status }}</p>
                            </div>
                            <div class="small-12  medium-6 column end text-left">
                                <p><strong>User Name:</strong> {{ $orderDetail->user->fullname }}</p>
                                <p><strong>User Phone:</strong> {{ $orderDetail->user->phone }}</p>
                                <p><strong>User Location:</strong> {{ $orderDetail->user->country_name }}</p>
                            </div>
                        </div>
                        <div class="row column">
                            <div class="order-details-desc">
                                <h6><strong>Product Description:</strong> </h6>
                                <p>{{ $orderDetail->product->description }}</p>
                            </div>
                        </div>


                    </div>

                    <div class="small-12 medium-5 column end order-update-form" >
                        <div class="input-group row order-update-form">
                            <form action="/admin/orders/{{ $orderDetail->id }}/update" method="post">

                                <div class="column small-12">

                                    <label for="quantity">Change Order Quantity:</label>
                                        <select name="quantity" id="quantity">
                                            @for($i=1; $i <= 50; $i++ )
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>

                                </div>
                                <div class="column small-12 ">
                                    <label for="status">Change Order Status:</label>
                                    <select name="status" id="status">
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                    </select>
                                </div>

                                <div class="column row text-center">
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

