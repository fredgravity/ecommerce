(function () {
    'use strict';

    ARTISAOSTORE.admin.productOrders = function () {
        let app = new Vue({
            el: "#orders",
            data:{
                orders: [],
                users: [],
                orderDetails: [],
                products: [],
                message: '',
                loading: false,
                orderSearch: [],
                showSearch: false,



            },

            methods: {
                displayOrderDetails: function () {
                    alert('hi');
                },

                moreOrders: function (id) {
// alert(id);
                       this.loading = true;
                    let token = $('#more').data('token');
// alert(token);
                    let postData = $.param({ orderId: id, token: token});

                    axios.post('/admin/orders/loadorderdetails', postData).then(function (response) {

                        app.orders = response.data.orders;
                        app.users = response.data.orders.user;
                        app.orderDetails = response.data.orderDetails;
                        // console.log( app.orders);
                        // console.log( app.users);
                        // console.log( app.orderDetails);
                        // setTimeout(function () {
                        //     app.productOrderDetails();
                        // },1000);


                        app.loading = false;

                    }).catch(function (error) {
                        console.log(error);
                    });
                        $('.moreOrder').show();


                },

                lessOrders: function (id) {
                    // alert(id);
                    $('.moreOrder').hide();
                },

                productOrderDetails: function () {
                    let orderDetails = this.orderDetails;
                    orderDetails.forEach(function (orders) {
                        let postData = $.param({productID: orders.product_id});
                        axios.post('/admin/orders/loadproductdetails', postData).then(function (response) {
                            app.products.push(response.data.products);

                        }).catch(function (error) {
                            console.log(error);
                        });
                        console.log(app.products);

                    });
                },

                searchOrders: function () {

                    let search = $('#searchOrder').val();
                    let token = $('#searchOrder').data('token');
                    // alert (token);
                    let postData = $.param({search:search, token:token});

                    axios.post('/admin/orders/search', postData).then(function (response) {
                        app.orderSearch = response.data.searchResults;

                            app.showSearch = true;

                        $('.moreOrder').hide();
                        $('#more-search-details').hide();

                    });


                },

                searchMoreOrders: function (id){

                    this.loading = true;


                    let searchId = id;

                    let token = $('#more-search').data('token');

                    let postData = $.param({ orderId: searchId, token: token});

                    axios.post('/admin/orders/loadorderdetails', postData).then(function (response) {

                        app.orders = response.data.orders;
                        app.users = response.data.orders.user;
                        app.orderDetails = response.data.orderDetails;
                        app.loading = false;

                    }).catch(function (error) {
                        console.log(error);
                    });
                    $('.more-search-details').show();
                },

                searchLessOrders: function (){
                    $('.more-search-details').hide();

                },

            },

            created: function () {
                // this.displayOrderDetails();
            }
        });

    }


})();