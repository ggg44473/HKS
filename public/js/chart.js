$('.historybtn').click(function (e) {

    var oid = $(this).attr("data-oid");
    var speedCanvas = document.getElementById("speedChart"+oid);

    console.log(speedCanvas);

    // 個人新增便簽
    var evts = [];
    var datum = [];
    $.ajax({
        url: '/objective/' + oid + '/getArray',
        type: "GET",
        dataType: "JSON",
        async: false
    }).done(function (r) {
        evts = r;
    })

    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 18;

    evts.forEach(function (item, index, array) {
        var dataFirst = {
            label: "No." + item['kr_id'],
            data: item['accomplish'],
            lineTension: 0.5,
            fill: false,
            borderColor: item['kr_color'],
            backgroundColor: item['kr_color'],
            pointBorderColor: item['kr_color'],
            pointBackgroundColor: 'lightyellow',
            pointRadius: 5,
            pointHoverRadius: 15,
            pointHitRadius: 30,
            pointBorderWidth: 2,
            pointStyle: 'rect'
        };
        datum.push(dataFirst);
    });

    var speedData = {
        labels: evts[0]['update'],
        datasets: datum
    };

    var chartOptions = {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: false
                }
            }]
        },
        legend: {
            display: false,
            position: 'top',
            labels: {
                boxWidth: 40,
                fontColor: 'black'

            }
        }
    };

    var lineChart = new Chart(speedCanvas, {
        type: 'line',
        data: speedData,
        options: chartOptions,
        responsive: true
    });
});