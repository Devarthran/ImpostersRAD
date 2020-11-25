<?php include_once 'includes/header.inc.php';?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<canvas id="top10Chart"></canvas>

<script>
var ctx = document.getElementById('top10Chart').getContext('2d');
var ratingsChart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: titles,
        datasets: [{
            label: 'Stars',
            backgroundColor: 'rgb(230, 168, 23)',
            borderColor: 'rgb(255, 255, 255)',
            data: ratings,
        }]
    },

    // Configuration options go here
    options: {
        legend: {
            align: 'start',
            position: 'top',
            labels: {
                fontSize: 20
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
// empty variables
var titles = [];
var ratings = [];

var getData = function() {
    $.ajax({
        type: 'GET',
        url: 'Includes/chartData.inc.php',
        dataType: 'json',
        success: function(data) {
            
            ratingsChart.data.labels = data.titles;
            ratingsChart.data.datasets[0].data = data.ratings;
            // console.log(data.titles);
            // ratingsChart.data.labels.push(data.titles);
            // ratingsChart.data.datasets[0].data.push(data.ratings);

            ratingsChart.update();
        },
        error: function(xhr) {
            console.log('ERROR BLOCK');
            console.log(xhr.status + '' + xhr.statusText);
        }
    });
}

setInterval(getData, 3000);
</script>

<?php 
    include_once 'includes/footer.inc.php';
?>