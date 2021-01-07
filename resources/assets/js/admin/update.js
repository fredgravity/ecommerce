(function () {
    'use strict';
    
    ARTISAOSTORE.admin.update = function () {

        //UPDATE PRODUCT CATEGORY
        $(".update-category").on('click', function (e) {

            var token = $(this).data('token');
            var id = $(this).attr('id');
            var name = $('#item-name-'+id).val();

            // alert(name + ' and : ' + id + ' and : ' + token);

            $.ajax({
                type:'POST',
                url:'/admin/product/categories/' + id + '/edit',
                data: {
                    token:token,
                    name:name
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
        });

        //UPDATE PRODUCT SUBCATEGORY
        $(".update-subcategory").on('click', function (e) {

            var token = $(this).data('token');
            var id = $(this).attr('id');
            var category_id = $(this).data('category-id');
            var name = $('#item-subcategory-name-'+id).val();
            var selected_category_id = $('#item-category-'+ category_id + ' option:selected' ).val();

            // alert(name + ' and : ' + id + ' and : ' + token);
            alert(category_id+' '+selected_category_id);

            //CHECK IF THE SELECTED CATEGORY IS DIFFERENT FROM THE CATEGORY ID THEN USE THE SELECTED ID
            if(category_id !== selected_category_id){
                category_id = selected_category_id;
            }

            $.ajax({
                type:'POST',
                url:'/admin/product/subcategory/' + id + '/edit',
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
        });

    };
    
})();