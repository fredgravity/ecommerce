<?php
/* ALL SHOW METHOD HAVE A GET REQUEST FOR PAGE DISPLAY*/



    //FOR ADMIN ROUTES
    $router->map('GET', '/admin', 'App\Controllers\Admin\DashboardController@show', 'admin_dashboard');
    $router->map('POST', '/admin', 'App\Controllers\Admin\DashboardController@get', 'admin_form');
    $router->map('GET', '/admin/charts', 'App\Controllers\Admin\DashboardController@getChartData', 'admin_dashboard_chart');

    //PRODUCT MANAGEMENT {SHOW},{STORE},{EDIT},{DELETE}
    $router->map('GET', '/admin/product/categories', 'App\Controllers\Admin\ProductCategoryController@show', 'product_category');
    $router->map('POST', '/admin/product/categories', 'App\Controllers\Admin\ProductCategoryController@store', 'create_product_category');
    $router->map('POST', '/admin/product/categories/[i:id]/edit', 'App\Controllers\Admin\ProductCategoryController@edit', 'edit_product_category');
    $router->map('POST', '/admin/product/categories/[i:id]/delete', 'App\Controllers\Admin\ProductCategoryController@delete', 'delete_product_category');

    //SUB CATEGORY
    $router->map('POST', '/admin/product/subcategory/create', 'App\Controllers\Admin\SubCategoryController@store', 'create_sub_category');
    $router->map('POST', '/admin/product/subcategory/[i:id]/edit', 'App\Controllers\Admin\SubCategoryController@edit', 'edit_sub_category');
    $router->map('POST', '/admin/product/subcategory/[i:id]/delete', 'App\Controllers\Admin\SubCategoryController@delete', 'delete_sub_category');

    //PRODUCT {SHOW FORM}, {STORE}, {TOGGLE SUBCATEGORY WITH CATEGORY SELECTED}, {SHOW PRODUCT}, {TOGGLE EDIT}, {SHOW EDIT}
    $router->map('GET', '/admin/product/create', 'App\Controllers\Admin\ProductController@showCreateProductForm', 'create_product_form');
    $router->map('POST', '/admin/product/create', 'App\Controllers\Admin\ProductController@store', 'create_product');
    $router->map('GET', '/admin/category/[i:id]/selected', 'App\Controllers\Admin\ProductController@getSubcategory', 'selected_category');
    $router->map('GET', '/admin/products', 'App\Controllers\Admin\ProductController@show', 'show_product_inventory');
    $router->map('GET', '/admin/product/[i:id]/edit', 'App\Controllers\Admin\ProductController@showEditProductForm', 'edit_product_form');
    $router->map('POST', '/admin/product/edit', 'App\Controllers\Admin\ProductController@edit', 'edit_product');
    $router->map('POST', '/admin/product/[i:id]/delete', 'App\Controllers\Admin\ProductController@delete', 'delete_product');

    $router->map('POST', '/admin/products', 'App\Controllers\Admin\ProductController@searchProduct', 'search_product_inventory');
//    $router->map('GET', '/admin/products/inventorySearch', 'App\Controllers\Admin\VendorProductController@searchProduct', 'search_show_product_inventory');


    $router->map('GET', '/admin/orders', 'App\Controllers\Admin\OrderController@show', 'show_order');
    $router->map('POST', '/admin/orders/loadorderdetails', 'App\Controllers\Admin\OrderController@loadOrderDetails', 'show_more_order_details');
    $router->map('POST', '/admin/orders/loadproductdetails', 'App\Controllers\Admin\OrderController@productDetails', 'load_more_product_details');
    $router->map('POST', '/admin/orders/search', 'App\Controllers\Admin\OrderController@searchOrders', 'search_order_details');
    $router->map('POST', '/admin/orders/[i:id]/deleteorder', 'App\Controllers\Admin\OrderController@deleteOrder', 'delete_order');
    $router->map('POST', '/admin/orders/[i:id]/deleteorderdetails', 'App\Controllers\Admin\OrderController@deleteOrderDetails', 'delete_order_details');
    $router->map('GET', '/admin/orders/[i:id]/edit', 'App\Controllers\Admin\OrderController@showEditOrderForm', 'show_edit_order_details_form');
    $router->map('POST', '/admin/orders/[i:id]/update', 'App\Controllers\Admin\OrderController@updateEditOrderForm', 'update_edit_order_details_form');


    $router->map('GET', '/admin/users-dashboard', 'App\Controllers\Admin\UserController@showDashboard', 'show_users_dashboard');
    $router->map('GET', '/admin/userCharts', 'App\Controllers\Admin\UserController@getChartData', 'show_users_chart');
    $router->map('GET', '/admin/users-details', 'App\Controllers\Admin\UserController@show', 'show_users');
    $router->map('POST', '/admin/user/[i:id]/deleteuser', 'App\Controllers\Admin\UserController@deleteUser', 'delete_user');
    $router->map('POST', '/admin/user/search', 'App\Controllers\Admin\UserController@searchUser', 'search_user');
    $router->map('GET', '/admin/user/[i:id]/edit', 'App\Controllers\Admin\UserController@editUser', 'edit_user');
    $router->map('POST', '/admin/user/[i:id]/update', 'App\Controllers\Admin\UserController@updateUser', 'update_user');
    $router->map('POST', '/admin/user/[i:id]/changepassword', 'App\Controllers\Admin\UserController@changePassword', 'change_user_password');

    $router->map('GET', '/admin/vendors-details', 'App\Controllers\Admin\UserController@showVendors', 'show_vendors');

    $router->map('GET', '/admin/users/payments', 'App\Controllers\Admin\PaymentController@showPayments', 'show_payments');
    $router->map('POST', '/admin/users/payments/converter', 'App\Controllers\Admin\PaymentController@paymentConverter', 'payment_converter');
    $router->map('GET', '/admin/payments/chart', 'App\Controllers\Admin\PaymentController@paymentChart', 'payment_chart');

    $router->map('GET', '/admin/vendorVerify', 'App\Controllers\Admin\ValidateAccountsController@show', 'show_vendor_accounts');
    $router->map('POST', '/admin/vendorVerify/search', 'App\Controllers\Admin\ValidateAccountsController@search', 'vendor_verify_search');

    $router->map('POST', '/admin/vendorVerify/approval', 'App\Controllers\Admin\ValidateAccountsController@approval', 'vendor_verify_approval');
    $router->map('GET', '/admin/vendorVerify/getCheckboxStatus', 'App\Controllers\Admin\ValidateAccountsController@getCheckboxStatus', 'vendor_verify_status');

    $router->map('GET', '/admin/broadcast-email', 'App\Controllers\Admin\UserController@showBroadcastForm', 'show_mailing_list_form');
    $router->map('POST', '/admin/send/broadcast', 'App\Controllers\Admin\UserController@sendBroadcast', 'send_mailing_list');

?>