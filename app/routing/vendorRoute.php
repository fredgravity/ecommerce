<?php
/* ALL SHOW METHOD HAVE A GET REQUEST FOR PAGE DISPLAY*/


    //FOR ADMIN ROUTES
    $router->map('GET', '/vendor', 'App\Controllers\Vendor\VendorDashboardController@show', 'vendor_dashboard');
    $router->map('GET', '/vendor/charts', 'App\Controllers\Vendor\VendorDashboardController@getChartData', 'vendor_dashboard_chart');
//
    $router->map('GET', '/vendor/orders', 'App\Controllers\Vendor\VendorOrderController@show', 'vendor_order');
    $router->map('POST', '/vendor/orders/search', 'App\Controllers\Vendor\VendorOrderController@searchOrders', 'vendor_order_search');
    $router->map('POST', '/vendor/orderStatus/edit', 'App\Controllers\Vendor\VendorOrderController@orderStatusEdit', 'vendor_order_status_edit');
//
    $router->map('POST', '/vendor/order/[a:inv]/deleteorder', 'App\Controllers\Vendor\VendorOrderController@deleteOrder', 'vendor_order_delete');
    $router->map('GET', '/vendor/vendorDetails', 'App\Controllers\Vendor\VendorController@show', 'vendor_details_show');
//
    $router->map('POST', '/vendor/[i:id]/update', 'App\Controllers\Vendor\VendorController@updateUser', 'vendor_details_update');
    $router->map('POST', '/vendor/[i:id]/changepassword', 'App\Controllers\Vendor\VendorController@changePassword', 'vendor_details_changepassword');
//
    $router->map('GET', '/vendor/revenue', 'App\Controllers\Vendor\VendorRevenueController@showRevenue', 'vendor_revenue');
    $router->map('POST', '/vendor/revenue/converter', 'App\Controllers\Vendor\VendorRevenueController@revenueConverter', 'vendor_revenue_convert');
    $router->map('GET', '/vendor/revenue/chart', 'App\Controllers\Vendor\VendorRevenueController@revenueChart', 'vendor_revenue_chart');
//    $router->map('GET', '/vendor/revenue/details', 'App\Controllers\Vendor\VendorRevenueController@revenueDetails', 'vendor_revenue_details');

    $router->map('GET', '/vendor/product/create', 'App\Controllers\Vendor\VendorProductController@showCreateProductForm', 'vendor_show_product_form');
    $router->map('GET', '/vendor/category/[i:id]/selected', 'App\Controllers\Vendor\VendorProductController@getSubcategory', 'vendor_get_subcategory');
    $router->map('POST', '/vendor/[i:id]/product/create', 'App\Controllers\Vendor\VendorProductController@vendorCreateProduct', 'vendor_create_product');
    $router->map('GET', '/vendor/product/manage', 'App\Controllers\Vendor\VendorProductController@showVendorInventory', 'vendor_inventory');
    $router->map('GET', '/vendor/product/[i:id]/edit', 'App\Controllers\Vendor\VendorProductController@showEditProductForm', 'vendor_product_edit_form');
    $router->map('POST', '/vendor/product/[i:id]/productEdit', 'App\Controllers\Vendor\VendorProductController@editVendorProduct', 'vendor_product_edit');
    $router->map('POST', '/vendor/product/[i:id]/delete', 'App\Controllers\Vendor\VendorProductController@deleteVendorProduct', 'vendor_product_delete');
    $router->map('POST', '/vendor/product/search', 'App\Controllers\Vendor\VendorProductController@searchVendorProduct', 'vendor_product_search');

    $router->map('GET', '/vendor/validateAccount', 'App\Controllers\Vendor\VendorValidateAccountController@show', 'vendor_validate_show');
    $router->map('POST', '/vendor/validate/identification', 'App\Controllers\Vendor\VendorValidateAccountController@submitId', 'vendor_validate_id');
    $router->map('POST', '/vendor/validate/certification', 'App\Controllers\Vendor\VendorValidateAccountController@submitCert', 'vendor_validate_cert');

    $router->map('GET', '/vendor/getIdCard', 'App\Controllers\Vendor\VendorValidateAccountController@getId', 'get_id_card');
    $router->map('GET', '/vendor/getCert', 'App\Controllers\Vendor\VendorValidateAccountController@getCert', 'get_cert');




    ?>