(function () {
    'use strict';

    ARTISAOSTORE.product.cart = function () {

        shoppingCart();
        // shoppingCartModal();

    };

    function shoppingCart() {
        var app = new Vue({
            el: '#shopping_cart',

            data: {
                items: [],
                cartTotal: [],
                loading: false,
                failed: false,
                authenticated: false,
                token: $('#checkout').data('token'),
                paypalUrl: '',
                message: ''

            },

            methods: {
                displayItems: function (time) {
                    this.loading = true;
                    setTimeout(function () {
                        axios.get('/cart/items').then(function (response) {
                            //CHECK FOR FAILED RESPONSE FROM CART CONTROLLER
                            if(response.data.failed){
                                app.failed = true;
                                app.message = response.data.failed;
                                app.loading = false;
                            }else{
                                app.items = response.data.items;
                                app.cartTotal = response.data.cartTotal;
                                app.authenticated = response.data.authenticated;
                                app.loading = false;
                            }
                        }).catch(function (error) {
                            console.log(error);
                        });
                    }, time);
                },

                updateQuantity: function (product_id, operator) {
                    var postData = $.param({product_id: product_id, operator:operator});
                    axios.post('/cart/update-qty', postData).then(function (response) {
                        app.displayItems(200);
                    })
                },

                removeItem: function (index) {
                    var postData = $.param({item_index: index});
                    axios.post('/cart/remove-item', postData).then(function (response) {
                        $('.notify').css('display', 'block').delay(2000).slideUp(300).html(response.data.success);
                        app.displayItems(200);
                    })
                },

                emptyCart: function () {
                    axios.post('/cart/empty-cart').then(function (response) {
                        $('.notify').css('display', 'block').delay(2000).slideUp(300).html(response.data.success);
                        app.displayItems(200);
                    })
                },

                checkout: function () {

                    var postData = $.param({authenticated: this.authenticated, items: this.items, token:this.token, cartTotal: this.cartTotal });
                    axios.post('/cart/paywithmm', postData).then(function (response) {
                        app.chechoutData = response.data;
                        window.location.href = app.chechoutData.data.checkoutUrl;
                        console.log(response.data.data);
                    }).catch(function (error) {
                        console.log(error);
                    });

                },


                paypalSDK: function () {

                    this.loading = true;
                    var postData = $.param({authenticated: this.authenticated, items: this.items, token:this.token, cartTotal: this.cartTotal });
                    console.log(this.items);
                    axios.post('/cart/paypalAPI', postData).then(function (response) {
                        if (response.data){
                            app.loading = false;
                        }
                        window.location.href = response.data.paypalUrl;
                    }).catch(function (error) {
                        console.log(error);
                    });

                },

                ipayModal: function () {

                    // alert (this.token);
                    this.loading = true;
                    var postData = $.param({authenticated: this.authenticated, items: this.items, token:this.token, cartTotal: this.cartTotal });

                    axios.post('/cart/ipay', postData).then(function (response) {
                        if (response.data){
                            app.loading = false;
                            console.log(response.data);
                        }
                    }).catch(function (error) {
                        console.log(error);
                    });
                },

                myipay_btn: function () {
                    $('#myipay-btn').on('click', function (e) {
                        e.preventDefault();
                        let token = $('#myipay-btn').data('token');
                        let channel = $('#channel').val();
                        let phone = $('#phone').val();
                        alert('do you want to proceed with the payment?');

                        let postData = $.param({authenticated: app.authenticated, items: app.items, token:token, cartTotal: app.cartTotal, channel:channel, phone:phone });
                        axios.post('/cart/ipay', postData).then(function (response) {
                            if (response.data == null ){
                                app.loading = false;
                                console.log(response.data);
                                $('#myipay_notify').html(':( something went wrong, please try again later');
                            }else{
                                let notify = response.data.result;
                                $('#myipay_notify').html('the items on your cart has been '+ notify);
                            }
                        }).catch(function (error) {
                            console.log(error);
                        });
                    })
                }

                // paypalCheckout: function () {
                //     setTimeout(function () {
                //         let payPalInfo = $('#paypalInfo');
                //         let baseUrl = payPalInfo.data('app-baseurl');
                //         let environment = payPalInfo.data('app-env');
                //         let env = 'sandbox';
                //
                //
                //
                //         if (environment === 'production'){
                //             env = 'production';
                //         }
                //
                //         paypal.Button.render({
                //             env: env, // Or 'production'
                //             // Set up the payment:
                //             // 1. Add a payment callback
                //             payment: function(data) {
                //                 // 2. Make a request to your server
                //                 return paypal.request.post('/paypal/create-payment')
                //                     .then(function(data) {
                //                         // 3. Return res.id from the response
                //                         return data.id;
                //                     }).catch(function (error) {
                //                         console.log(error);
                //                     });
                //             },
                //             // Execute the payment:
                //             // 1. Add an onAuthorize callback
                //             onAuthorize: function(data) {
                //                 // 2. Make a request to your server
                //                 return paypal.request.post(baseUrl + '/paypal/execute-payment', {
                //                     paymentID: data.paymentID,
                //                     payerID:   data.payerID
                //                 })
                //                     .then(function(res) {
                //                         // 3. Show the buyer a confirmation message.
                //                     });
                //             }
                //         }, '#paypalBttn');
                //     }, 3000)
                //
                // }

            },

            created:function () {
                this.displayItems(2000);
                this.myipay_btn();

            },

            mounted:function () {
                // this.paypalCheckout();
            }

        });
    }


})();