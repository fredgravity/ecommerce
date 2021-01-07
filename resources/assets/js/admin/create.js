(function () {
    'use strict';
    
    ARTISAOSTORE.admin.create = function () {

        //CREATE PRODUCT SUBCATEGORY
        $(".add-subcategory").on('click', function (e) {

            var token        = $(this).data('token');
            var category_id  = $(this).attr('id');
            var name         = $('#subcategory-name-' + category_id).val();

            // alert(name + ' and : ' + category_id + ' and : ' + token);

            $.ajax({
                type:'POST',
                url:'/admin/product/subcategory/create',
                data: {
                    token:token,
                    name:name,
                    category_id:category_id
                },
                success:function (result) {
                    var response = jQuery.parseJSON(result);
                    $('.notification').css('display', 'block').delay(4000).slideUp(300).html(response.success);
                },
                error:function (request, error) {
                    //CHANGE JSON RESPONSE OBJ TO TEXT
                    var errors = jQuery.parseJSON(request.responseText);
                    var ul = document.createElement('ul');

                    //DO A JQUERY FOREACH LOOP AND CREATE A LISTED ITEM AND APPEND TO UL
                    $.each(errors, function (key, value) {
                        //CREATE AN LI TAG
                        var li = document.createElement('li');
                        //CREATE A TEXT FROM THE VALUE AND INSERT INTO LI
                        li.appendChild(document.createTextNode(value));
                        //INSERT THE LI INTO THE UL
                        ul.appendChild(li);
                    });

                    $('.notification').css('display', 'block').removeClass('primary').addClass('alert').delay(6000).slideUp(300).html(ul);
                }
            });

            e.preventDefault();
        })

    };
    
})();