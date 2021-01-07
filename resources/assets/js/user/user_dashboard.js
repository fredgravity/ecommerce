(function () {
    'use strict';

    ARTISAOSTORE.user.user_dashboard = function () {
        charts();
        setInterval(charts, 7000);


    };

    function charts() {
        var revenueCanvas = $('#monthly-revenue');
        var orderCanvas = $('#monthly-order');

        //CREATE LABELS FOR THE CHART
        var revenueLabelDate = [];
        var orderLabelDate = [];
        var orderCount = [];
        var revenueSummed = [];


        axios.get('/user/charts').then(function (response) {

            //GET DATA FROM ORDERS LOOP THROUGH THEM AND ADD TO THE ORDER COUNT ARRAY AND GET THE DATE FOR THE LABEL
            response.data.orders.forEach(function (monthly) {
                orderCount.push(monthly.count);
                orderLabelDate.push(monthly.new_date);
                // console.log(orderCount);
            });

            //GET DATA FROM REVENUE, LOOP THROUGH THEM AND ADD TO THE REVENUE SUM ARRAY AND GET THE DATE FOR THE LABEL
            response.data.revenues.forEach(function (monthly) {
                revenueSummed.push(monthly.amount);
                revenueLabelDate.push(monthly.new_date);
                // console.log(revenueSummed);
            });


            //CALL THE CHART JS CLASS
            new Chart(revenueCanvas, {
                type: 'bar',
                data: {
                    labels: revenueLabelDate,
                    datasets: [
                        {
                            label: '# Revenue',
                            data: revenueSummed,
                            backgroundColor: [
                                '#0578F1',
                                '#FF0000',
                                '#800000',
                                '#FFFF00',
                                '#808000',
                                '#00FF00',
                                '#008000',
                                '#00FFFF',
                                '#008080',
                                '#0000FF',
                                '#000080',
                                '#FF00FF',
                                '#800080'
                            ]
                        }
                    ]
                }
            });


            new Chart(orderCanvas, {
                type: 'line',
                data: {
                    labels: orderLabelDate,
                    datasets: [
                        {
                            label: '# Orders',
                            data: orderCount,
                            backgroundColor: ['#0578F1']
                        }
                    ]
                }
            });


        });




    }








})();