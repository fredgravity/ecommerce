@extends('layouts.app')
@section('title', 'Contact Us')
@section('data-page-id', 'contact_us')


@section('content')

<div class="home">

    <div class="grid-container">

            @include('includes.message')

        <div class="grid-padding-x grid-x">

            <div class="medium-2 cell">

            </div>

            <div class="small-12 medium-8 cell">


                <form action="/contactus/send" method="post" id="contact-us-form">

                    <h3 class="text-center contact-artisao-heading">Contact Artisao</h3>

                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" value="{{ \App\classes\Request::oldData('post', 'fullname') }}">

                    <label for="email">Email Address</label>
                    <input type="text" id="email" name="email" value="{{ \App\classes\Request::oldData('post', 'email') }}">

                    <label for="phone">Phone Number (optional)</label>
                    <input type="text" id="phone" name="phone" value="{{ \App\classes\Request::oldData('post', 'phone') }}">

                    <label for="message">Message to Us</label>
                    <textarea id="message"  cols="10" rows="10" name="message" ></textarea>

                    <input type="submit" class="button primary" value="Send">
                    <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">

                </form>

            </div>

            <div class="medium-2 column">

            </div>

        </div>

    </div>

</div>



@endsection