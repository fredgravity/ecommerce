
(function () {
    // track and report errors
    'use strict';

    $(document).foundation();

    $(document).ready(function () {




        //PERFORM SWITCH STATEMENT
        switch ($('body').data('page-id')){
            //PAGE ID OF HOME
            case 'home':
                ARTISAOSTORE.homeslider.initCarousel();
                ARTISAOSTORE.homeslider.homePageProducts();
                break;

            //PAGE ID OF PRODUCT
            case 'product':
                ARTISAOSTORE.product.details();
                ARTISAOSTORE.product.locateMap();
                break;

            //PAGE ID OF ADMIN PRODUCT
            case 'adminProduct':
                ARTISAOSTORE.admin.changeEvent();
                ARTISAOSTORE.admin.delete();
                // ARTISAOSTORE.admin.search();
                break;

            case 'vendorVerify':
                ARTISAOSTORE.admin.search();
                break;

            //PAGE ID OF ADMIN CATEGORY
            case 'adminCategory':
                ARTISAOSTORE.admin.update();
                ARTISAOSTORE.admin.delete();
                ARTISAOSTORE.admin.create();
                break;

            case 'adminDashboard':
                ARTISAOSTORE.admin.dashboard();

                break;

            case 'subItem':
                ARTISAOSTORE.nav.subItem();

                break;

            case 'categoryItem':
                ARTISAOSTORE.nav.categoryItem();

                break;

            case 'cart':
                ARTISAOSTORE.product.cart();

                break;

            case 'productOrders':
                ARTISAOSTORE.admin.productOrders();
                ARTISAOSTORE.admin.deleteOrder();

                break;

            case 'editOrders':
                ARTISAOSTORE.admin.editOrder();
                break;

            case 'usersDashboard':
                ARTISAOSTORE.admin.usersChart();
                break;

            case 'users':
                ARTISAOSTORE.admin.deleteUser();
                ARTISAOSTORE.admin.searchUser();
                break;

            case 'paymentDashboard':
                ARTISAOSTORE.admin.payment();
                break;

            case 'userDashboard':
                ARTISAOSTORE.user.user_dashboard();
                break;

            case 'userOrders':
                ARTISAOSTORE.user.userOrders();
                ARTISAOSTORE.user.deleteOrder();
                break;

            case 'userPayment':
                ARTISAOSTORE.user.payment();

                break;

            case 'vendorDashboard':
                ARTISAOSTORE.vendor.vendorDashboard();
                break;

            case 'vendorProduct':
                ARTISAOSTORE.vendor.changeEvent();
                ARTISAOSTORE.vendor.deleteVendorProduct();
                ARTISAOSTORE.vendor.vendorProduct();
                break;

            case 'vendorOrders':
                ARTISAOSTORE.vendor.vendorOrders();
                ARTISAOSTORE.vendor.deleteVendorOrder();
                break;

            case 'revenueDashboard':
                ARTISAOSTORE.vendor.revenue();
                break;

            case 'vendorValidateAccount':
                ARTISAOSTORE.vendor.uploadIds();
                break;

            case 'searchProduct':
                ARTISAOSTORE.home.searchPage();
                ARTISAOSTORE.home.changeSearchEvent();
                ARTISAOSTORE.home.advSearch();
                break;

            case 'searchAdvanceProduct':
                ARTISAOSTORE.home.advSearch();
                ARTISAOSTORE.home.changeSearchEvent();
                break;



            default:
            //DO NOTHING

        }

    });

    $(window).on('load', function () {
        //REMOVE THE PRELOADER IMAGE AFTER TIME OUT
        setTimeout(function () {

            $('.preloader').css('display', 'none');
            $('#hide-div').css('display', '');

        }, 1000);
    });






})();

