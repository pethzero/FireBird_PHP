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


      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="input-group input-daterange">
            <span class="input-group-text">เริ่มต้น</span>
            <input type="text" class="form-control" id="datepickerbegin">
            <span class="input-group-text">จนถึง</span>
            <input type="text" class="form-control" id="datepickerend">
          </div>
        </div>
      </div>

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id="refresh" type="button" class="btn btn-primary">ค้นหา</button>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id="refreshall" type="button" class="btn btn-primary">ค้นหาทั้งหมด</button>
        </div>
      </div>



      <h2>ใบเสนอราคา</h2>

      <hr>
      <h2>อันดับลูกค้า ใบเสนอราคา</h2>
      <div class="row">
        <div class="col-12">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ว.ด.ป.</th>
                <th>INV. No.</th>
                <th>ใบสั่งซื้อ</th>
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
  <div class="loading" style="display: none;"></div>

</body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
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
    var qid = 'QOUT_SUM_0';
    // var qid = null;
    var startd = null;

    var tablejsondata;
    var selectedRow = null;

    var selectedRecno = null;
    var datasave = '';


    // var encodedURL_Select = encodeURIComponent('ajax_select_sql_mysql.php');
    var encodedURL_Select = encodeURIComponent('ajax_select_sql_firdbird.php');


    // นำเข้า Moment.js
    // var moment = require('moment');

    // หาวันที่ 1 ของเดือนนี้
    var firstDayOfMonth = moment().startOf('month').format('DD/MM/YYYY');
    // หาวันสุดท้ายของเดือนนี้
    var lastDayOfMonth = moment().endOf('month').format('DD/MM/YYYY');

    // แสดงผลลัพธ์
    // console.log("วันที่ 1 ของเดือนนี้: " + firstDayOfMonth);
    // console.log("วันสุดท้ายของเดือนนี้: " + lastDayOfMonth);


    // $("#datepickerbegin").val(firstDayOfMonth)
    moment($('#datepickerbegin').val(firstDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')
    moment($('#datepickerend').val(lastDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')

    var databegin = moment().startOf('month').format('DD.MM.YYYY');
    var dateend = moment().endOf('month').format('DD.MM.YYYY');

    // console.log(databegin)
    // var databegin = '01.09.2023';
    // var dateend = '30.09.2023';
    // console.log(databegin)

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
          d.params = {
            ABEGIN: databegin,
            AEND: dateend
          };
          d.condition = 'mix';
          // d.sqlprotect = encodeData;
        },
        dataSrc: function(json) {
          // console.log(json)
          tablejsondata = json.data;
          // console.log(tablejsondata)
          return json.data;
        }
      },
      scrollX: true,
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + 1;
          }
        },
        {
          data: 'DOCDATE',
          render: function(data, type, row) {
            return data
          }
        },
        {
          data: 'DOCNO',
          render: function(data, type, row) {
            return data
          }
        },
        {
          data: 'ORDERHD',
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
        // datachart(tablejsondata)
        $('.loading').hide();
        // console.log('get')
      },
      createdRow: function(row, data, dataIndex) {

      },
      drawCallback: function(settings) {
        // console.log('wow')
      },
      rowCallback: function(row, data) {

      },
    });

    $('#refreshall').click(function() {
          $('.loading').show();
        qid = 'QOUT_SUM_ALL'
        databegin = '00.00.0000'
        dateend = '00.000.0000'
        table.ajax.reload( myCallback);
    });

    $('#refresh').click(function() {
      // รับค่าวันที่จาก input fields
      // let dateValuebegin = $('#datepickerbegin').val();
      // let dateValueend = $('#datepickerend').val();

      // console.log(dateValuebegin)
      // console.log(dateValueend)

      // แปลงค่าวันที่เป็น Date objects โดยใช้ Moment.js
      let beginDate = moment($('#datepickerbegin').val(), 'DD/MM/YYYY');
      let endDate = moment($('#datepickerend').val(), 'DD/MM/YYYY');
      console.log(beginDate)
      console.log(endDate)

      if ($('#datepickerbegin').val() !== '' && $('#datepickerend').val() !== '') {
        // console.log("all");
        // $('.loading').show();
        // qid = 'QOUT_SUM_ALL'
        // databegin = '00.00.0000'
        // dateend = '00.000.0000'
        // table.ajax.reload( myCallback);
        console.log("ประมวลผลได้");
        if (endDate.isBefore(beginDate)) {
          Swal.fire(
            'มีการป้อนวันที่ผิดพลาด',
            'ไม่สามารถประมวลผลได้',
            'error'
          )
        } else if (endDate.isSame(beginDate)) {
          // ถ้า endDate เท่ากับ beginDate
          $('.loading').show();
          qid = 'QOUT_SUM_0'
          databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          table.ajax.reload(myCallback);
        } else {
          // ถ้า endDate มากกว่า beginDate
          $('.loading').show();
          qid = 'QOUT_SUM_0'
          databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          table.ajax.reload(myCallback);
        }
      } else {
        Swal.fire(
          'มีการป้อนวันที่ผิดพลาด',
          'ไม่สามารถประมวลผลได้',
          'error'
        )
      }
    });

    var myCallback = function() {
      // console.log('wiw')
      $('.loading').hide();
    };

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