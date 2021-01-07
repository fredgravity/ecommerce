@extends('user.layout.user_base')
@section('title', 'User Payment')
@section('data-page-id', 'userPayment')

@section('content')

    <div class="admin_shared payment dashboard grid-container full" id="userPayment">

        <div class="grid-padding-x grid-x medium-padding-collapse" data-equalizer data-equalizer-on="medium">

            <div class="small-12 medium-6 cell summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="grid-x grid-padding-x">
                            <div class="small-3 cell">
                                <i class="fa fa-money-bill icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Cedis</p><h4 id="userPayment-cedis" >{{ number_format($revenue, 2) }}</h4>
                            </div>
                        </div>

                    </div>

                    <div class="card-divider">
                        <a href="#">Total Cedis Revenue</a>
                    </div>
                </div>
            </div>



            <div class="small-12 medium-6 cell end summary" data-equalizer-watch>
                <div class="card">
                    <div class="card-section">
                        <div class="grid-padding-x grid-x">
                            <div class="small-3 cell">
                                <i class="fa fa-hand-holding-usd icons" aria-hidden="true"></i>
                            </div>
                            <div class="small-9 cell">
                                <p>Other Currencies</p><h4>@{{ convertAmt }}</h4>
                            </div>
                        </div>

                    </div>

                    <div class="card-divider">
                        <a @click="convertThis('USD')">USD |</a>
                        <a @click="convertThis('GBP')" >GBP |</a>
                        <a @click="convertThis('EUR')" >EUR |</a>
                        <a @click="convertThis('ZAR')">ZAR</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="grid-x grid-padding-x">


        <div class="small-12 medium-12 cell graph">
            <div class="card">

                <div class="card-section monthly-revenue">
                    <h4>Revenues</h4>
                    <canvas id="totalUserPayments"></canvas>
                </div>

            </div>

        </div>



    </div>





    @endsection

