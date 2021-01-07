(function () {
    'use strict';

    ARTISAOSTORE.product.details = function () {
        let app = new Vue({
            el: '#product',

            data: {
                product : [],
                category : [],
                subCategory : [],
                similarProducts : [],
                comments: [],
                rating: '',
                productId : $('#product').data('id'),
                loading : false
            },

            methods : {
                getProductDetails : function () {
                    this.loading = true;
                   setTimeout(function () {
                       axios.get('/product-details/' + app.productId).then(function (response) {
                           app.product = response.data.product;
                           app.category = response.data.category;
                           app.subCategory = response.data.subCategory;
                           app.similarProducts = response.data.similarProducts;
                           app.comments = response.data.comments;
                           app.rating = response.data.rating;
                           console.log(app.comments);
                           app.loading = false;
                       }).catch(function (error) {
                           console.log(error);
                       });
                   }, 1000);

                },

                //REDUCING THE LENGTH OF THE NAME FUNCTION
                stringLimit: function (string, value) {
                    return ARTISAOSTORE.module.truncateString(string, value);
                },

                addToCart : function (id){
                    ARTISAOSTORE.module.addItemToCart(id, function (message) {
                        $('.notify').css('display', 'block').delay(2000).slideUp(300).html(message);
                    });

                },

                reveal: function () {

                    $('#number-reveal-btn').delay(500).slideUp(300);
                    setTimeout(function () {
                        $('#number-reveal').css('display', 'block');
                    }, 600);

                },

                contactModal: function () {

                  $('.contact-seller-modal').foundation('open').on('click', '#order-now', function () {
                      alert('Please are you sure you want to order for this product?');
                  });

                },

                contactModalNo: function () {

                    $('.contact-seller-modal-no').foundation('open')
                },

                postcomment: function (vendorId) {
                    let comment = $('#comment').val();
                    let token = $('#comment').data('token');
                    let postData = $.param({ vendorId: vendorId, comment:comment, token:token, productId:app.productId });
// alert('hi');
                    axios.post('/product/comment', postData).then(function (res) {
                        let message = res.data.res;
                        let failed = res.data.resFailed;
                        // console.log(res.data);
                        if (message){
                            $('.notify').css('display', 'block').delay(2000).slideUp(300).html(message);
                            app.comments = res.data.comments;
                        }else{
                            $('.notify').css('display', 'block').delay(2000).slideUp(300).html(failed);
                        }

                    }).catch(function (error) {
                        console.log(error);
                    });

                    $('#comment').val('');

                }

            },

            created : function () {
                this.getProductDetails();
            }

        });


    }
})();