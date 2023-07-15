<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Getting Started with Chart JS with www.chartjs3.com</title>
    <style>
      * {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
      }
      .chartMenu {
        width: 100vw;
        height: 40px;
        background: #1A1A1A;
        color: rgba(54, 162, 235, 1);
      }
      .chartMenu p {
        padding: 10px;
        font-size: 20px;
      }
      .chartCard {
        width: 100vw;
        height: calc(100vh - 40px);
        /* background: rgba(54, 162, 235, 0.2); */
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .chartBox {
        /* width: 700px; */
        width: 90%;
        height: 45%;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(54, 162, 235, 1);
        background: white;
      }
      @media only screen and (max-width: 600px)
      {  
        .chartBox{
          width: 90%;
          height: 75%;
        }
      }
      @media only screen and (max-width: 400px)
      {  
        .chartBox{
          width: 300px;
          height: 75%;
        }
      } 
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
    <script type="text/javascript" src="js/chart-4.3.0.js"></script>
    <script>
    // setup 
    const data = {
      labels: ['TOP1', 'TOP2', 'TOP3', 'TOP4', 'TOP5','TOP6', 'TOP7', 'TOP8', 'TOP9', 'TOP10'],
      datasets: [{
        label: 'Weekly Sales',
        data: [65, 59, -2000, 81, 56, 55, 40,95,30,200000],
        backgroundColor: [
          'rgba(255, 26, 104, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(0, 0, 0, 0.2)'
        ],
        borderColor: [
          'rgba(255, 26, 104, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(0, 0, 0, 1)'
        ],
        borderWidth: 1
      }]
    };

    // config 
    const config = {
      type: 'bar',
      data,
      options: {
        maintainAspectRatio:false,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    };

    // render init block
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );

    // Instantly assign Chart.js version
    // const chartVersion = document.getElementById('chartVersion');
    // chartVersion.innerText = Chart.version;

    </script>

  </body>
</html>