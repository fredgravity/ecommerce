@extends('layouts.app')
@section('title', 'Register for Free')
@section('data-page-id', 'auth')


@section('content')

    <div class="auth" id="auth">

        {{--DISPLAY SPINNER CUBE IF VUE JS LOADING IS TRUE--}}
        {{--<div class="text-center">--}}
            {{--<img src="/images/spinners/cube.gif" alt="loader" v-show="loading === true" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >--}}

        {{--</div>--}}

        {{--INCLUDE THE MESSAGE FOR ERROR DISPLAY--}}
        @include('includes.message')
        <section class="register_form grid-container full">

            <div class="grid-x grid-padding-x" style="padding-top: 30px;">

                <div class="medium-2 cell">

                </div>


                <div class="small-12 medium-7 cell medium-centered">
                    <h2 class="text-center">Create An Account</h2>



                    {{--REGISTER FORM--}}
                    <form action="" method="post">
                        <input type="text" name="fullname" placeholder="full name" value="{{ \App\classes\Request::oldData('post', 'fullname') }}">

                        <input type="text" name="email" placeholder="email address" value="{{ \App\classes\Request::oldData('post', 'email') }}">

                        <input type="text" name="username" placeholder="username" value="{{ \App\classes\Request::oldData('post', 'username') }}">

                        {{--<input type="text" name="phone" placeholder="phone number" value="{{ \App\classes\Request::oldData('post', 'phone') }}">--}}

                        <input type="password" name="password" placeholder="password">

                        <select name="country_name">
                            <option value="">Select your Country</option>
                            <option value="Ghana">Ghana</option>
                        </select>

                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">

                        <button class="button float-right success">Register</button>
                    </form>

                    <p>Already have an Account? <a href="/login"> Sign In </a></p>
                    <p>Want to Sell your African Brands? <a href="/vendor-register"> Sign up </a> now for a Vendor's Account</p>
                    {{--END REGISTER FORM--}}
                </div>

            </div>

        </section>



    </div>




@endsection
