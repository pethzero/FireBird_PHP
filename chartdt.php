<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <?php include("0_headcss.php"); ?>
  </head>
  <body>
 <style>
    body {  
  padding: 16px;
    }

    canvas {
    border: 1px dotted red;
    }

    .chart-container {
    /* position: relative; */
    /* margin: auto; */
    height: 100vh;
    width: 200vw;
    overflow-x: scroll;
    }

</style>
  <?php 
    // session_start(); 
    // if (!isset($_SESSION["RECNO"])) 
    //   {
    //     header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    //     exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
    //   } 
    //   include("0_header.php"); 
    //   include("0_breadcrumb.php"); 
  ?>

    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-12">
            <h3 class="text-center">จำนวน STOCK</h3>
            <!-- <canvas id="myChart"></canvas> -->
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>

          </div>
        </div>
      </div>
    </div>

    
    <hr>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-12">
            <h3 class="text-center">&nbsp;</h3>
          </div>
          <div class="col-md-4 col-12">
            <h3 class="text-center">SAN Co.,Ltd.</h3>
            <address class="text-center">
            </address>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <?php include("0_footer.php"); ?>
  </body>
  <?php include("0_footerjs.php"); ?>
  <script>
    $(document).ready(function() 
    {
// สร้างตัวแปรสำหรับแผนภูมิและการตั้งค่า
  
 
  Chart.defaults.font.size = 18;
  var ctx = document.getElementById('myChart').getContext('2d');


  var topDataset = {
    label: 'จำนวนสินค้าสูงสุด',
    data: [65, 59, 20, 81, 56, 55, 40,95,30,79],
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderColor: 'rgba(75, 192, 192, 1)',
    borderWidth: 1,
    fill: true
    // categoryPercentage: 1,
    // barPercentage: 0.8
  };

  var lowDataset = {
    label: 'จำนวนสินค้าต่ำสุด',
    data: [65, 59, 20, 81, 56, 55, 40,95,30,200000],
    backgroundColor: 'rgba(192, 75, 75, 0.2)',
    borderColor: 'rgba(192, 75, 75, 1)',
    borderWidth: 1,
    fill: true
    // categoryPercentage: 1,
    // barPercentage: 0.8
  };

  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['TOP1', 'TOP2', 'TOP3', 'TOP4', 'TOP5','TOP6', 'TOP7', 'TOP8', 'TOP9', 'TOP10'],
      datasets: [topDataset, lowDataset],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
        tooltip: {
          callbacks: {
            label: function(context) {
              let label = '';
              if (context.parsed.y !== null) {
                if (context.datasetIndex === 0) {
                  // Dataset 1 (topDataset)
                  label += context.dataIndex + ':' + context.parsed.y;
                } else if (context.datasetIndex === 1) {
                  // Dataset 2 (lowDataset)
                  label += context.dataIndex + ':' + context.parsed.y;
                }
              }
              return label;
            }
          }
        }
      }
    }
  });
});
    
  


    </script>
</html>