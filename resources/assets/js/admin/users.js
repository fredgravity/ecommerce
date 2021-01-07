(function () {
    'use strict';

    ARTISAOSTORE.admin.searchUser = function () {
        let app = new Vue({
            el: "#user-search",
            data:{
                searchUsers: [],
                message: '',
                loading: false,
                showSearch: false,



            },

            methods: {

                confirmDelete: function(){

                    $('table[data-form=userDelete]').on('click','.delete-user' ,function (e) {
                            e.preventDefault();

                            let form = $(this);

                    $('#confirm').foundation('open').on('click', '#delete-btn', function () {
                        form.submit();
                    });

                    });
                },

                search_user: function () {
                    app.loading = true;
                    let search = $('#searchUserField').val();
                    let token = $('#searchUserField').data('token');

                    let postData = $.param({search:search, token:token, role:'user'});

                    axios.post('/admin/user/search', postData).then(function (response) {
                        app.searchUsers = response.data.search;
                        // console.log(app.searchUsers);
                        app.showSearch = true;
                        app.loading = false;
                    });


                },

                search_vendor: function () {
                    app.loading = true;
                    let search = $('#searchUserField').val();
                    let token = $('#searchUserField').data('token');

                    let postData = $.param({search:search, token:token, role:'vendor'});

                    axios.post('/admin/user/search', postData).then(function (response) {
                        app.searchUsers = response.data.search;
                        // console.log(app.searchUsers);
                        app.showSearch = true;
                        app.loading = false;
                    });


                },


            },

            created: function () {

            }
        });

    }


})();