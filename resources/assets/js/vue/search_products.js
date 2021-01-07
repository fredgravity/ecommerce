
(function () {
    'use strict';

    ARTISAOSTORE.home.searchPage = function () {
        let app = new Vue({
            el:'#root-search',
            data:{
                featured: [],
                products: [],
                count: 0,
                loading: false,
                categoryItems: false,
                show: false
            },
            methods: {
                //GET FEATURED PRODUCTS FUNCTION
                getProducts: function () {
                    this.loading = true;// TURN ON SPINNING

                    let word = $('.display-product-search').data('word');

                    let postData = $.param({
                        word: word,
                    });
                    //PROCESS MULTI HTTP REQUEST

                    axios.post('/show-search', postData).then(function (response) {
                        app.products = response.data.categoryItems;
                        app.count = response.data.count;
                        app.loading = false;
                        app.show = true;
                        // console.log(app.products);
                    })

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
                    let word = $('.display-product-search').data('word');


                    // alert(token +' '+ word);

                    //ENCODE ALL DATA INTO PHP READABLE FORMATS WITH THE PARAM METHOD
                    let data = $.param({
                        next: 2,
                        token: token,
                        word: word,
                        count: app.count
                    });

                    //POST THE DATA WITH AXIOS
                    axios.post('/product-search', data).then(function (response) {
                        app.products = response.data.categoryItems;
                        app.count = response.data.count;
                        app.loading = false;
                        // console.log(app.products);
                    })
                },
                },

                created: function () {
                    //CALL ANONYMOUS FUNCTION CREATED AT METHOD
                    this.getProducts();
                },

                mounted: function () {
                    $(window).on('scroll', function () {
                        let scrollHeight = $(document).height() - 100;
                        let scrollPosition = $(window).height() + $(window).scrollTop();
                        //CHECK IF SCROLL POSITION IS GREATER THAN THE DOCUMENTS HEIGHT
                        if (scrollPosition > scrollHeight) {
                            app.loadMoreProducts();
                        }

                    })
                }

        });





    };



})();