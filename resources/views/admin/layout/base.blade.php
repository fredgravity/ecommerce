<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - @yield('title')</title>
    <link rel="stylesheet" href="/css/all.css">
    <link rel="shortcut icon" type="image/png" href="/favicon.png">

</head>
<body data-page-id="@yield('data-page-id')" >
@include('includes.preloader')
{{-- INCLUDE THE SIDE BAR --}}

<div id="hide-div" style="display: none">
    @include('includes.admin-sidebar')

    {{-- END INCLUDE THE SIDE BAR --}}

    {{-- TITLE BAR --}}
    <div class="off-canvas-content admin_title_bar" data-off-canvas-content>

        {{--TITLE BAR--}}
        <div class="title-bar">
            <div class="title-bar-left">
                <button class="menu-icon hide-for-large" type="button" data-open="offCanvas"></button>
                <span class="title-bar-title">{{ getenv('APP_NAME') }}</span>
            </div>
        </div>

        <!-- Your page content lives here -->
        @yield('content')
    </div>
    {{-- END TITLE BAR --}}
</div>


<script src="/fontawesome/js/allfonts.js"></script>
<script src="/js/all.js"></script>

</body>
</html>

