@extends('layouts.base')


@section('body')

{{--NAVIGATION--}}
    @include('includes.nav')
    @include('includes.search-sidebar')


{{--SITE WRAPPER--}}
    <div class="site_wrapper">
         @yield('content')



        <div class="notify text-center">

        </div>

    </div>


    @yield('footer')

@endsection
