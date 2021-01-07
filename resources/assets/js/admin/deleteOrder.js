
(function () {
    'use strict';
    ARTISAOSTORE.admin.deleteOrder = function () {

        $('table[data-form=deleteOrder]').on('click', '.delete-order', function (e) {
            e.preventDefault();

            let form = $(this);


            $('#confirm').foundation('open').on('click', '#delete-btn', function () {
                form.submit();
            })

        })

    }

})();