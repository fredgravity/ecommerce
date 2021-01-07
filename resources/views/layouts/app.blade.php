@extends('layouts.base')


@section('body')

{{--NAVIGATION--}}
    @include('includes.nav')



{{--SITE WRAPPER--}}
    <div class="site_wrapper">
         @yield('content')



        <div class="notify text-center">

        </div>

    </div>


    @yield('footer')

@endsection
