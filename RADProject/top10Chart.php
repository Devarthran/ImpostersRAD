<script type="text/javascript">

new Chart(document.getElementById("top10Chart"), {
    type: 'bar',
    data: {
      labels: ["<?php echo $movies; ?>"],
      datasets: [
        {
          label: "Movies",
          data: ["<?php echo $stats; ?>"]
        }
      ]
    },
    options: {
      legend: { display: true },
      title: {
        display: false,
        text: ''
      }
    }
});
</script>