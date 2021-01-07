<?php
/* ALL SHOW METHOD HAVE A GET REQUEST FOR PAGE DISPLAY*/



    //FOR SEARCH ROUTES
    $router->map('POST', '/show-search', 'App\Controllers\SearchController@showSearch', 'show_search_form');
    $router->map('POST', '/search-product', 'App\Controllers\SearchController@searchProduct', 'search_product');
//    $router->map('GET', '/search-product', 'App\Controllers\SearchController@show', 'search_product_show');
    $router->map('POST', '/product-search', 'App\Controllers\SearchController@productSearch', 'product_search');
    $router->map('POST', '/product-advance-search', 'App\Controllers\SearchController@advanceSearch', 'product_advance_search');
    $router->map('GET', '/get-subcategories/[i:id]', 'App\Controllers\SearchController@getSubcategory', 'get_search_sub_categories');
    $router->map('POST', '/advance-search-loadmore', 'App\Controllers\SearchController@loadMore', 'advance_search_loadmore');
//    $router->map('GET', '/search-show', 'App\Controllers\SearchController@show', 'show_search');


?>