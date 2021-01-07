(function () {
    'use strict';
    
    ARTISAOSTORE.product.locateMap = function () {
        var app = new Vue({
            el: '#map',
            data: {
                locationDetails: [],
                inputs: '',
                lat: [],
                lng: [],
                productId : $('.map-location').data('id'),
                product: [],
                country: ''
            },
            methods: {

                getProductDetails : function () {
                    // console.log($('.map-location').data('id'));
                    setTimeout(function () {
                        axios.get('/product-location/' + app.productId).then(function (response) {
                            app.product = response.data.product;
                            app.country = app.product.user.country_name + ' ' + app.product.user.city;
                            // console.log(app.country);
                            app.getLocationDetails(app.country );

                        }).catch(function (error) {
                            console.log(error);
                        });
                    }, 1000);

                },

                // getLocation: function(){
                //     axios.get('/product/get-location').then(function (response) {
                //         // console.log(response.data.location);
                //         app.getLocationDetails(response.data.location);
                //     }).catch(function (error) {
                //         console.log(error);
                //     });
                //
                //
                //
                // },

                getLocationDetails: function (location) {
                    // console.log(location);
                    axios.get('https://maps.googleapis.com/maps/api/geocode/json', {params: {
                        address: location,
                            key: 'AIzaSyDFmK9Qc-RqsPgD4A3R8WU-0AtvyvlViSs'
                        } }).then(function (response) {
                        // console.log(response.data.results[0].geometry.location);

                        // console.log(response.data);

                        app.lat = response.data.results[0].geometry.location.lat;
                        app.lng = response.data.results[0].geometry.location.lng;
                        app.loadMap(app.lat, app.lng);

                    }).catch(function (error) {
                        console.log(error);
                    })
                },

                loadMap: function (lat, lng) {
                    setTimeout(function () {
                        var cordinates = {lat: lat, lng: lng};
                        var options = {zoom: 8, center: cordinates};
                        var map = new google.maps.Map(document.getElementById('map-frame'), options );
                        var marker = new google.maps.Marker({position: cordinates, map: map});
                    },500);

                }


            },

            created: function () {
                this.getProductDetails();
                // this.getLocation();


            }


        });
    }
    
    
    
})();