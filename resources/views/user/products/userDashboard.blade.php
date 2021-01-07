@extends('user.layout.user_base')
@section('title', 'Users Dashboard')
@section('data-page-id', 'usersDashboard')

@section('content')

    <div class="admin_shared users dashboard">

        <div class="row expanded collapse" data-equalizer data-equalizer-on="medium">

            <div class="small-12 medium-4 column summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="row">
                            <div class="small-3 column">
                                <i class="fa fa-user icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 column">
                                <p>Users</p><h4>{{ $totalUsers }}</h4>
                            </div>
                        </div>

                    </div>

                    <div class="card-divider">
                        <a href="/admin/users-details">Users Details</a>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-4 column summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="row">
                            <div class="small-3 column">
                                <i class="fa fa-toolbox icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 column">
                                <p>Vendors</p><h4>{{ $totalVendors }}</h4>
                            </div>
                        </div>

                    </div>

                    <div class="card-divider">
                        <a href="/admin/vendors-details">Vendors Details</a>
                    </div>
                </div>
            </div>

            <div class="small-12 medium-4 column summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="row">
                            <div class="small-3 column">
                                <i class="fa fa-users icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 column">
                                <p>Subscribers</p><h4>{{ $allUsers }}</h4>
                            </div>
                        </div>

                    </div>

                    <div class="card-divider">
                        <a href="#">Subscribers</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="row expanded">
        <div class="row">
            <div class="small-12 medium-6 column graph">
                <div class="card">

                    <div class="card-section monthly-revenue">
                        <h4>Users</h4>
                        <canvas id="total-users"></canvas>
                    </div>

                </div>
            </div>

            <div class="small-12 medium-6 column graph">
                <div class="card">

                    <div class="card-section monthly-revenue">
                        <h4>Vendors</h4>
                        <canvas id="total-vendors"></canvas>
                    </div>

                </div>
            </div>

        </div>

        <div class="row">
            <div class="small-12 medium-12 column graph">
                <div class="card">

                    <div class="card-section monthly-revenue">
                        <h4>Subscribers</h4>
                        <canvas id="total-subscribers"></canvas>
                    </div>

                </div>

            </div>
        </div>


    </div>





    @endsection

