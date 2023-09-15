<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  session_start();
  if (!isset($_SESSION["RECNO"])) {
    header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
  }
  include("0_headcss.php");
  ?>
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <!--
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/bootstrap-5.3.0.min.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/mypcu.css"> 
    -->
</head>

<body>
  <style>
    .btn-custom {
      background: linear-gradient(to right, #e8e8e8, #f1f1f1);
      color: #000000;
    }

    .card-img-top {
      height: 200px;
      /* Adjust the height to your desired value */
      object-fit: cover;
      /* This ensures the image fills the entire space while maintaining aspect ratio */
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
  include("0_header.php");
  // include("0_breadcrumb.php"); 
  ?>


  <div class="section">
    <div class="container-fluid">

      <div class="row pt-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>

      <div class="row  pt-3">
        <h1>ดาวโหลดส่วนเสริม</h1>
      </div>

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="input-group input-daterange">
            <span class="input-group-text">เริ่มต้น</span>
            <input type="text" class="form-control" id="datepickerbegin" >
            <span class="input-group-text">จนถึง</span>
            <input type="text" class="form-control" id="datepickerend" >
          </div>
        </div>
      </div>

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <select id='slcdata' class="form-select" aria-label="Default select example">
            <option value="0" selected>ใบเสนอราคา</option>
            <option value="1">ใบสั่งขาย</option>
            <option value="2">ใบส่งของสินค้า</option>
            <option value="3">ใบแจ้งหนี้</option>
          </select>
        </div>
      </div>

      <div class="row pt-3">
        <div class="col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-success" id="downloadExcel">download excel</button>
        </div>
      </div>

    </div>
    <div class="loading" style="display: none;"></div>
  </div>

  <?php include("0_footer.php"); ?>
</body>
<?php
include("0_footerjs.php");
?>


<script>
  $(document).ready(function() {
    // $("#downloadExcel").click(function() {
    //     window.location.href = "export/excel_export_sql.php"; // ระบุ URL ของไฟล์ PHP ที่คุณต้องการให้ดาวน์โหลด
    // });

    // หาวันที่ 1 ของเดือนนี้
    var firstDayOfMonth = moment().startOf('month').format('DD/MM/YYYY');
    // หาวันสุดท้ายของเดือนนี้
    var lastDayOfMonth = moment().endOf('month').format('DD/MM/YYYY');

    moment($('#datepickerbegin').val(firstDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')
    moment($('#datepickerend').val(lastDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')

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


    $("#downloadExcel").click(function() {
      // ข้อมูลที่ต้องการส่งไปยัง PHP
      // ส่งข้อมูลไปยัง PHP โดยใช้ AJAX

      let beginDate = moment($('#datepickerbegin').val(), 'DD/MM/YYYY');
      let endDate = moment($('#datepickerend').val(), 'DD/MM/YYYY');
      let slcdata = $('#slcdata').val()

      const array_data = [{
          name: "qout",
          queryid: "EXCEL_CUSTOMERSALE",

        },
        {
          name: "oreder",
          queryid: "EXCEL_QOUT_ORDERHD",
        },
        {
          name: "delivery",
          queryid: "EXCEL_QOUT_DELYHD",
        },
        {
          name: "invoice",
          queryid: "EXCEL_QOUT_INVOICE",
        }
      ];

      if ($('#datepickerbegin').val() !== '' && $('#datepickerend').val() !== '') {
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
          databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          download_excel(array_data[parseInt(slcdata)], databegin, dateend)
        } else {
          // ถ้า endDate มากกว่า beginDate
          $('.loading').show();
          databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          download_excel(array_data[parseInt(slcdata)], databegin, dateend)
        }
      } else {
        Swal.fire(
          'มีการป้อนวันที่ผิดพลาด',
          'ไม่สามารถประมวลผลได้',
          'error'
        )
      }

    });

    function download_excel(slcdata, databegin, dateend) {
      console.log(slcdata)
      $.ajax({
        type: "POST",
        url: "export/excelsql.php", // แก้ไขเป็น URL ของไฟล์ PHP ที่คุณสร้างขึ้น
        data: {
          data: 'Excel_' + slcdata.name,
          queryId: slcdata.queryid,
          params: {
            ABEGIN: databegin,
            AEND: dateend
          },
        },
        success: function(response) {
          data_json = JSON.parse(response).download;
          console.log(data_json)
          window.location.href = "uploads/" + data_json;
          $('.loading').hide();
        },
        error: function(error) {
          console.log(error)
          $('.loading').hide();
        }
      });
    }


    $('#backhis').click(function() {
      window.location = 'main.php';
    });


  });
</script>

</html>