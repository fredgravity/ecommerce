
(function () {

    'use strict';
    ARTISAOSTORE.user.deleteOrder = function () {

        $('table[data-form=deleteOrder]').on('click', '.delete-order', function (e) {
            e.preventDefault();
// alert('hi');
            let form = $(this);


            $('#confirm').foundation('open').on('click', '#delete-btn', function () {
                form.submit();
            })

        });

        $('table[data-table=delete-user-order]').on('click', '.delete-order' ,function (e) {
            e.preventDefault();
           alert('hi');

            $('#confirm').foundation('open').on('click', '#delete-btn', function () {
                form.submit();
            })

        })

    }

})();