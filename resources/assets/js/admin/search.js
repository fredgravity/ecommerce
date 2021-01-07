(function () {
    'use strict';
    
    ARTISAOSTORE.admin.search = function () {

       let app = new Vue({
           el: "#vendor-search",

           data: {
               searchUsers: [],
               message: '',
               loading: false,
               showSearch: false,
               checked: '',


           },

           methods: {
               search: function () {
                   app.loading = true;
                   let search = $('#searchVendorField').val();
                   let token = $('#searchVendorField').data('token');
// alert(search +' '+token);
                   let postData = $.param({search:search, token:token, role:'vendor'});

                   axios.post('/admin/vendorVerify/search', postData).then(function (response) {
                       app.searchUsers = response.data.search;
                       console.log(app.searchUsers);
                       app.showSearch = true;
                       app.loading = false;
                       app.getCheckedboxValue();
                   });


               },

               approved: function (e) {
                   console.log(e);
                   let token = $('#checkbox'+e).data('token');

                    if ($('#checkbox'+e).is(':checked')){
                        let postData = $.param({check:'true' ,token:token, user:e });
                        axios.post('/admin/vendorVerify/approval', postData).then(function (res) {

                            $('.notify').css('display', 'block').delay(2000).slideUp(300).html(res.data.msg);

                        })
                    } else{
                        let postData = $.param({check:'false' ,token:token, user:e });
                        axios.post('/admin/vendorVerify/approval', postData).then(function (res) {

                            $('.notify').css('display', 'block').delay(2000).slideUp(300).html(res.data.msg);

                        })
                    }

               },

               getCheckedboxValue: function () {
                   setTimeout(function () {
                       axios.get('/admin/vendorVerify/getCheckboxStatus').then(function (res) {
                           console.log(res.data);
                            res.data.user.forEach(function (ary) {
                                console.log(ary);
                                $('#checkbox'+ary).prop('checked', true);
                            })

                       })
                   }, 1000);

               }
           },

           created: function () {
                this.getCheckedboxValue();
           }
       });


    };
    
})();