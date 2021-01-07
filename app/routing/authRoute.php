<?php


$router->map('GET', '/register', 'App\Controllers\AuthController@showRegisterForm', 'register');
$router->map('GET', '/vendor-register', 'App\Controllers\AuthController@showVendorRegisterForm', 'register_vendor_form');
$router->map('POST', '/register', 'App\Controllers\AuthController@register', 'register_me');
$router->map('POST', '/register/vendor', 'App\Controllers\AuthController@registerVendor', 'register_vendor');


$router->map('GET', '/login', 'App\Controllers\AuthController@showLoginForm', 'login');
$router->map('POST', '/login', 'App\Controllers\AuthController@login', 'log_me_in');

$router->map('GET', '/logout', 'App\Controllers\AuthController@logout', 'logout');

$router->map('GET', '/account-verification/[*:key]', 'App\Controllers\AuthController@verifyAccount', 'verify_account');
$router->map('GET', '/mailing_list-unsubscribe/[*:key]', 'App\Controllers\AuthController@unsubscribe', 'unsubscribe_mailing_list');

?>