(function () {
    'use strict';

    ARTISAOSTORE.admin.editOrder = function () {
        let app = new Vue({
            el: "#edit-orderDetails",
            data:{
                selected: '',
                totalUpdate: ''
            },

            methods: {
                updateQty: function () {
                    alert('am here');
                    this.totalUpdate = this.selected * 10;
                }

            },

            created: function () {
                // this.updateQty();
            }
        });

    }


})();