<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="assets/js/color-modes.js"></script>
  <?php
  session_start();
  if (!isset($_SESSION["RECNO"])) {
    header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
  }
  include("0_headcss.php");
  ?>
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

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
    @media (min-width: 768px) {
            .custom-input-pc {
                width: 450px;
            }

            .btn-input {
                width: 120px;
            }
            .date-input {
                width: 140px;
            }
        }

        @media (max-width: 767px) {
            .custom-input-phone {
                width: 300px;
            }
            .company-input {
                width: 250px;
            }

            .detail-input {
                width: 300px;
            }

            .remark-input {
                width: 200px;
            }

            .date-input {
                width: 120px;
            }
        }

        .table-custom {
            --bs-table-color: #000;
            --bs-table-bg: #4caf50;
            --bs-table-border-color: #bacbe6;
        }

        .table-postpone {
            --bs-table-color: #000;
            --bs-table-bg: #ff980099;
            --bs-table-border-color: #bacbe6;
        }

        .bg-postpone {
            background-color: #ff6600;
        }

        .dataTables_paginate {
    float: right;
    margin: 0;
}

  </style>
  <link href="dashboard.css" rel="stylesheet">
</head>

<body>
  <?php include("0_dbheader.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <!-- SIDE -->
      <?php include("0_sidebar.php"); ?>
      <!-- CONTENT -->
      <div class="loading" style="display: none;"></div>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <form id="idForm" method="POST">
       
  <section>

      <!-- <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>

   

      <h2>ใบเสนอราคา</h2> -->

      <!-- <hr> -->
  <div class="row pt-2 mb-2">
  <div class="col-md-12">
    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">

        
        <h2>อันดับลูกค้า ใบเสนอราคา</h2>

        <div class="row pt-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="input-group input-daterange">
            <span class="input-group-text">เริ่มต้น</span>
            <input type="text" class="form-control" id="datepickerbegin">
            <span class="input-group-text">จนถึง</span>
            <input type="text" class="form-control" id="datepickerend">
          </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <span id="excelmessage"></span>
          </div>
      </div>

      <div class="row pt-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id="refresh" type="button" class="btn btn-primary">ค้นหา</button>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id="refreshall" type="button" class="btn btn-primary">ค้นหาทั้งหมด</button>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
        <button id='backhis' type="button" class="btn btn-success">กลับหน้าหลัก</button>
        </div>
      </div>

      <div class="row pt-3">
      <div class="col-sm-12 col-md-12 col-lg-12">
      <div class="chartCard">
        <div class="chartBox">
          <canvas id="myChart"></canvas>
        </div>
      </div>
     </div> 
      </div> 



      <div class="row pt-3">
        <div class="col-sm-12 col-md-12 col-lg-12 table-responsive">
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


        </div>
    </div>
  </div>
</div>


      <!-- <h3>ค้นหา</h3> -->
      <!-- <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="input-group input-daterange">
            <span class="input-group-text">เริ่มต้น</span>
            <input type="text" class="form-control" id="datepickerbegin">
            <span class="input-group-text">จนถึง</span>
            <input type="text" class="form-control" id="datepickerend">
          </div>
        </div>
      </div> -->

      <!-- <div class="row pb-1">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id="refresh" type="button" class="btn btn-primary">ค้นหา</button>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id="refreshall" type="button" class="btn btn-primary">ค้นหาทั้งหมด</button>
        </div>
      </div>

      <span id="excelmessage"></span> -->

      <!-- <div class="chartCard">
        <div class="chartBox">
          <canvas id="myChart"></canvas>
        </div>
      </div>
      <hr> -->

      <!-- <h2>อันดับลูกค้า ใบเสนอราคา</h2> -->
      <!-- <div class="row">
        <div class="col-12 table-responsive">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle table-responsive" width='100%'>
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
      </div> -->

 

  </section>

        </form>
      </main>
    </div>
  </div>
</body>
<?php include("0_footerjs_piority.php"); ?>
<script>
  $(document).ready(function() {

    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });
  
    var qid = 'COUNT_QUOTHD0';
    var condotion_id = 'NULL';
    var startd = null;
    var tablejsondata;
    var datasave = '';


    $("#datepickerbegin").datepicker({
      format: "dd/mm/yyyy",
      todayHighlight: true,
      autoclose: true,
      clearBtn: true
    });

    $("#datepickerend").datepicker({
      format: "dd/mm/yyyy",
      todayHighlight: true,
      autoclose: true,
      clearBtn: true
    });

    // หาวันที่ 1 ของเดือนนี้
    var firstDayOfMonth = moment().startOf('month').format('DD/MM/YYYY');
    // หาวันสุดท้ายของเดือนนี้
    var lastDayOfMonth = moment().endOf('month').format('DD/MM/YYYY');

    moment($('#datepickerbegin').val(firstDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')
    moment($('#datepickerend').val(lastDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')

    var databegin = moment().startOf('month').format('DD.MM.YYYY');
    var dateend = moment().endOf('month').format('DD.MM.YYYY');


    $('#excelmessage').html("<h3> ข้อมูลทั้งหมด ณ ปัจจุบัน</h3>")

    function secertkey() {
      return encodeData;
    }

    var tabledatahd = $('#table_datahd').DataTable({
      scrollX: true,
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + 1;
          }
        },
        {
          data: 'CUSTOMERNAME',
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
          targets: [2,3]
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
    });

    var Param;
    $('#refresh').click(function() {
      const result = checkdate();
      if (result.status) {
        $('.loading').show();
        qid = 'COUNT_QUOTHD_DATEBE';
        condotion_id = 'DATEBE';
        fecth_databased(result.databegin, result.dateend);
      }
      $('#excelmessage').html("<h3>ข้อมูลโหลด ณ วันที่ " + moment(result.databegin, 'DD/MM/YYYY').format('DD/MM/YYYY') + " ถึง " + moment(result.dateend, 'DD/MM/YYYY').format('DD/MM/YYYY') + "</h3>")
    });

    $('#refreshall').click(function() {
      const result = checkdate();
      if (result.status) {
        $('.loading').show();
        qid = 'COUNT_QUOTHD0';
        condotion_id = 'NULL';
        fecth_databased(result.databegin, result.dateend);
      }
      $('#excelmessage').html("<h3>ข้อมูลทั้งหมด ณ ปัจจุบัน</h3>")
    });

    const checkdate = () => {
      const beginDateInput = $('#datepickerbegin').val();
      const endDateInput = $('#datepickerend').val();
      const result = {
        status: false,
        databegin: '',
        dateend: ''
      };
      if (beginDateInput === '' || endDateInput === '') {
        Swal.fire(
          'มีการป้อนวันที่ผิดพลาด',
          'ไม่สามารถประมวลผลได้',
          'error'
        );
        return result;
      }
      const beginDate = moment(beginDateInput, 'DD/MM/YYYY');
      const endDate = moment(endDateInput, 'DD/MM/YYYY');

      if (endDate.isBefore(beginDate)) 
      {
        Swal.fire(
          'มีการป้อนวันที่ผิดพลาด',
          'ไม่สามารถประมวลผลได้',
          'error'
        );
        return result;
      }
      result.status = true;
      result.databegin = beginDate.format('DD.MM.YYYY');
      result.dateend = endDate.format('DD.MM.YYYY');
      return result;
    };


    fecth_databased('', '');
    async function fecth_databased(data_begin, date_end) {
      Param = [];
      Param.push({
        datebegin: data_begin,
        dateend: date_end
      })
      console.log(Param)
      var formData = new FormData();
      try {
        // ดึงข้อมูล Excel จากเซิร์ฟเวอร์
        const jsonResponse = await fetch('ajax/post_fb_select_qt.php', {
          method: 'POST',
          body: set_formdata('select'),
        });

        if (!jsonResponse.ok) {
          $('.loading').hide();
          throw new Error('Error sending data to server');
        }

        const jsonDataQT = await jsonResponse.json();
        await tabledatahd.clear().rows.add(jsonDataQT.datasql).draw();
        await datachart(jsonDataQT.datasql);

        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }

    function set_formdata(conditionsformdata) {
      var formData = new FormData();
      // Param.push({})
      if (conditionsformdata == "select") {
        formData.append('queryIdHD', qid);
        formData.append('condition', condotion_id);
      } else {

      }
      formData.append('Param', JSON.stringify(Param));
      ////////////////
      return formData;
    }

    $('#idForm').on('submit', function(e) {
      e.preventDefault(); // ป้องกันการส่ง form ไปยังหน้าอื่น
      // ตรวจสอบว่าปุ่มที่ถูกคลิกคือ "save" หรือ "edit"
      let url = "";
      let status_sql = "";
      var clickedButtonName = e.originalEvent.submitter.name;
    });



    var topCode = [];
    var chartdatabase;

    function datachart(data) {
      chartdatabase = data
        .map(function(item) {
          return {
            NAME: item.CUSTOMERNAME,
            CODE: item.CODE,
            QUAN: item.QUAN
          };
        })
        .sort(function(a, b) {
          return b.QUAN - a.QUAN;
        })
        .slice(0, 10)
      const dbase_dataset = chartdatabase.map(function(item) {
        return item.QUAN;
      });

      const topDataset = {
        label: 'ยอดขาย TOP 10',
        data: dbase_dataset,
        backgroundColor: 'rgba(0, 153, 51,0.5)',
        borderColor: 'rgba(0, 153, 51,1)',
        borderWidth: 1,
        fill: true
        // categoryPercentage: 1,
        // barPercentage: 0.8
      };
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
          'rgba(0, 153, 51,0.2)',
        ],
        borderColor: [
          'rgba(0, 153, 51,1)'
        ],
        borderWidth: 2
      }]
    };


    const config = {
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
                size: window.innerWidth <= 768 ? 14 : 16,
                weight: 'bold'
              }
            },
            ticks: {
              font: {
                size: window.innerWidth <= 768 ? 12 : 14,
                weight: 'normal'
              }
            }
          }
        },
        plugins: {
          title: {
            display: true,
            text: 'ยอดขาย TOP 10',
            font: {
              size: 20,
              weight: 'bold'
            }
          },
          tooltip: {
            titleFont: {
              size: window.innerWidth <= 768 ? 16 : 25,
            },
            bodyFont: {
              size: window.innerWidth <= 768 ? 14 : 20,
            },
            callbacks: {
              title: function(tooltipItem) {
                return 'ลูกค้าอันดับ: ' + tooltipItem[0].label;
              },
              label: function(context) {
                let label = '';
                if (context.parsed.y !== null) {
                  if (context.datasetIndex === 0) {
                    label += chartdatabase[context.dataIndex].CODE + ':' + chartdatabase[context.dataIndex].NAME + ':' + context.parsed.y;
                  }
                }
                return label;
              }
            }
          },
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
      $("#myChart").css("height", "300px");
    } else {
      // ถ้าความกว้างของหน้าจอมากกว่า 600px (สำหรับคอมพิวเตอร์ PC)
      $("#myChart").css("height", "620px");
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