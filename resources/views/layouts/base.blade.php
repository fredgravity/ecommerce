<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ getenv('HOME_NAME') }} - @yield('title')</title>
    <link rel="stylesheet" href="/css/all.css">
    <link rel="shortcut icon" type="image/png" href="/favicon.png">

</head>

<body data-page-id="@yield('data-page-id')" >
@include('includes.preloader')


    <!-- Your page content lives here -->

<div id="hide-div" style="display: none">
    <!-- Your page content lives here -->
    @yield('body')
</div>






    <script src="/fontawesome/js/allfonts.js"></script>
    <script src="/js/all.js"></script>

</body>
</html>

