<?php
/* ALL SHOW METHOD HAVE A GET REQUEST FOR PAGE DISPLAY*/



    //FOR ADMIN ROUTES
    $router->map('GET', '/user', 'App\Controllers\User\UserDashboardController@show', 'user_dashboard');
    $router->map('GET', '/user/charts', 'App\Controllers\User\UserDashboardController@getChartData', 'user_dashboard_chart');

    $router->map('GET', '/user/orderDetails', 'App\Controllers\User\UserOrderController@show', 'user_order_details');
    $router->map('POST', '/user/orders/search', 'App\Controllers\User\UserOrderController@searchOrders', 'user_order_search');
    $router->map('POST', '/user/product/rating', 'App\Controllers\User\UserOrderController@rating', 'user_product_rating');
    $router->map('GET', '/user/product/get-rating', 'App\Controllers\User\UserOrderController@getRating', 'user_product_get_rating');

    $router->map('POST', '/user/orders/[i:id]/deleteorder', 'App\Controllers\User\UserOrderController@deleteOrder', 'user_order_delete');
    $router->map('GET', '/user/userDetails', 'App\Controllers\User\UserController@show', 'user_details_show');

    $router->map('POST', '/user/[i:id]/update', 'App\Controllers\User\UserController@updateUser', 'user_details_update');
    $router->map('POST', '/user/[i:id]/changepassword', 'App\Controllers\User\UserController@changePassword', 'user_details_changepassword');

    $router->map('GET', '/user/payments', 'App\Controllers\User\UserPaymentController@showPayments', 'user_payment');
    $router->map('POST', '/user/payment/converter', 'App\Controllers\User\UserPaymentController@paymentConverter', 'user_payment_convert');
    $router->map('GET', '/user/payments/chart', 'App\Controllers\User\UserPaymentController@paymentChart', 'user_payment_chart');

?>