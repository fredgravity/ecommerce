
<header class="navigation" id="navBar">
    <div class="title-bar toggle grid-x" data-responsive-toggle="main-menu" data-hide-for="medium">
        <div class="small-5">
            <button class="menu-icon float-left" type="button" data-toggle="main-menu"></button>
        </div>


        <div class="small-6">
            <a href="/" class="small-logo align-right"><img src="/images/logo.png" alt="atisao"></a>
        </div>

    </div>

    <div class="top-bar" id="main-menu">
        <div class="top-bar-title show-for-medium">
            <a href="/" class="logo"><img src="/images/logo.png" alt="artisao"></a>
        </div>
        <div>

            <div class="top-bar-left">
                <ul class="dropdown menu vertical medium-horizontal" data-dropdown-menu  >
                    @if(isAuthenticated())
                        @if( user()->image_path )
                            <li><a href="/{{ user()->role }}"><img src="/{{ user()->image_path }}" alt="{{ user()->username }}" id="nav-profile-pic">&nbsp;{{ user()->username }} </a> </li>

                        @else
                            <li><a href="/{{ user()->role }}"><img src="/images/defaultProfile1.jpg" alt="{{ user()->username }}" id="nav-profile-pic"> &nbsp;{{ user()->username }} </a> </li>
                        @endif


                    @endif

                    {{--CHECK FOR CATEGORIES AND DISPLAY IF ANY--}}
                    @if($categories)
                        <li >
                            <a class="top-bar-item" href="#">Categories &nbsp;<i class="fa fa-list"></i></a>

                            <ul class="dropdown menu vertical sub">
                                {{--LOOP THROUGH CATEGORIES AND DISPLAY EACH CATEGORY--}}
                                @foreach($categories as $category)

                                    <li>
                                        <a href="/category_items/{{ $category->id }}">{{ $category->name }}</a>

                                        {{--CHECK FOR SUB CATEGORIES--}}
                                        @if(count($category->subCategories))

                                            <ul class="dropdown menu sub">
                                                {{-- LOOP THROUGH SUB CATEGORIES AND DISPLAY EACH CATEGORY --}}
                                                @foreach($category->subCategories as $subCategory)
                                                    {{--/all_sub_items/{{ $subCategory->id }}--}}

                                                    <li>
                                                        <a href="/all_sub_items/{{ $subCategory->id }}" >{{ $subCategory->name }}</a>
                                                    </li>

                                                @endforeach

                                            </ul>
                                        @endif

                                    </li>

                                @endforeach
                            </ul>
                        </li>
                    @endif


                </ul>
            </div>
        </div>



        <div class="top-bar-right">
            <ul class="dropdown menu vertical medium-horizontal">
                {{--CHECK IF A USER HAS BEEN AUTHENTICATED--}}


                <li>
                    {{--<div >--}}

                        <form action="/search-product" method="post" class="grid-x grid-padding-y" >
                            <div class="medium-8 cell">
                                <input class="input-group-field" type="text" name="searchField" placeholder="Search" id="home-search">
                            </div>
                            <div class="medium-4 cell">
                                <button class="button hollow small search-btn "  type="submit" ><i class="fa fa-search"></i>Search</button>
                                <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                            </div>

                        </form>


                    {{--</div>--}}

                </li>

                @if(isAuthenticated())

                    <li><a class="top-bar-item" href="/logout"> Logout <i class="fa fa-sign-out-alt"></i> </a></li>
                @else
                    <li><a class="top-bar-item" href="/register">Register &nbsp;<i class="fa fa-user-plus"></i></a></li>
                    <li><a class="top-bar-item" href="/login"> Login <i class="fa fa-sign-in-alt"></i> </a></li>

                @endif

                <li><a class="top-bar-item" href="/contactus">Contact Us</a></li>
            </ul>



        </div>
    </div>
</header>