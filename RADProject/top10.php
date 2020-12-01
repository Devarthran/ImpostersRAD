<?php include_once 'includes/header.inc.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<canvas id="top10Chart" title="Top 10 chart of highest ranked movies"></canvas>

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

    function getData() {
        $.ajax({
            type: 'GET',
            url: 'Includes/chartData.inc.php',
            dataType: 'json',
            success: function(data) {

                titles = data.titles;
                ratings = data.ratings;

                ratingsChart.data.labels = titles;
                ratingsChart.data.datasets[0].data = ratings;

                ratingsChart.update();
            },
            error: function(xhr) {
                console.log('ERROR BLOCK');
                console.log(xhr.status + '' + xhr.statusText);
            }
        });
    }



    setInterval(i => getData(), 1500);
</script>

<?php
include_once 'includes/footer.inc.php';
?>