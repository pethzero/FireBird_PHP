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
  include("0_headcss.php"); ?>
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
</head>

<body>
  <?php
  include("0_header.php");
  include("0_breadcrumb.php");

  ?>
  <link rel="stylesheet" href="css/mycustomize.css">
  <style>
    .c_activity {
      width: 145px;
    }

    .h_textarea {
      height: 110px;
    }

    textarea {
      overflow-y: scroll;
    }

    .table-custom  {
  --bs-table-color: #000;
  /* --bs-table-bg: #cfe2ff; */
  --bs-table-bg:#98b7ef;
  --bs-table-border-color: #bacbe6;
  --bs-table-striped-bg: #c5d7f2;
  --bs-table-striped-color: #000;
  --bs-table-active-bg: #bacbe6;
  --bs-table-active-color: #000;
  --bs-table-hover-bg: #bfd1ec;
  --bs-table-hover-color: #000;
  color: var(--bs-table-color);
  border-color: var(--bs-table-border-color)
}
  </style>

  <?php
  include("connect.php");
  include("sql.php");
  include("0_fselect.php");
  ?>
  <section>
    <div class="container pt-3">
      <h2>ลงทะเบียน Drawing</h2>
      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='new' type="button" class="btn btn-primary">ทำการลงทะเบียน</button>
        </div>
      </div>

      <!-- <div class="row mb-3">
        <div class="col-sm-12 col-md-6 col-lg-6">
          <label for="searchInput" class="form-label">ค้นหารายการรหัสลูกค้า แบบกรอง</label>
          <div class="input-group">
            <select class="form-control select2" id="searchInput"></select>
            <button class="btn btn-primary" id="searchClear">ล้าง</button>
          </div>
        </div>
      </div> -->


      <div class="row">
        <div class="col-12">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle" width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ข้อมูล</th>
                <th>Customer</th>
                <th>Drawing Number</th>
                <th>Rev No.</th>
                <th>Part Name</th>
                <th>Date</th>
                <th>Remark</th>
                <th>ผู้จัดทำ</th>
                <th>แก้ไขล่าสุด</th>
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

  <div class="modal fade" id="hq" aria-labelledby="hqLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-md modal-lg modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="hqLabel">ลงทะเบียน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <!-- ส่วนที่เพิ่มเนื้อหาภายในกล่องโมดอลได้ที่นี่ -->
          <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <div class="input-group mb-3">
                <span class="input-group-text c_activity">Customer:</span>
                <input type="text" class="form-control" id="custname" placeholder="ลูกค้า">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <div class="input-group mb-3">
                <span class="input-group-text c_activity">Drawing Number:</span>
                <input type="text" class="form-control" id="drawno" placeholder="Drawing Number">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <div class="input-group mb-3">
                <span class="input-group-text c_activity">Rev. No:</span>
                <input type="text" class="form-control" id="revno" placeholder="Rev">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <div class="input-group mb-3">
                <span class="input-group-text c_activity">Part Name:</span>
                <input type="text" class="form-control" id="partname" placeholder="Rev">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <div class="input-group date mb-3" id="datepicker">
                <span class="input-group-text c_activity">วันที่บันทึก:</span>
                <input type="text" class="form-control" id="date" />
                <span class="input-group-append">
                  <span class="input-group-text bg-light d-block">
                    <i class="fa fa-calendar"></i>
                  </span>
                </span>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <div class="input-group mb-3">
                <span class="input-group-text c_activity">Remark:</span>
                <!-- <input type="text" class="form-control" id="drawno" placeholder="Rev"> -->
                <textarea id="remark" class="form-control h_textarea" rows="3" aria-label="With textarea"></textarea>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button id="save_edit" type="button" class="btn btn-danger">ทำการแก้ไข</button>
            <button id="save" type="button" class="btn btn-primary">บันทึกการสร้าง</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="loading"> -->

</body>
<?php include("0_footerjs.php"); ?>
<script src="js/dtcolumn.js"></script>


<script>
  $(document).ready(function() {
    // console.log('wx')
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;

    var jsonData = {
      "data": [{
          "Order": "1",
          "ShowData": null,
          "Customer": "NIC LD SYSTEM",
          "DrawingNumber": "N029-PIN-R001",
          "RevNo": "0",
          "PartName": "เจียร์ PIN 12x3.5CL",
          "Date": "2023-07-31",
          "Remark": "N0290001 FINSHED 1/11/21/เขียนแบบ QC",
          "CreatedBy": "John Doe",
          "LastModified": "นาย ...."
        },
        {
        "Order": "2",
        "ShowData": null,
        "Customer": "NIC LD SYSTEM",
        "DrawingNumber": "N029-PIN-R002",
        "RevNo": "0",
        "PartName": "เจียร์ PIN 12x3.5CL",
        "Date": "31/07/2023",
        "Remark": "N0290001 FINSHED 1/11/21/เขียนแบบ QC",
        "CreatedBy": "John Doe",
        "LastModified": "นาย ...."
      }
        // ข้อมูลอื่นๆ...
      ]
    };

    var dtxcolumns = [{
        data: 'Order'
      },
      {
        data: 'ShowData',
        render: function(data, type, row) {
          if (data === null) {
            return '<button type="button" class="btn btn-danger btn-sm editdata" data-bs-toggle="modal" data-bs-target="#hq"><i class="far fa-edit"></i></button>';
          } else {
            return ''; // หากต้องการแสดงข้อมูลอื่นๆ แทนที่ปุ่ม Edit ในบางแถว สามารถเพิ่มเงื่อนไขในนี้ได้
          }
        }
      },
      {
        data: 'Customer'
      },
      {
        data: 'DrawingNumber'
      },
      {
        data: 'RevNo'
      },
      {
        data: 'PartName'
      },
      {
        data: 'Date'
      },
      {
        data: 'Remark'
      },
      {
        data: 'CreatedBy'
      },
      {
        data: 'LastModified'
      }
    ];


    // var encodedURL = encodeURIComponent('ajax_select_sql.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      data: jsonData.data,
      // ajax: {
      //   url: 'json/ex_drawing.json',
      //   dataSrc: function(json) {
      //     console.log(json);
      //     console.log(json.data);
      //     return json.data;
      //   }
      // },
      scrollX: true,
      columns: dtxcolumns,
      order: [
        [0, 'desc']
      ],
      dom: 'Bfrtip',
      buttons: ['colvis',
        //  'csv', 
        {
          extend: 'excelHtml5',
          title: 'Data export'
        }
      ],
      columnDefs: [
        // { type: 'currency', targets: 8 },
        {
          "visible": false,
          "targets": 0
        },
      ],
      initComplete: function(settings, json) {
        // $('.loading').hide();
      },
      createdRow: function(row, data, dataIndex) {

      },
      drawCallback: function(settings) {

      },
      rowCallback: function(row, data) {
        $(row).on('click', function() {
          if (selectedRow !== null) {
            $(selectedRow).removeClass('table-custom');
          }
          $(this).addClass('table-custom');
          selectedRow = this;
          console.log(selectedRow)
        });
      },
    });

    // คลิกที่ปุ่ม "เพิ่มตารางหนัดหมาย"
    $("#new").click(function() {
      $("#hq").modal("show"); // เปิดกล่องโมดอล
      $('#save_edit').hide();
      $('#save').show();
      $('#custname').val('');
      $('#drawno').val('');
      $('#revno').val('');
      $('#partname').val('');
      $('#date').val('');
      $('#remark').val('');
    });

    // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
    $(".modal .btn-secondary, .modal .btn-close").click(function() {
      $("#hq").modal("hide"); // ปิดกล่องโมดอล
    });

    $(function() {
      $("#datepicker").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        clearBtn: true
      });
    });

    ///////////////////////////////////////////////////////// OPEN //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // var recno_custname;
    // var recno_drawno;
    // var recno_revno;
    // var recno_partname;
    // var recno_revno;
    // var recno_revno;
    // var recno_date;
    var recno_remark;
    $('#table_datahd').on('click', '.editdata', function() {
      // console.l
      $('#save_edit').show();
      $('#save').hide();
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      $('#custname').val(rowData.Customer);
      $('#drawno').val(rowData.DrawingNumber);
      $('#revno').val(rowData.RevNo);
      $('#partname').val(rowData.PartName);
      $('#date').val(rowData.Date);
      $('#remark').val(rowData.Remark);
      // console.log(rowData);
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////// SAVE //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('#save').on('click', function() {
      var newOrder = jsonData.data.length + 1; // หาลำดับใหม่โดยใช้ขนาดของ Array ที่มีอยู่ + 1

      console.log(newOrder)
      var newData = {
        "Order": newOrder.toString(), // แปลงเป็น String เพื่อให้เป็นตัวอักษร
        "ShowData": null,
        "Customer": $('#custname').val(),
        "DrawingNumber": $('#drawno').val(),
        "RevNo": $('#revno').val(),
        "PartName": $('#partname').val(),
        "Date": $('#date').val(),
        "Remark": $('#remark').val(),
        "CreatedBy": "Your Name", // กำหนดชื่อผู้จัดทำ
        "LastModified": "" // ในที่นี้คือว่ายังไม่มีการแก้ไขล่าสุด
      };

      jsonData.data.push(newData); // เพิ่มข้อมูลใหม่ลงใน Array ของ JSON

      table.row.add(newData).draw(); // เพิ่มแถวใหม่ใน DataTable และวาดใหม่
      $('#hq').modal('hide'); // ซ่อน Modal หลังจากบันทึก
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////// EDIT //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $('#save_edit').on('click', function() {
      // console.log(selectedRow)
      var rowData = table.row(selectedRecno).data(); // ดึงข้อมูลแถวที่เลือกใน DataTable
      var rowIndex = table.row(selectedRecno).index(); // หาตำแหน่งแถวที่เลือกใน DataTable

      console.log(rowData)
      console.log(rowIndex)
      // // อัปเดตข้อมูลใน JSON
      rowData.Customer = $('#custname').val();
      rowData.DrawingNumber = $('#drawno').val();
      rowData.RevNo = $('#revno').val();
      rowData.PartName = $('#partname').val();
      rowData.Date = $('#date').val();
      rowData.Remark = $('#remark').val();
      rowData.LastModified = "นาย ...."; // กำหนดชื่อผู้แก้ไข

      // อัปเดตข้อมูลใน DataTable
      table.row(rowIndex).data(rowData).draw();
      $('#hq').modal('hide');
    });
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  });
</script>

</html>