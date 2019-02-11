$(function(){
    var keyValue = document.cookie.match('(^|;) ?' + "open" + '=([^;]*)(;|$)');
    var id = keyValue ? keyValue[2] : null;
    console.log();
    if(id.match('History')){
        var oid = $('#'+id).parents('.card-footer').find('.historybtn').attr("data-oid");
        openChart(oid);
    }
})

$('.historybtn').click(function (e) {
    var oid = $(this).attr("data-oid");
    openChart(oid);
});

function openChart(oid){
    var speedCanvas = document.getElementById("speedChart" + oid);

    // console.log(speedCanvas);

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

    if (evts.length != 0) {
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
    } else {
        console.log("ChartShow" + oid);
        document.getElementById("speedChart" + oid).style.display = "none";
        document.getElementById("ChartShow" + oid).style.display = "";
    }
}
