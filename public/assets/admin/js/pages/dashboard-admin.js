$(function () {
    'use strict'

    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')

    var donutData = {
        labels: [],
        datasets: []
    }

    var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: true,
            position: 'bottom'
        }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: {
            labels: ['data'],
            datasets: [{
                data: [1],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12'],
            }]
        },
        options: donutOptions
    })



    var ctx_live = document.getElementById("visitors-chart");

    const option = {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
            mode: 'index',
            intersect: true,
            callbacks: {
                title: function (tooltipItems, data) {
                    return '';
                }
            }

        },
        hover: {
            mode: 'index',
            intersect: true
        },

        legend: {
            display: true,
            position: 'bottom'
        },
        scales: {
            yAxes: [{
                gridLines: {
                    display: true,
                    lineWidth: '4px',
                    color: 'rgba(0, 0, 0, .2)',
                    zeroLineColor: 'transparent'
                },
                ticks: $.extend({
                    beginAtZero: true,
                    // suggestedMax: 30
                }, {
                    fontColor: '#495057',
                    fontStyle: 'bold'
                })
            }],
            xAxes: [{
                display: true,
                gridLines: {
                    display: false
                },
                ticks: {
                    fontColor: '#495057',
                    fontStyle: 'bold'
                }
            }]
        }
    }

    var myChart = new Chart(ctx_live, {
        type: 'bar',
        data: {
            labels: [],
            datasets: []
        },
        options: option
    });

    function makeDrawChart(source) {
        // create initial empty chart
        myChart.data.labels.splice(0, myChart.data.labels.length);
        myChart.data.datasets = [];
        myChart.update();

        var cData = JSON.parse(source);
        const users = cData.latest.user;
        let userSessions = 0;

        for (var i = 0; i < cData.latest.day.length; i++) {
            userSessions += users[i];
            myChart.data.labels.push(cData.latest.day[i]);
        }

        const sessionsData = {
            type: 'line',
            label: 'Users',
            data: cData.latest.user,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            pointBorderColor: '#007bff',
            pointBackgroundColor: '#007bff',
            fill: false
        };



        myChart.data.datasets.push(sessionsData);

        myChart.update();
        $("#ga-visitors").text(userSessions);

    }

    function makeDonutChart(source) {

        donutChart.data.labels.splice(0, donutChart.data.labels.length);
        donutChart.data.datasets = [];
        donutChart.update();

        // create initial empty chart
        var cData = JSON.parse(source);
        const type = cData.user_type.type;
        let num = 0;

        for (var i = 0; i < cData.user_type.type.length; i++) {
            num += type[i];
            donutChart.data.labels.push(cData.user_type.type[i]);
        }

        const newData = {
            data: cData.user_type.user,
            backgroundColor: ['#21262d', '#dc3545', '#f39c12'],
        };

        donutChart.data.datasets.push(newData);
        donutChart.update();
    }

    $('.daterange').daterangepicker({
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [moment().subtract(1, 'days'), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 28 Days': [moment().subtract(28, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate: moment().subtract(29, 'days')
    }, function (start, end) {


        var data = {
            'startDate': start.format('MMMM D, YYYY'),
            'endDate': end.format('MMMM D, YYYY'),
        };

        data[csrfName] = $.cookie(csrfCookie);

        $.ajax({
            url: $('.daterange').attr('data-input-url'),
            type: 'post',
            data: data,
            beforeSend: function () {
                $("#loading-data").show();
            },
            complete: function () {
                $("#loading-data").hide();

            },
            success: function (response) {
                makeDrawChart(response);
                makeDonutChart(response)
            }
        });
    })

    $.get(baseUrl + "/common/getUsersRegister", function (data, status) {
        makeDrawChart(data)
        makeDonutChart(data)
    }).done(function () {
        $("#loading-data").hide();
    });

});