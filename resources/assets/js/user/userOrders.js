(function () {
    'use strict';

    ARTISAOSTORE.user.userOrders = function () {
        let app = new Vue({
            el: "#orders",
            data:{

                message: '',
                loading: false,
                orderSearch: [],
                orderSearchProduct: [],
                showSearch: false,
                userId: '',
                ratings: []

            },

            methods: {

                searchOrders: function () {

                    let search = $('#searchOrder').val();
                    let token = $('#searchOrder').data('token');
                    // alert (token + ' ' + search);
                    let postData = $.param({search: search, token: token});

                    axios.post('/user/orders/search', postData).then(function (response) {
                        app.orderSearch = response.data.searchResults;
                        app.orderSearchProduct = response.data.searchProduct;
                        app.userId = response.data.userId;
                        app.showSearch = true;
                        // console.log(app.orderSearch);

                    });


                },

                sendRate: function (id, event) {
                    let rateValue = event.target.value;
                    let token = $('#orders').data('token');

                    let postData = $.param({rating: rateValue, productId: id, token: token});
// console.log(id);
                    axios.post('/user/product/rating', postData).then(function (res) {

                        $('.notify').css('display', 'block').delay(2000).slideUp(300).html(res.data.res);

                    }).catch(function (err) {
                        console.log(err);
                    })
                },

                getRating: function (productId) {
                    setTimeout(function () {

                        axios.get('/user/product/get-rating').then(function (res) {
                            app.ratings = res.data.res;
                            // console.log(app.ratings);
                        }).catch(function (err) {
                            console.log(err);
                        })

                    }, 3000);

                },

                deleteUserOrder: function () {
                    // alert('hi');
                    $('.deleteUser-order').on('click',function () {
                        // e.preventDefault();
                        let form = (this);

                        $('#confirm').foundation('open').on('click', '#delete-btn', function () {
                            // alert('hi');
                            form.submit();
                        })

                    })
                },

            },

            created: function () {
                // this.getRating();
                // this.displayOrderDetails();
                this.deleteUserOrder();
            },

            mounted: function () {


            }
        });

    }



})();