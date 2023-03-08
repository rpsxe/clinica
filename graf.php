    <canvas id="myChart" style="width: 300px;"></canvas>
    <script src="js/Chart.min.js"></script>
    <script>

      var ctx = document.getElementById('myChart').getContext('2d');
      var myPieChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Atendimentos', 'Presenças', 'Faltas', 'Faltas Justificadas', 'Profissional Ausente'],
          datasets: [{
            label: '',
            data: [<?php echo $numTotal; ?>, <?php echo $cont; ?>, <?php echo $falta; ?>, <?php echo $fj; ?>, <?php echo $nConta; ?>],
            backgroundColor: [
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
          }]
        },

      });
    </script>