
(function () {
    'use strict';

    ARTISAOSTORE.homeslider.homePageProducts = function () {
        var app = new Vue({
            el:'#root',
            data:{
                featured: [],
                products: [],
                count: 0,
                loading: false
            },
            methods:{
                //GET FEATURED PRODUCTS FUNCTION
                getFeaturedProducts: function () {
                    this.loading = true;// TURN ON SPINNING


                    //PROCESS MULTI HTTP REQUEST
                    axios.all([

                        axios.get('/featured'),
                        axios.get('/get-products')

                    ]).then(axios.spread(function (featuredResponse, productResponse) {
                        //GET THE ECHOED JSON RESPONSE FROM INDEX CONTROLLER
                        app.featured = featuredResponse.data.featured;
                        app.products = productResponse.data.products;
                        app.count = productResponse.data.count;
                        app.loading = false;
                    })).catch(function (error) {
                        console.log(error);
                    });

                    //PROCESS SINGLE HTTP REQUEST
                    // axios.get('/featured').then(function (response) {
                    //     console.log(response.data);
                    //     app.featured = response.data.featured;
                    //     app.loading = false;
                    // });

                },


                //REDUCING THE LENGTH OF THE NAME FUNCTION
                stringLimit: function (string, value) {
                    return ARTISAOSTORE.module.truncateString(string, value);

                },

                addToCart : function (id){
                    ARTISAOSTORE.module.addItemToCart(id, function (message) {
                        $('.notify').css('display', 'block').delay(4000).slideUp(300).html(message);
                    });

                },

                //LOAD MORE PRODUCTS FUNCTION
                loadMoreProducts: function(){

                    this.loading = true;
                    var token = $('.display-products').data('token');

                    //ENCODE ALL DATA INTO PHP READABLE FORMATS WITH THE PARAM METHOD
                    var data = $.param({
                        next:2,
                        token:token,
                        count: app.count
                    });

                    //POST THE DATA WITH AXIOS
                    axios.post('/load-more', data).then(function (response) {
                        app.products = response.data.products;
                        app.count = response.data.count;
                        app.loading = false;
                    })
                }

            },

            created: function () {
                //CALL ANONYMOUS FUNCTION CREATED AT METHOD
                this.getFeaturedProducts();
            },

            mounted: function () {
                $(window).on('scroll', function () {
                    let scrollHeight = $(document).height() - 100;
                    let scrollPosition = $(window).height() + $(window).scrollTop();
                    //CHECK IF SCROLL POSITION IS GREATER THAN THE DOCUMENTS HEIGHT
                    if(scrollPosition > scrollHeight){
                        app.loadMoreProducts();
                    }

                })
            }

        });

    };



})();