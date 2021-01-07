@extends('layouts.app')
@section('title', 'Login to your Account')
@section('data-page-id', 'auth')


@section('content')

    <div class="auth " id="auth">

        {{--DISPLAY SPINNER CUBE IF VUE JS LOADING IS TRUE--}}
        {{--<div class="text-center loading-spinner">--}}
            {{--<img src="/images/spinners/cube.gif" alt="loader" v-if="loading === true" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >--}}

        {{--</div>--}}

        <section class="login_form grid-container">

            <div class="grid-x grid-padding-x" style="padding-top: 30px;">

                <div class="medium-2 cell">

                </div>

                <div class="cell small-12 medium-7 ">
                    <h2 class="text-center">Login</h2>

                    {{--INCLUDE THE MESSAGE FOR ERROR DISPLAY--}}
                    @include('includes.message')

                    {{--REGISTER FORM--}}
                    <form action="" method="post" >


                        {{--<input type="text" name="email" placeholder="email address" value="{{ \App\classes\Request::oldData('post', 'email') }}">--}}

                        <input type="text" name="username" placeholder="username or email" value="{{ \App\classes\Request::oldData('post', 'username') }}">

                        {{--<input type="text" name="phone" placeholder="phone number" value="{{ \App\classes\Request::oldData('post', 'phone') }}">--}}

                        <input type="password" name="password" placeholder="password">

                        {{--<input type="password" name="password_repeat" placeholder="repeat password" >--}}
                        <label for="remember"> <input type="checkbox" name="remember_me" id="remember"> Remember Me </label>


                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">

                        <button class="button float-right success">Login</button>
                    </form>

                    <p>Don't have an Account? <a href="/register"> Register Here </a></p>
                    {{--END REGISTER FORM--}}
                </div>

            </div>

        </section>



    </div>




@endsection
