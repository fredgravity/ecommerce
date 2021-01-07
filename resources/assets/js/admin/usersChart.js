(function () {
   'use strict';

   ARTISAOSTORE.admin.usersChart = function () {
       chart();
       setInterval(chart, 10000);
   };

   function chart() {

       let subscribers = $('#total-subscribers');
       let users       = $('#total-users');
       let vendors     = $('#total-vendors');


       //CREATE LABELS FOR USERS CHART
       let subscriberDate = [];
       let subscriberCount = [];

       let userDate = [];
       let userCount = [];

       let vendorDate = [];
       let vendorCount = [];


       axios.get('/admin/userCharts').then(function (response) {

           //SUBSCRIBERS
           response.data.subscribers.forEach(function (monthly) {
               subscriberCount.push(monthly.count);
               subscriberDate.push(monthly.new_date);
           });

           //USERS
           response.data.users.forEach(function (monthly) {
               userCount.push(monthly.count);
               userDate.push(monthly.new_date);
           });

           //VENDORS
           response.data.vendors.forEach(function (monthly) {
               vendorCount.push(monthly.count);
               vendorDate.push(monthly.new_date);
           });


           //CALL THE CHART JS
           let mySubscriber = new Chart(subscribers, {
                type: 'bar',
               data: {
                    labels: subscriberDate,
                   datasets: [{
                        label: '# of Subscribers',
                       data: subscriberCount,
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
                   }]
               }
           });

           let myUsers = new Chart(users, {
               type: 'bar',
               data: {
                   labels: userDate,
                   datasets: [{
                       label: '# of Users',
                       data: userCount,
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
                   }]
               },
               options: {
                   animation: {
                       easing: 'easeInOutQuart',
                       duration: 1000
                   }
               }
           });


           let myVendors = new Chart(vendors, {
               type: 'bar',
               data: {
                   labels: vendorDate,
                   datasets: [{
                       label: '# of Vendors',
                       data: vendorCount,
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
                   }]
               }
           });


       }).catch(function (error) {
           console.log(error);
       });



   }

})();