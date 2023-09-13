<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Getting Started with Chart JS with www.chartjs3.com</title>
    <style>
      /* CSS styles omitted for brevity */
    </style>
  </head>
  <body>
    <div class="chartMenu">
      <p>WWW.CHARTJS3.COM (Chart JS <span id="chartVersion"></span>)</p>
    </div>
    <div class="chartCard">
      <div class="chartBox">
        <canvas id="myChart"></canvas>
      </div>
    </div>
    <div class="buttons">
      <button id="generateDataButton" onclick="generateRandomData()">Generate Random Data</button>
    </div>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <script>
      // Setup
      let data = null; // Initialize data with null

      // Config
      const config = {
        type: 'bar',
        data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      };

      // Render init block
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );

      // Function to generate random data
      function generateRandomData()
      {
        // const labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const datasets = [{
          label: 'Month Sales',
          data: generateRandomNumbers(),
          backgroundColor: generateRandomColors(0.2),
          borderColor: generateRandomColors(1),
          borderWidth: 1
        }];

        data = {
          labels,
          datasets
        };

        myChart.data = data;
        myChart.update();
      }

      // Function to generate random numbers
      function generateRandomNumbers() {
        const randomData = [];
        // for (let i = 0; i < 7; i++) {
        for (let i = 0; i < 12; i++) {
          randomData.push(Math.floor(Math.random() * 1000000) + 1);
        }
        return randomData;
      }

      // Function to generate random colors
      function generateRandomColors(alpha) {
        const randomColors = [];
        for (let i = 0; i < 7; i++) {
        // for (let i = 0; i < 12; i++) {
          const red = Math.floor(Math.random() * 256);
          const green = Math.floor(Math.random() * 256);
          const blue = Math.floor(Math.random() * 256);
          randomColors.push(`rgba(${red}, ${green}, ${blue}, ${alpha})`);
        }
        return randomColors;
      }

      // Instantly assign Chart.js version
      const chartVersion = document.getElementById('chartVersion');
      chartVersion.innerText = Chart.version;
    </script>
  </body>
</html>
