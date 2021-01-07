@extends('layouts.app')
@section('title', 'Register for Vendor Account')
@section('data-page-id', 'auth')


@section('content')

    <div class="auth" id="auth">

        {{--DISPLAY SPINNER CUBE IF VUE JS LOADING IS TRUE--}}
        {{--<div class="text-center">--}}
            {{--<img src="/images/spinners/cube.gif" alt="loader" v-show="loading === true" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >--}}

        {{--</div>--}}

        <section class="register_form grid-container full">

            <div class="grid-x grid-padding-x" style="padding-top: 30px;">

                <div class="medium-2 cell">

                </div>

                <div class="small-12 medium-7 cell">
                    <h2 class="text-center">Create A Vendor Account</h2>

                    {{--INCLUDE THE MESSAGE FOR ERROR DISPLAY--}}
                    @include('includes.message')

                    {{--REGISTER FORM--}}
                    <form action="/register/vendor" method="post">

                        <input type="text" name="fullname" placeholder="full name" value="{{ \App\classes\Request::oldData('post', 'fullname') }}">

                        <input type="text" name="email" placeholder="email address" value="{{ \App\classes\Request::oldData('post', 'email') }}">

                        <input type="text" name="username" placeholder="username or brand name" value="{{ \App\classes\Request::oldData('post', 'username') }}">

                        {{--<input type="text" name="phone" placeholder="phone number" value="{{ \App\classes\Request::oldData('post', 'phone') }}">--}}

                        <input type="password" name="password" placeholder="password">

                        <select name="country_name" id="">
                            <option value="">Select your Country</option>
                            <option value="Ghana">Ghana</option>
                        </select>

                        <select name="state_name">
                            <option value="">Select your Region/State</option>
                            <option value="Greater Accra">Greater Accra</option>
                        </select>

                        <input type="text" name="phone" placeholder="Phone No. (eg. 0244001234)" value="{{ \App\classes\Request::oldData('post', 'phone') }}">

                        <input type="text" name="city"  placeholder="City" value="{{ \App\classes\Request::oldData('post', 'city') }}">

                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">

                        <button class="button float-right success">Register</button>
                    </form>

                    <p>Already have an Account? <a href="/login"> Sign In </a></p>

                    {{--END REGISTER FORM--}}
                </div>

            </div>

        </section>



    </div>




@endsection
