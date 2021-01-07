
(function () {

    // 'use strict';

    ARTISAOSTORE.admin.changeEvent = function () {
        $('#product-category').on('change', function () {
            let category_id = $('#product-category'+ ' option:selected').val();
            $('#product-subcategory').html('Select Subcategory');
// alert('hi');
            $.ajax({

                type: 'get',
                url:'/admin/category/'+ category_id +'/selected',
                data:{category_id:category_id},

                success: function(response) {
                    let subcategories = $.parseJSON(response);

                    if(subcategories.length){
                        $.each(subcategories, function (key, value) {
                            $('#product-subcategory').append('<option value="'+value.id +'">'+ value.name+'</option>');
                        })

                    }else{
                        $('#product-subcategory').append('<option value="">Product has no subcategory</option>');
                    }
                }

            });


        })
    }

})();