(function () {

    'use strict';

    ARTISAOSTORE.admin.deleteUser = function () {
        $('table[data-form=userDelete]').on('click','.delete-user' ,function (e) {
            e.preventDefault();

            let form = $(this);

            $('#confirm').foundation('open').on('click', '#delete-btn', function () {
                form.submit();
            });
        })

    }

})();

