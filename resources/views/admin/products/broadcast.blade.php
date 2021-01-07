@extends('admin.layout.base')
@section('title', 'Mail to Mailing List')
@section('data-page-id', 'broadcast')


@section('content')



    <div class="grid-container full admin_shared">

            @include('includes.message')

        <div class="grid-padding-x grid-x">

            <div class="medium-2 cell">

            </div>

            <div class="small-12 medium-8 cell">


                <form action="/admin/send/broadcast" method="post" id="contact-us-form">

                    <h3 class="text-center contact-artisao-heading">Send To Mailing List</h3>

                    <label for="email">From</label>
                    <input type="text" id="email" name="email" value="{{ user()->email }}">

                    <label for="mailList">To</label>
                    <select name="mailList" id="mailList">
                        <option value="user">Users</option>
                        <option value="vendor">Vendors</option>
                    </select>


                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" value="{{ \App\classes\Request::oldData('post', 'subject') }}">

                    <label for="message">Message</label>
                    <textarea id="message"  cols="10" rows="10" name="message" >{{ \App\classes\Request::oldData('post', 'message') }}</textarea>

                    <input type="submit" class="button primary" value="Send">
                    <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">

                </form>

            </div>

            <div class="medium-2 column">

            </div>

        </div>

    </div>





@endsection