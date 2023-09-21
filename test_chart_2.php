<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  session_start();
  //  echo $_SESSION["RECNO"];
  if (!isset($_SESSION["RECNO"])) {
    header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
  }
  include("0_headcss.php");
  ?>
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
</head>

<body>
  <?php
  include("0_header.php");
  // include("0_breadcrumb.php");
  ?>
  <link rel="stylesheet" href="css/mycustomize.css">
  <style>
    .c_activity {
      width: 100px;
    }

    .h_textarea {
      height: 110px;
    }

    textarea {
      overflow-y: scroll;
    }

    .datepicker td,
    th {
      text-align: center;
      padding: 8px 12px;
      font-size: 14px;
    }

    .datepicker {
      border: 1px solid black;
    }
  </style>

  <?php
  // include("connect_sql.php");
  ?>

  <section>
    <div class="container-fluid pt-3">

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>

      <button id="randomDataButton">สุ่มข้อมูล</button>

      <div class="chartCard">
        <div class="chartBox">
          <canvas id="myChart"></canvas>
        </div>
      </div>


      <div class="chartCard">
        <div class="chartBox">
          <canvas id="myChart_Doughnut"></canvas>
        </div>
      </div>


    </div>
  </section>




  <hr>
  <footer class="text-center mt-auto">
    <div class="container pt-2">
      <div class="row">
        <div class="col-12">
          <p>Copyright ? SAN Co.,Ltd. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>
  <?php
  //  include("0_footer.php");
  ?>
  <form id="idForm" method="POST">

  </form>


</body>
<?php include("0_footerjs.php"); ?>
<!-- <script src="js/dtcolumn.js"></script> -->

<script>
  $(document).ready(function() {

    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });


    // สร้างฟังก์ชั่นสำหรับสุ่มข้อมูลใหม่
    function randomizeData() {
      // สุ่มค่าใหม่ในช่วง 0-200 และปรับปรุงข้อมูลใหม่ใน data.datasets[0].data
      const newData1 = data.datasets[0].data.map(() => Math.floor(Math.random() * 200));
      data.datasets[0].data = newData1;

      const newData2 = data.datasets[1].data.map(() => Math.floor(Math.random() * 200));
      data.datasets[1].data = newData2;


      // สร้างอาเรย์ของชื่อที่คุณมีอยู่ (เป็นตัวอย่าง)
      const randomNames = ["Alice", "Bob", "Charlie", "David", "Eva", "Frank", "Grace", "Hank", "Ivy", "Jack"];

      // สร้าง labels ใหม่โดยสุ่มชื่อจากอาเรย์ของชื่อ
      const newLabels = Array.from({
        length: 10
      }, () => {
        const randomIndex = Math.floor(Math.random() * randomNames.length);
        return randomNames[randomIndex];
      });

      // กำหนด labels ใหม่ในตัวแปร data
      data.labels = newLabels;

      // สร้างกราฟใหม่
      myChart.update();
    }



    // เพิ่ม Event Listener สำหรับปุ่ม RANDOM
    $('#randomDataButton').click(function() {
      // ให้การสุ่มข้อมูลและอัปเดตกราฟเริ่มทำงานทันทีเมื่อคลิกปุ่ม
      randomizeData();

      // จัดตั้งการเรียกใช้ฟังก์ชัน randomizeData() ทุก 1 วินาที
      // setInterval(randomizeData, 1000);
      // setInterval(randomizeData, 3000);
    });

    // const data = {
    //   labels: ['TOP1', 'TOP2', 'TOP3', 'TOP4', 'TOP5', 'TOP6', 'TOP7', 'TOP8', 'TOP9', 'TOP10'],
    //   // labels:Array(10).fill(null),
    //   datasets: [{
    //     label: 'ยอดขาย TOP 10',
    //     data: Array(10).fill(null), // กำหนดข้อมูลเริ่มต้นให้เป็น null ในอาร์เรย์ขนาด 10 ตัว
    //     backgroundColor: [
    //       'rgba(0, 153, 51,0.6)',
    //     ],
    //     borderColor: [
    //       'rgba(0, 153, 51,1)'
    //     ],
    //     borderWidth: 2
    //   }]
    // };

    const data = {
      labels: ['TOP1', 'TOP2', 'TOP3', 'TOP4', 'TOP5', 'TOP6', 'TOP7', 'TOP8', 'TOP9', 'TOP10'],
      datasets: [{
          label: 'ชุดข้อมูลที่ 1',
          data: Array(10).fill(null),
          backgroundColor: 'rgba(0, 153, 51, 0.6)',
          borderColor: 'rgba(0, 153, 51, 1)',
          borderWidth: 2
        },
        {
          label: 'ชุดข้อมูลที่ 2',
          data: Array(10).fill(null),
          backgroundColor: 'rgba(255, 0, 0, 0.6)',
          borderColor: 'rgba(255, 0, 0, 1)',
          borderWidth: 2
        }
      ]
    };

    const config = {
      // type: 'doughnut',
      type: 'bar',
      data,
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'จำนวนการขาย',
              font: {
                size: window.innerWidth <= 600 ? 14 : 16, // ขนาดตัวอักษรของหัวข้อแกน Y
                weight: 'bold' // ความหนาของตัวอักษรของหัวข้อแกน Y
              }
            },
            ticks: {
              font: {
                size: window.innerWidth <= 600 ? 12 : 14, // ขนาดตัวอักษรของตัวเลขบนแกน Y
                weight: 'normal' // ความหนาของตัวเลขบนแกน Y
              }
            }
          }
        },
        plugins: {
          title: {
            display: true,
            text: 'ยอดขาย TOP 10', // ข้อความหัวเรื่อง
            font: {
              size: 20, // ขนาดตัวอักษร
              weight: 'bold' // ความหนา
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = '';
                if (context.parsed.y !== null) {
                  if (context.datasetIndex === 0) {
                    label += 'ชุดข้อมูลที่ 1: ' + context.parsed.y;
                  } else if (context.datasetIndex === 1) {
                    label += 'ชุดข้อมูลที่ 2: ' + context.parsed.y;
                  }
                }
                return label;
              }
            }
          }
        },
      }
    };

    // render init block
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );

    // $("#myChart").css("height", 800);
    if (window.innerWidth <= 600) {
      // ถ้าความกว้างของหน้าจอน้อยกว่าหรือเท่ากับ 600px (สำหรับโทรศัพท์)
      $("#myChart").css("height", "400px");
    } else {
      // ถ้าความกว้างของหน้าจอมากกว่า 600px (สำหรับคอมพิวเตอร์ PC)
      $("#myChart").css("height", "800px");
    }


    ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////
    //  $('html, body').animate({
    //       scrollTop: $('#dataoffset').offset().top
    //   }, 100); // ค่าความเร็วในการเลื่อน (มิลลิวินาที)

    $('#backhis').click(function() {
      window.location = 'main.php';
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////


  });
</script>

</html>