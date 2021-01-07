
window .$ = window.JQuery = require('jquery');
require('es6-promise').polyfill();
window.axios = require('axios');
window.Vue = require('vue');

require('foundation-sites/dist/js/foundation.min');


//OTHER DEPENDENCIES

//SLICK CAROUSEL
require('slick-carousel/slick/slick.min');

//CHART JS
require('chart.js/dist/Chart.bundle.min');


//OUR CUSTOM JS FILES


require('../../assets/js/artisao');

require('../../assets/js/admin/create');
require('../../assets/js/admin/dashboard');
require('../../assets/js/admin/deleteOrder');
require('../../assets/js/admin/deleteUser');
require('../../assets/js/admin/events');
require('../../assets/js/admin/payment');
require('../../assets/js/admin/productOrders');
require('../../assets/js/admin/search');
require('../../assets/js/admin/update');
require('../../assets/js/admin/users');
require('../../assets/js/admin/usersChart');
require('../../assets/js/admin/delete');

require('../../assets/js/pages/lib');
require('../../assets/js/pages/slider');

require('../../assets/js/user/deleteUserOrder');
require('../../assets/js/user/user_dashboard');
require('../../assets/js/user/userOrders');
require('../../assets/js/user/userPayment');

require('../../assets/js/vendor/deleteVendorOrder');
require('../../assets/js/vendor/deleteVendorProduct');
require('../../assets/js/vendor/events');
require('../../assets/js/vendor/uploadIds');
require('../../assets/js/vendor/vendorDashboard');
require('../../assets/js/vendor/vendorOrders');
require('../../assets/js/vendor/vendorProduct');
require('../../assets/js/vendor/vendorRevenue');

require('../../assets/js/vue/advSearch');
require('../../assets/js/vue/cart');
require('../../assets/js/vue/categoryItem');
require('../../assets/js/vue/editOrders');
require('../../assets/js/vue/home_products');
require('../../assets/js/vue/map');
require('../../assets/js/vue/product_details');
require('../../assets/js/vue/search_products');
require('../../assets/js/vue/searchEvents');
require('../../assets/js/vue/subItem');

require('../../assets/js/init');

















