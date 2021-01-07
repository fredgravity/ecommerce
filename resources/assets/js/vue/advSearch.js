(function () {
    'use strict';

    ARTISAOSTORE.home.advSearch = function () {

        let app = new Vue({
            el: '#root-advSearch',
            data: {
                featured: [],
                products: [],
                count: 0,
                loading: false,
                categoryItems: false,
                show: false
            },

            methods:{

                testing:function(){
                    // alert('hi');

                },

                stringLimit: function (string, value) {
                    return ARTISAOSTORE.module.truncateString(string, value);

                },


                advanceSearch: function () {
                    this.loading = true;
                    let token = $('.display-product-search').data('token');
                    let search = $('#search').val();
                    let searchCat = $('#search-category').val();
                    let searchSubCat = $('#search-subCategory').val();
                    let searchMin = $('#min').val();
                    let searchMax = $('#max').val();
                    let searchCountry = $('#country').val();

                    // console.log(search + ' '+ searchCat + ' ' +searchSubCat+' '+searchMin+' '+searchMax+' '+searchCountry);


                    //ENCODE ALL DATA INTO PHP READABLE FORMATS WITH THE PARAM METHOD
                    let data = $.param({
                        next: 2,
                        token: token,
                        count: app.count,
                        search: search,
                        category: searchCat,
                        subCategory: searchSubCat,
                        min: searchMin,
                        max: searchMax,
                        country: searchCountry
                    });

                    //POST THE DATA WITH AXIOS
                    axios.post('/advance-search-loadmore', data).then(function (response) {
                        app.products = response.data.results;
                        console.log(app.products);

                        app.count = response.data.count;
                        console.log(app.count);
                        app.loading = false;
                        app.show = true;

                    })
                },


            },

            created:function () {
                this.testing();
            },

            mounted: function () {
                $(window).on('scroll', function () {
                    let scrollHeight = $(document).height() - 100;
                    let scrollPosition = $(window).height() + $(window).scrollTop();
                    //CHECK IF SCROLL POSITION IS GREATER THAN THE DOCUMENTS HEIGHT
                    if (scrollPosition > scrollHeight) {
                        app.advanceSearch();
                    }

                })
            }



        });
    }


})();