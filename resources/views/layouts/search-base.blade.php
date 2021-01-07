<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Artisao - @yield('title')</title>
    <link rel="stylesheet" href="/css/all.css">
    {{--<link rel="stylesheet" href="/fontawesome/js/allfonts.js">--}}
</head>
<body data-page-id="@yield('data-page-id')">
@include('includes.preloader')
{{-- INCLUDE THE SIDE BAR --}}

@include('includes.search-sidebar')

{{-- END INCLUDE THE SIDE BAR --}}

{{-- TITLE BAR --}}
    <div class="off-canvas-content admin_title_bar" data-off-canvas-content>

        {{--TITLE BAR--}}
        <div class="title-bar">
            <div class="title-bar-left">
                <button class="menu-icon hide-for-large" type="button" data-open="offCanvas"></button>
                @if($advance)
                    <h5 class="title-bar-title text-center">Search Artisao Product - "{{ $advance }}"</h5>
                    @elseif ($searchWord)
                    <h5 class="title-bar-title text-center">Search Artisao Product - "{{ $searchWord }}"</h5>
                    @endif

            </div>
        </div>

        <!-- Your page content lives here -->
        @yield('content')
    </div>
{{-- END TITLE BAR --}}

<script src="/fontawesome/js/allfonts.js"></script>
<script src="/js/all.js"></script>

</body>
</html>

