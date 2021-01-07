
<!-- SIDE BAR -->
<div class="off-canvas position-left reveal-for-large nav searchCanvas" id="offCanvas" data-off-canvas >

    <a href="/"><img src="/images/logo.png" alt="Artisao" ></a>
{{--{{ pnd($results) }}--}}



    @if(count($categories))
        <hr>
        <ul>
            <li><p class="-divide">Categories</p></li>
        </ul>
        <hr>
        <ul class="side-nav">

            @foreach($categories as $index => $category)

                <li><a href="/category_items/{{ $category->id }}">{{ $category->name }}  ( {{ $totalItems[$index] }} )</a></li>

            @endforeach
            <br>

        </ul>

    @endif
    <hr>
    <ul>
        <li class=""><p>Advance Search</p></li>
    </ul>
    <hr>

    <div class="row align-right searchCanvasForm">
        <div class="column small-12">
            <form action="/product-advance-search" method="post" id="searchCanvasForm">
                <label for="search">Search Term Required</label>
                <input type="text" id="search" name="search" placeholder="Search" value="{{ \App\classes\Request::oldData('post', 'search') }}">

                <label for="search-category">Select Category</label>
                <select name="category" id="search-category">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                </select>

                <label for="search-subCategory">Select Subcategory</label>
                <select name="subCategory" id="search-subCategory">
                    <option value="" >Select Subcategory</option>

                </select>

                <div class="row align-right">
                    <div class="small-6 column">
                        <input type="text" id="min" name="min" placeholder="min price" value="{{ \App\classes\Request::oldData('post', 'min') }}">
                    </div>

                    <div class="small-6 column">
                        <input type="text" id="max" name="max" placeholder="max price" value="{{ \App\classes\Request::oldData('post', 'max') }}">
                    </div>
                </div>

                <label for="country">Choose Country</label>
                <select name="country" id="country">
                    <option value="ghana" selected >Ghana</option>
                </select>

                <input type="submit" value="Search" class="button primary expanded">
                <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">

            </form>
        </div>

    </div>



</div>