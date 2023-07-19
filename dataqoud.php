<!DOCTYPE html>
<html lang="en">

<head>
<?php
   session_start(); 
  //  echo $_SESSION["RECNO"];
    if (!isset($_SESSION["RECNO"])) 
    {
      header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
      exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
    } 
  include("0_headcss.php"); ?>
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
</head>

<body>
  <?php
    include("0_header.php"); 
    include("0_breadcrumb.php"); 
  ?>
  <style>
    .selected {
      background-color: #e6f0ff;
    }
  </style>


  <section>
    <div class="container pt-3">
      <h2>ข้อมูล</h2>
      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 ">

          <input type="radio" id="showAllBtn" name="fav_language" value="all" checked>
          <label for="showAllBtn">แสดงทั้งหมด</label>

          <input type="radio" id="showApprovedBtn" name="fav_language" value="approved">
          <label for="showApprovedBtn">ทำการอนุมัติแล้ว</label>

          <input type="radio" id="waitApprovedBtn" name="fav_language" value="wait">
          <label for="waitApprovedBtn">รอทำการอนุมัติ</label>

        </div>
      </div>

    <div class="row">
      <div class="col-sm-12 col-md-6 col-lg-6">
         <div class="mb-3">
          <label for="searchInput" class="form-label">ค้นหารหัสลูกค้า</label>
            <select  class="form-control select2" id="searchInput"> 
            <option value="">----</option>
            </select>
        </div>
      </div>
      <!-- <div class="col-sm-12 col-md-6 col-lg-6">
        Column
      </div> -->
      <!-- <div class="col-12-sm col-6-md col-6-lg">
        <div class="mb-3">
          <label for="searchInput" class="form-label">ค้นหารหัสลูกค้า</label>
            <select  class="form-control select2" id="searchInput"> 
            <option value="">----</option>
            </select>
        </div>
      </div>

      <div class="col-12-sm col-6-md col-6-lg">
        <div class="mb-3">
          <label for="searchInput" class="form-label">ค้นหารหัสลูกค้า</label>
            <select  class="form-control select2" id="searchInput"> 
            <option value="">----</option>
            </select>
        </div>
      </div> -->

    </div>


      <div class="row">
          <div class="col-12">
          <h1>ใบเสนอราคา</h1>
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle" width='100%'>
            <thead class="thead-light">
              <tr>
              <th>ลำดับ</th>
                <th>แสดงข้อมูล</th>
                <th>เลขที่ใบเสนอราคา</th>
                <th>สถานะ</th>
                <th>รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
                <th>วันที่เปิดใบเสนอราคา</th>
                <th>วันหมดอายุ</th>
                <th>ราคารวม Vat</th>
                <th>ผู้ขาย</th>
                <th>ผู้ทำเอกสาร</th>
                <th>ผู้อนุมัติ</th>
                <th>REMARK</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          </div>
      </div>
  
    </div>
  </section>


  <section>
    <div class="container pt-3">
      <div class="row">
          <div class="col-12">
          <h1>ข้อมูล</h1>
          <table id="table_datadt" class="nowrap table table-striped table-bordered align-middle" width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>รหัสสินค้า</th>
                <th>รายการ</th>
                <th>จำนวน</th>
                <th>หน่วย</th>
                <th>ราคาต่อหน่วย</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          </div>
      </div>
  


    </div>
  </section>

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
  <footer class="text-center">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <p>Copyright ? SAN Co.,Ltd. All rights reserved.</p>
        </div>
      </div>
    </div>
  </footer>


  <div class="modal fade" id="hq" tabindex="-1" aria-labelledby="hqLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-md modal-lg modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="hqLabel">Modal Title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <div class="row">
              <div class="col-12 pb-3">
                เลขที่ใบเสนอราคา: <span id="docNo"></span>
              </div>
              <div class="col-12 pb-3">
                ชื่อลูกค้า: <span id="name"></span>
              </div>
              <div class="col-12 pb-3">
                รหัสลูกค้า: <span id="code"></span>
              </div>
              <div class="col-12 pb-3">
                วันที่เปิดใบเสนอราคา: <span id="qdocDate"></span>
              </div>
              <div class="col-12 pb-3">
                ผู้เสนอขาย: <span id="saleName"></span>
              </div>
              <div class="col-12 pb-3">
                ผุ้ทำเอกสาร: <span id="makegeName"></span>
              </div>
              <div class="col-12 pb-3">
                ผู้อนุมัติ: <span id="approverName"></span>
              </div>
              <div class="col-12">
                <div class="d-flex align-items-center">
                  <span class="mr-2 mt-1">การอนุมัติ:</span>
                  <button class="btn btn-success btn-sm" id="approverBtn" disabled></button>
                </div>
              </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>
  </div>


  <!-- <button id="loadDataButton" class="btn btn-primary">โหลดข้อมูล</button> -->

  <div class="loading">
</body>
<?php include("0_footerjs.php"); ?>
<script src="js/dtcolumn.js"></script> 

<script>
  $(document).ready(function() {
    var selectedRow = null;
    var selectedRecno = null;

    var encodedURL = encodeURIComponent('ajax_data.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      ajax: {
        url: encodedURL,
        data: function(d) {
          d.queryId = '0001'; // ส่งค่าเป็นพารามิเตอร์ queryId
          d.params = null;
          // d.params = {
          //   // STATUS: 'C'
          // };
        },
        dataSrc: function(json) {
          console.log(json);
          return json.data;
        }
      },
      scrollX: true,
      columns:
       dtcolumn['dataquoud'],
      // [
      //   { data: 'RECNO' },
      //   { data: null,render: function(data, type, row) {
      //     // return '<button class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-row-id="' + row['RECNO'] + '">Show</button>';
      //     return `<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#hq" data-bs-row-id="${row['RECNO']}">Show</button>`;
      //   }},
      //   { data: 'QDOCNO' },
      //   { data: 'STATUS',render: getStatusText},
      //   { data: 'NAME' },
      //   { data: 'CODE' },
      //   { data: 'QDOCDATE',render: formatDate},
      //   { data: 'DELYDATE',render: formatDate},
      //   { data: 'NETAMT' },
      //   { data: 'EMPNAMESALES' },
      //   { data: 'EMPNAMEMAKER' },
      //   { data: 'EMPNAMEAPPROVER' },
      //   { data: 'REMARK' },
      // ],
      order: [
        [0, 'desc']
      ],
      columnDefs: [{
        "visible": false,
        "targets": 0
      }],
      initComplete: function(settings, json) {
        $('.loading').hide();
      },
      drawCallback: function(settings) {
        console.log(data_array);
      },
      rowCallback: function(row, data) {
        $(row).on('click', function() {
          
          if (selectedRow !== null) {
            $(selectedRow).removeClass('selected');
          }
          $(this).addClass('selected');
          selectedRow = this;

          if (selectedRecno !== data.RECNO) {
            // เช็คว่ามีแถวที่ถูกเลือกอยู่หรือไม่
            tabledtpost(data.RECNO);
            selectedRecno = data.RECNO;
            console.log(data.RECNO);
          }

     
        });
      },

    });



    // var goToPageInput = $('<span>Jump Page:</span><input id="table_datahdjump" type="number" min="1" max="' + table.page.info().pages + '">');
    // var goToPageButton = $('<button id="gotojump" >Go</button>');

    // goToPageInput.addClass('form-control');
    // goToPageButton.addClass('btn btn-primary');

    // var row = $('<div class="row input-group"></div>');
    // var col8 = $('<div class="col-12 col-md-6 col-lg-8 col-xl-8"></div>');
    // var col4 = $('<div class="col-12 col-md-6 col-lg-4 col-xl-4"></div>');
    // var inputGroup = $('<div class="input-group"></div>');

    // inputGroup.append(goToPageInput);
    // inputGroup.append($('<span class="input-group-btn"></span>').append(goToPageButton));
    // col4.append(inputGroup);

    // row.append(col8);
    // row.append(col4);

    // row.insertBefore('#table_datahd_paginate');

    // $('#gotojump').click(function() {
    //   var page = $('#table_datahdjump').val();
    //   if (page !== '') {
    //     table.page(page - 1).draw(false);
    //   }
    // });


  });

  var table_datadt = $('#table_datadt').DataTable({
    scrollX: true,
    columns: [{
        data: 'QUOTHD'
      },
      {
        data: 'CODE'
      },
      {
        data: 'CALLNAME'
      },
      {
        data: 'QUAN'
      },
      {
        data: 'UNITNAME'
      },
      {
        data: 'UNITAMT'
      },
    ],
    order: [
      [0, 'desc']
    ],
    // columnDefs: [
    //   { "visible": false, "targets": 0}
    // ],
    drawCallback: function(settings) {
      // table_datadt.ajax.reload();
    }
  });


  function tabledtpost(recnodt) {
    $.ajax({
      url: 'ajax_data.php',
      data: {
        // queryId: '0003',
        queryId: '0006',
        params: { // อาร์เรย์ params ที่คุณต้องการส่ง
          RECNO: recnodt,
        },
      },
      dataSrc:'',
      success: function(response) 
      {
        // console.log(response);
        var dataArray = JSON.parse(response);
        // console.log(dataArray); // แสดงอาร์เรย์ที่ได้หลังจากแปลง
        // console.log(dataArray.data);
        table_datadt.clear();
        table_datadt.rows.add(dataArray.data).draw();
      },
      error: function(xhr, status, error) {
        // จัดการข้อผิดพลาดที่เกิดขึ้น
        console.error(error);
      }
    });

  }

  // สำหรับการดึงข้อมูลจาก 'RECNO' ตัวสุดท้าย คุณสามารถใช้ฟังก์ชัน fnGetData() ในการดึงข้อมูลจากแถวสุดท้ายของตาราง ดังตัวอย่างต่อไปนี้:
  // var lastRowData = table.fnGetData(table.fnGetNodes().length - 1);
  // var lastRECNO = lastRowData.RECNO;
  // console.log(lastRECNO);

  $('#table_datahd').on('click', '.btn-primary', function() {
    var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
    var docno = rowData.QDOCNO;
    var name = rowData.NAME;
    var code = rowData.CODE;
    var qdocdate = rowData.QDOCDATE;
    var saleName = rowData.EMPNAMESALES;
    var makegerName = rowData.EMPNAMEMAKER;
    var approverName = rowData.EMPNAMEAPPROVER;
    console.log(qdocdate);

    $('#docNo').text(docno);
    $('#name').text(name);
    $('#code').text(code);
    $('#qdocDate').text(formatDate(qdocdate));
    $('#saleName').text(saleName);
    $('#makegerName').text(makegerName);
    $('#approverName').text(approverName);

    if (approverName) {
      // ถ้ามีชื่อผู้อนุมัติ
      $('#approverBtn').text("ทำการอนุมัติแล้ว");
      $('#approverBtn').removeClass('btn-danger').addClass('btn-success');
    } else {
      // ถ้าไม่มีชื่อผู้อนุมัติ
      $('#approverBtn').text('รอทำการอนุมัติ');
      $('#approverBtn').removeClass('btn-success').addClass('btn-danger');
    }
  });

  handleRadioChange();

  function handleRadioChange() {
    $('#showAllBtn').on('change', function() {
      if ($(this).is(':checked')) {
        // เปลี่ยนเงื่อนไขการค้นหาให้เป็นค่าว่าง
        $('#table_datahd').DataTable().columns(3).search('').draw();
        $('#table_datahd').DataTable().columns(11).search('').draw();
      }
    });

    // เมื่อเลือกปุ่มแสดงผู้อนุมัติ
    $('#showApprovedBtn').on('change', function() {
      if ($(this).is(':checked')) {
        // เปลี่ยนเงื่อนไขการค้นหาให้เป็นค่า "ผู้อนุมัติ"
        $('#table_datahd').DataTable().columns(3).search('Active').draw();
        $('#table_datahd').DataTable().columns(11).search('.+', true, false).draw();
      }
    });

    $('#waitApprovedBtn').on('change', function() {
      if ($(this).is(':checked')) {
        // เปลี่ยนเงื่อนไขการค้นหาให้เป็นค่าว่าง
        $('#table_datahd').DataTable().columns(3).search('Active').draw();
        $('#table_datahd').DataTable().columns(11).search('^$', true, false).draw();
      }
    });
  }
</script>

</html>