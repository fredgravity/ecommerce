(function () {
    'use strict';

    ARTISAOSTORE.module = {
        truncateString : function truncate(string, value) {
            if(string.length > value){
                return string.substring(0, value) + '...';
            }else{
                return string;
            }
        },

        addItemToCart : function (id, callback) {

            var token = $('.display-products').data('token'); //TOKEN FROM HOME PAGE

            if(!token || token === null){
                token = $('.product').data('token'); //TOKEN FROM PRODUCT PAGE
            }

            // axios.get('/cart' ,{param:{product_id: id, token: token}});

            var postData = $.param({product_id: id, token: token});
            axios.post('/cart', postData).then(function (response) {
                callback(response.data.success); //RETURN MESSAGE TO THE FUNCTION THAT CALLED IT
            })


        }

    }
})();