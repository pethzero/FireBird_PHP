<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
  session_start();
  //  echo $_SESSION["RECNO"];
  if (!isset($_SESSION["RECNO"])) {
    header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
  }
  include("0_headcss.php");
  // $csrfToken = bin2hex(random_bytes(32)); // สร้าง token สุ่ม
  // $_SESSION['csrf_token'] = $csrfToken;
  // $_SESSION['csrf_token'] = keyse();
  ?>
    <title>Getting Started with Chart JS with www.chartjs3.com</title>
    <style>
      /* * {
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
        background: rgba(54, 162, 235, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .chartBox {
        width: 700px;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(54, 162, 235, 1);
        background: white;
      } */
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
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script> -->
    <?php include("0_footerjs.php"); ?>
    <script>
    // setup 
    const data = {
      labels: ['TOP1', 'TOP2', 'TOP3', 'TOP4', 'TOP5', 'TOP6', 'TOP7', 'TOP8', 'TOP9', 'TOP10', 'TOP11', 'TOP12', 'TOP13', 'TOP14'
      , 'TOP15', 'TOP16', 'TOP17', 'TOP18', 'TOP19', 'TOP20'],      
        datasets: [{
        label: 'Get',
        data: [18, 12, 6, 9, 12, 3, 9,18, 12, 6, 9, 12, 3, 9,18, 12, 6, 9, 12, 3],
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

    const moveChart = {
      id:'moveChart',
      afterDraw(chart,args,pluginOptions){
        const {ctx,chartArea:{left,right,top,bottm,width,height}} = chart;


        class CircleChevron{
          
        }
        const angle = Math.PI / 180;

        ctx.beginPath();
        ctx.lineWidth = 3;
        ctx.strokeStyle = 'rgba(102,102,102,0.5)';
        ctx.fillStyle = 'white';
        ctx.arc(left,height / 2 + top,15,angle*0,angle*360,false);
        ctx.stroke();
        ctx.fill();
        ctx.closePath();
        // console.log(chart);

        // chevron Arrow Left
        ctx.beginPath();
        ctx.lineWidth = 3;
        ctx.strokeStyle = 'rgba(225,26,104,1)';
        ctx.moveTo(left + 5,height / 2 + top - 7.5);
        ctx.lineTo(left - 5,height / 2 + top);
        ctx.lineTo(left + 5,height / 2 + top + 7.5);
        ctx.stroke();
        ctx.fill();
        ctx.closePath();
      }
    }

    // config 
    const config = {
      type: 'bar',
      data,
      options: {
        scales: {
          x:{
            min:0,
            max:6
          },
          y: {
            beginAtZero: true
          }
        }
      },
      plugins:[moveChart]
    };

    // render init block
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );

    // Instantly assign Chart.js version
    const chartVersion = document.getElementById('chartVersion');
    chartVersion.innerText = Chart.version;
    </script>

  </body>
</html>