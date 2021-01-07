<?php

$router = new AltoRouter;

try{

    $router->map('GET', '/', 'App\Controllers\IndexController@show', 'home');
    $router->map('GET', '/featured', 'App\Controllers\IndexController@featuredProducts', 'feature_product');
    $router->map('GET', '/get-products', 'App\Controllers\IndexController@getProducts', 'get_products');
    $router->map('POST', '/load-more', 'App\Controllers\IndexController@loadMoreProducts', 'load_more_products');
    $router->map('GET', '/contactus', 'App\Controllers\IndexController@contactUs', 'contact_us');
    $router->map('POST', '/contactus/send', 'App\Controllers\IndexController@contactUsSend', 'contact_us_send');



    $router->map('GET', '/product/[i:id]', 'App\Controllers\ProductController@show', 'product');
    $router->map('GET', '/product-details/[i:id]', 'App\Controllers\ProductController@get', 'product_details');
    $router->map('GET', '/product-location/[i:id]', 'App\Controllers\ProductController@getProductLocation', 'product_location_details');

    $router->map('GET', '/product/get-location', 'App\Controllers\ProductController@getLocation', 'product_location');

    $router->map('GET', '/all_sub_items/[i:id]', 'App\Controllers\IndexController@allSubcategoryItemsShow', 'show_subcategory_items');
    $router->map('POST', '/get-subitems', 'App\Controllers\IndexController@getSubItems', 'get_all_subcategory_items');
    $router->map('POST', '/load-more-subItems', 'App\Controllers\IndexController@loadMoreSubitems', 'load_more_sub_items');

    $router->map('GET', '/category_items/[i:id]', 'App\Controllers\IndexController@allCategoryItemsShow', 'show_category_items');
    $router->map('POST', '/get-categoryitems', 'App\Controllers\IndexController@getCategoryItems', 'get_category_items');
    $router->map('POST', '/load-more-categoryItems', 'App\Controllers\IndexController@loadMoreCategoryitems', 'load_more_category_items');

    $router->map('POST', '/contact-vendor/[i:id]', 'App\Controllers\ProductController@contactVendor', 'contact_Vendor');

    $router->map('GET', '/termsandconditions', 'App\Controllers\IndexController@termsAndConditions', 'terms_and_conditions');

    $router->map('POST', '/product/comment' ,'App\Controllers\ProductController@comment', 'comment');


    //FOR CART ROUTES
    require_once PROOT.'app'.DS.'routing'.DS.'cartRoutes.php';

    //FOR AUTHENTICATION ROUTES
    require_once PROOT.'app'.DS.'routing'.DS.'authRoute.php';


    //FOR ADMIN ROUTES
   require_once PROOT.'app'.DS.'routing'.DS.'adminRoutes.php';

   //FOR USER ROUTES
    require_once PROOT.'app'.DS.'routing'.DS.'userRoute.php';

    //FOR VENDOR ROUTES
    require_once PROOT.'app'.DS.'routing'.DS.'vendorRoute.php';

    //FOR SEARCH ROUTES
    require_once PROOT.'app'.DS.'routing'.DS.'searchRoute.php';

}catch (Exception $e){
    $env = getenv('APP_ENV');
    if($env !== 'production'){
        echo 'Error Message: '. $e->getMessage();
    }
    echo "Error in Routing";
}





?>