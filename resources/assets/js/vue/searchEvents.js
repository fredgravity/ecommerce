
(function () {

    'use strict';

    ARTISAOSTORE.home.changeSearchEvent = function () {
        $('#search-category').on('change', function () {
            let category_id = $('#search-category'+ ' option:selected').val();
            $('#search-subCategory').html('Select Subcategory');
// alert(category_id);
            $.ajax({

                type: 'get',
                url:'/get-subcategories/'+ category_id,
                data:{category_id:category_id},

                success:function(response) {
                    var subcategories = jQuery.parseJSON(response);
                    // console.log(subcategories);
                    if(subcategories.length){
                        $.each(subcategories, function (key, value) {

                            $('#search-subCategory').append('<option value="'+value.id +'">'+ value.name+'</option>');
                        })

                    }else{
                        $('#search-subCategory').append('<option value="">Product has no subcategory</option>');
                    }
                }

            });


        })
    }

})();