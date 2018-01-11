var xhr;
reload = function () {
    $("#grid").datagrid("reload");
};
delete_rows = function () {
    var rows = $("#grid").datagrid("getChecked");
    if (rows.length <= 0) {
        alert("Pilih Data Untuk Dihapus");
        return;
    }
    var ids = "";
    for (var i in rows) {
        console.log(rows[i]);
        if (ids != "") {
            ids += "," + rows[i].id;
        } else {
            ids = rows[i].id;
        }
    }
    xhr = $.ajax({
        url: 'php_script/delete_polling.php',
        data: {ids: ids},
        type: 'post',
        dataType: 'json',
        success: function (result) {
            console.log(result);
            $("#grid").datagrid("reload")
        }
    });
};
styler_polling = function (value, row, index) {
    value = parseInt(value, 10);

    if (value === 1) {
        return 'background-color:green;color:white;';
    }
    if (value === 2) {
        return 'background-color:yellow;color:black;';
    }
    if (value == 3) {
        return 'background-color:red;color:white;';
    }
    return 'background-color:blue;color:red;';
};
format_polling = function (val, row) {
    // console.log(val);
    //console.log(row);
    val = parseInt(val, 10);
    if (val === 1) {
        return "Sangat Puas";
    }
    if (val === 2) {
        return "Puas";
    }
    if (val === 3) {
        return "Tidak Puas";
    }
    return "";
};
var myChart;
init_chart = function () {
//    var canvas = document.getElementById('myChart');
//    var data = {
//        labels: ["January", "February", "March", "April", "May", "June", "July"],
//        datasets: [
//            {
//                label: "My First dataset",
//                fill: false,
//                lineTension: 0.1,
//                backgroundColor: "rgba(75,192,192,0.4)",
//                borderColor: "rgba(75,192,192,1)",
//                borderCapStyle: 'butt',
//                borderDash: [],
//                borderDashOffset: 0.0,
//                borderJoinStyle: 'miter',
//                pointBorderColor: "rgba(75,192,192,1)",
//                pointBackgroundColor: "#fff",
//                pointBorderWidth: 1,
//                pointHoverRadius: 5,
//                pointHoverBackgroundColor: "rgba(75,192,192,1)",
//                pointHoverBorderColor: "rgba(220,220,220,1)",
//                pointHoverBorderWidth: 2,
//                pointRadius: 5,
//                pointHitRadius: 10,
//                data: [65, 59, 80, 0, 56, 55, 40],
//            }
//        ]
//    };
//
//    function adddata() {
//        myLineChart.data.datasets[0].data[7] = 60;
//        myLineChart.data.labels[7] = "Newly Added";
//        myLineChart.update();
//    }
//
//    var option = {
//        showLines: true,
//        responsive: true,
//        maintainAspectRatio: false,
//        scales: {
//            yAxes: [{
//                    ticks: {
//                        beginAtZero: true
//                    }
//                }]
//        }
//    };
//    var myLineChart = Chart.Line(canvas, {
//        data: data,
//        options: option
//    });

    var ctx = document.getElementById("myChart").getContext('2d');
    myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Sangat Puas - 0%", "Puas - 0%", "Tidak Puas - 0%"],
            datasets: [{
                    label: '# of Votes',
                    data: [0, 0, 0],
                    backgroundColor: [
                        'rgba(0, 255, 0, 0.2)',
                        'rgba(255, 255, 0, 0.2)',
                        'rgba(255, 0,0, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
    update_chart();
};
var xhrUpdate;
update_chart = function () {
    if (xhrUpdate)
        xhrUpdate.abort();
    xhrUpdate = $.ajax({
        url: "php_script/load_data.php",
        type: 'post',
        dataType: 'json',
        success: function (result) {
            var index = 0;
            var total = parseInt(result.total, 10);
            for (var i in result.rows) {
                var row = result.rows[i];
                try {
                    var jumlah = parseInt(row['jumlah']);
                    var persen = 0;
                    if (jumlah > 0) {
                        persen = (jumlah / total) * 100;
                    }
                    if (parseInt(row['polling'], 10) === 1) {
                        myChart.data.labels[0] = "Sangat Puas - " + parseInt(persen, 10) + "%";
                        myChart.data.datasets[0].data[0] = row['jumlah'];
                    }
                    if (parseInt(row['polling'], 10) === 2) {
                        myChart.data.labels[1] = "Puas - " + parseInt(persen, 10) + "%";
                        myChart.data.datasets[0].data[1] = row['jumlah'];
                    }
                    if (parseInt(row['polling'], 10) === 3) {
                        myChart.data.labels[2] = "Tidak Puas - " + parseInt(persen, 10) + "%";
                        myChart.data.datasets[0].data[2] = row['jumlah'];
                    }

                } catch (e) {
                }
                index++;
            }
            myChart.update();
        }
    });

    $("#grid").datagrid("reload");
    setTimeout(function () {
        update_chart();
    }, 3000);
};
$(function () {
    init_chart();
});