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
  // $csrfToken = bin2hex(random_bytes(32)); // สร้าง token สุ่ม
  // $_SESSION['csrf_token'] = $csrfToken;
  // $_SESSION['csrf_token'] = keyse();
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

      <!-- <button id="randomDataButton">สุ่มข้อมูล</button> -->

      <h2>ใบสั่งซื้อ</h2>

      <hr>
      <h2>อันดับลูกค้า ใบสั่งซื้อ</h2>
      <div class="row">
        <div class="col-12">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ลูกค้า</th>
                <th>รหัส</th>
                <th>จำนวน</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>

      <hr>
      <div class="chartCard">
        <div class="chartBox">
          <canvas id="myChart"></canvas>
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

    var recno = null;
    // var qid = 'COUNT_QUOTHD0';
    var qid = 'COUNT_PURCHD0';
    
    var startd = null;
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;
    var datasave = '';

    // var encodedURL_Select = encodeURIComponent('ajax_select_sql_mysql.php');
    var encodedURL_Select = encodeURIComponent('ajax_select_sql_firdbird.php');

    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    // var encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');

    function secertkey() {
      return encodeData;
    }

    var data_array = [];
    var startingValue = 1;
    var encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      ajax: {
        url: encodedURL,
        data: function(d) {
          d.queryId = qid; // ส่งค่าเป็นพารามิเตอร์ queryId
          d.params = null;
          d.condition = '';
          // d.sqlprotect = encodeData;
        },
        dataSrc: function(json) {
          tablejsondata = json.data;
          // console.log(tablejsondata)
          return json.data;
        }
      },
      scrollX: true,
      columns: [
        {
          data: null,
          render: function(data, type, row, meta) {
            return meta.row+1;
          }
        },
        {
          data: 'SUPPOMERNAME',
          render: function(data, type, row) {
            return data
          }
        },
        {
          data: 'CODE',
          render: function(data, type, row) {
            return data
          }
        },
        {
          data: 'QUAN',
          render: function(data, type, row) {
            return data
          }
        },
      ],
      columnDefs: [{
          className: 'dt-right',
          targets: [2]
        },
        // {
        //   searchable: false,
        //   orderable: false,
        //   targets: 0
        // }
      ],
      order: [
        [3, 'desc'],
      ],
      dom: 'frtip',
      initComplete: function(settings, json) {
        // $('.loading').hide();
        console.log('ww')
        datachart(tablejsondata)
      },
      createdRow: function(row, data, dataIndex) {

      },
      drawCallback: function(settings) {

      },
      rowCallback: function(row, data) {

      },
    });

    var topCode = [];

    function datachart(data) {
      console.log(data)
      var tophigh_QUAN = data
        .map(function(item) {
          return {
            CODE: item.CODE + ':' + item.SUPPOMERNAME,
            QUAN: item.QUAN
          };
        })
        .sort(function(a, b) {
          return b.QUAN - a.QUAN;
        })
        .slice(0, 10)
        .reduce(function(obj, item) {
          obj[item.CODE] = item.QUAN;
          return obj;
        }, {});

      // const topData = Object.values(tophigh_QUAN);
      topCode = Object.keys(tophigh_QUAN);

      console.log(topCode)

      const topDataset = {
        label: 'ยอดขาย TOP 10',
        data: Object.values(tophigh_QUAN),
        backgroundColor: 'rgba(0, 153, 51,0.6)',
        borderColor: 'rgba(0, 153, 51,1)',
        borderWidth: 1,
        fill: true
        // categoryPercentage: 1,
        // barPercentage: 0.8
      };

      // ปรับปรุงข้อมูลใหม่ใน data.datasets[0].data
      // data.datasets[0].data = topDataset;
      myChart.data.datasets = [topDataset];

      // สร้างกราฟใหม่
      myChart.update();
    }


    $('#seacrh').click(function() {
      var dateValue = $('#date_search').val();

      if (dateValue) {
        startd = moment($('#date_search').val(), 'DD/MM/YYYY').format('DD/MM/YYYY')
      } else {
        startd = '';
      }

      console.log(startd)


      $('#table_datahd').DataTable().column(6).search(startd).draw();
      $('#table_datahd').DataTable().column(3).search($('#statusseacrh').val()).draw();
    })


    const data = {
      labels: ['TOP1', 'TOP2', 'TOP3', 'TOP4', 'TOP5', 'TOP6', 'TOP7', 'TOP8', 'TOP9', 'TOP10'],
      datasets: [{
        label: 'ยอดขาย TOP 10',
        data: Array(10).fill(null), // กำหนดข้อมูลเริ่มต้นให้เป็น null ในอาร์เรย์ขนาด 10 ตัว
        backgroundColor: [
          'rgba(0, 153, 51,0.6)',
        ],
        borderColor: [
          'rgba(0, 153, 51,1)'
        ],
        borderWidth: 2
      }]
    };




    const config = {
      // type: 'bar',
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
                size: window.innerWidth <= 768 ? 14 : 16, // ขนาดตัวอักษรของหัวข้อแกน Y
                weight: 'bold' // ความหนาของตัวอักษรของหัวข้อแกน Y
              }
            },
            ticks: {
              font: {
                size: window.innerWidth <= 768 ? 12 : 14, // ขนาดตัวอักษรของตัวเลขบนแกน Y
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
                    label += topCode[context.dataIndex] + ':' + context.parsed.y;
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
    if (window.innerWidth <= 768) {
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