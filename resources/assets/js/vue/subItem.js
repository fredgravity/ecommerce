(function () {
    'use strict';

    ARTISAOSTORE.nav.subItem = function () {
        var app = new Vue({
            el: '#root',
            data: {
                featured: [],
                subItems: [],
                id: [],
                count: 0,
                loading: false
            },
            methods: {
                getSubItemID: function(){
                    let url = window.location.pathname;
                    this.id = url.substring(url.lastIndexOf('/') + 1);
                },

                //GET FEATURED PRODUCTS FUNCTION
                getFeaturedProducts: function () {

                    this.loading = true;// TURN ON SPINNING
                    var postData = $.param({id: this.id});

                    //PROCESS MULTI HTTP REQUEST
                    axios.all([

                        axios.get('/featured'),
                        axios.post('/get-subitems', postData)

                    ]).then(axios.spread(function (featuredResponse, subitemResponse) {
                        //GET THE ECHOED JSON RESPONSE FROM INDEX CONTROLLER
                        app.featured = featuredResponse.data.featured;
                        app.subItems = subitemResponse.data.subItems;
                        app.count = subitemResponse.data.count;
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

                addToCart: function (id) {
                    ARTISAOSTORE.module.addItemToCart(id, function (message) {
                        $('.notify').css('display', 'block').delay(4000).slideUp(300).html(message);
                    });

                },

                //LOAD MORE PRODUCTS FUNCTION
                loadMoreProducts: function () {
                    this.loading = true;

                    let token = $('.display-product-search').data('token');

                    //ENCODE ALL DATA INTO PHP READABLE FORMATS WITH THE PARAM METHOD
                    let data = $.param({
                        next: 2,
                        token: token,
                        count: app.count,
                        id: this.id
                    });

                    //POST THE DATA WITH AXIOS
                    axios.post('/load-more-subItems', data).then(function (response) {
                        app.subItems = response.data.subItems;
                        app.count = response.data.count;
                        app.loading = false;
                    })
                }

            },

            created: function () {
                //CALL ANONYMOUS FUNCTION CREATED AT METHOD
                this.getSubItemID();
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