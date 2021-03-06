@extends('admin.layout.base')
@section('title', 'Dashboard')
@section('data-page-id', 'adminDashboard')

@section('content')

    <div class="dashboard admin_shared" data-equalizer data-equalizer-on="medium">
        <div class="grid-x grid-padding-x medium-padding-collapse" >

            {{--ORDER SUMMARY--}}
            <div class="small-12 medium-3 cell summary" data-equalizer-watch>

                <div class="card">
                    <div class="card-section">
                        <div class="grid-padding-x grid-x">
                            <div class="small-3 cell">
                                <i class="fa fa-shopping-cart icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Orders</p> <h4>{{ $orders }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-divider">
                        <div class="grid-x cell">
                            <a href="/admin/orders">Order Details</a>
                        </div>
                    </div>
                </div>

            </div>

            {{--STOCK SUMMARY--}}
            <div class="small-12 medium-3 cell summary" data-equalizer-watch >

                <div class="card">
                    <div class="card-section">
                        <div class="grid-x grid-padding-x">
                            <div class="small-3 cell">
                                <i class="fa fa-thermometer-empty icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Stock</p> <h4>{{ $products }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-divider">
                        <div class="grid-x grid-padding-x cell">
                            <a href="/admin/products">View Products</a>
                        </div>
                    </div>
                </div>

            </div>

            {{--REVENUE SUMMARY--}}
            <div class="small-12 medium-3 cell summary" data-equalizer-watch >

                <div class="card">
                    <div class="card-section">
                        <div class="grid-x grid-padding-x">
                            <div class="small-3 cell">
                                <i class="fa fa-money-bill icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Revenue</p> <h4>${{ number_format($payments, 2) }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-divider">
                        <div class="grid-x grid-padding-x cell">
                            <a href="/admin/users/payments">Payment Details</a>
                        </div>
                    </div>
                </div>

            </div>

            {{--SIGNUP SUMMARY--}}
            <div class="small-12 medium-3 cell summary" data-equalizer-watch>

                <div class="card">
                    <div class="card-section">
                        <div class="grid-x grid-padding-x">
                            <div class="small-3 cell">
                                <i class="fa fa-user icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Signup</p> <h4>{{ $users }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-divider">
                        <div class="grid-x grid-padding-x cell">
                            <a href="/admin/users-dashboard">Registered Users</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="grid-padding-x grid-x medium-padding-collapse  graph">
            <div class="small-12 medium-6 cell monthly-sales">
                <div class="card">

                    <div class="card-section">
                        <h4>Monthly Orders</h4>
                        <canvas id="monthly-order"></canvas>
                    </div>

                </div>
            </div>

            <div class="small-12 medium-6 cell monthly-revenue">
                <div class="card">

                    <div class="card-section">
                        <h4>Monthly Revenue</h4>
                        <canvas id="monthly-revenue"></canvas>
                    </div>

                </div>
            </div>

        </div>
    </div>




    @endsection

