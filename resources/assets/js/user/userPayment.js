(function () {
    'use strict';

    ARTISAOSTORE.user.payment = function () {
        chart();
        setInterval(chart, 7000);

        let app = new Vue({
            el: '#userPayment',

            data: {
                convertAmt: '',
                amountGHC: $('#userPayment-cedis').val()

            },

            methods: {
                convert: function () {
                    let GHC = this.amountGHC;
                    let converter = 'USD';
                    // alert(GHC);
                    let postData = $.param({convert:converter, amount:GHC});
                    axios.post('/user/payment/converter', postData).then(function (response) {
                        app.convertAmt = response.data.rate;


                    }).catch(function (error) {
                        console.log(error);
                    })

                },

                convertThis: function (currency) {
                    let GHC = this.amountGHC;
                    // alert(GHC);
                    let postData = $.param({convert:currency, amount:GHC});
                    axios.post('/user/payment/converter', postData).then(function (response) {
                        app.convertAmt = response.data.rate;


                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            },

            created: function () {
                this.convert();
            }
        });



    };






    function chart() {
        //TOTAL PAYMENT CHARTS
        const paymentCanvas = $("#totalUserPayments");

        //CREATE LABELS FOR THE PAYMENT CHART
        let amount = [];
        let date = [];

        axios.get('/user/payments/chart').then(function (response) {
            response.data.payments.forEach(function (monthly) {
                amount.push(monthly.amount);
                date.push(monthly.new_date);

                new Chart( paymentCanvas,{
                    type: 'line',
                    data: {
                        labels: date,
                        datasets: [ {
                            label: '# of Payments',
                            data: amount,
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
                        } ]
                    }
                });

            });

        }).catch(function (error) {
            console.log(error);
        });



    }


})();