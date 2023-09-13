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
      width: 100px;
    }

    .h_textarea {
      height: 110px;
    }

    textarea {
      overflow-y: scroll;
    }

    /* .datepicker td,
    th {
      text-align: center;
      padding: 8px 12px;
      font-size: 14px;
    }

    .datepicker {
      border: 1px solid black;
    } */
  </style>

  <?php
  // include("connect_sql.php");
  include("connect_sql.php");
  include("sql.php");
  include("0_fselect.php");
  ?>
  <section>
    <div class="container pt-3">
      <h2>ตารางนัดหมาย</h2>

      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <div class="input-group date mb-3" id="datepicker">
            <span class="input-group-append">
              <span class="input-group-text bg-light d-block">
                <i class="fa fa-calendar"></i>
              </span>
            </span>
            <input type="text" class="form-control" id="date" readonly />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <div class="input-group mb-3">
            <span class="input-group-text c_activity">สถานะ:</span>
            <select class="form-select" id="status">
              <option value="" selected>เลือก...</option>
              <option value="ยังไม่เริ่มดำเนินการ">ยังไม่เริ่มดำเนินการ</option>
              <option value="อยู่ระหว่างดำเนินการ">อยู่ระหว่างดำเนินการ</option>
              <option value="รอดำเนินการ">รอดำเนินการ</option>
              <option value="ถูกเลื่อนออกไป">ถูกเลื่อนออกไป</option>
              <option value="เสร็จสิ้น">เสร็จสิ้น</option>
            </select>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='seacrh' type="button" class="btn btn-primary">ค้นหา</button>
        </div>
      </div>

      <hr>

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='new' type="button" class="btn btn-primary">เพิ่มตารางหนัดหมาย</button>
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
                <th>เลขที่นัดหมาย</th>
                <th>สถานะ</th>
                <!-- <th>รหัสลูกค้า</th> -->
                <th>บริษัท</th>
                <th>ผู้ติดต่อ</th>
                <th>วันที่นัดหมาย</th>
                <th>ความสำคัญ</th>
                <th>ราคาเบิก</th>
                <th>ราคาจ่าย</th>
                <th>ผู้นัดหมาย</th>

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
          <h5 class="modal-title" id="hqLabel">ใบเสนอราคา</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <!-- ส่วนที่เพิ่มเนื้อหาภายในกล่องโมดอลได้ที่นี่ -->
        </div>

        <div class="modal-footer">
          <button id="save" type="button" class="btn btn-primary">บันทึก</button>
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
    
    var recno = null;
    var qid = 'SEL_ACTIVITYHD';
    var startd = null;
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;

    $('#new').click(function() {
      // window.location = 'dataactivity.php';
      window.location = 'dataactivity_mysql.php';
    });

    // var encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');
    var encodedURL = encodeURIComponent('ajax_select_sql_mysql.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      ajax: {
        url: encodedURL,
        data: function(d) {
          d.queryId = qid; // ส่งค่าเป็นพารามิเตอร์ queryId
          d.params = {
            // RECNO:recno,
            STARTD: startd,
          };
          d.condition = 'mix';
        },
        dataSrc: function(json) {
          // console.log(json) 
          tablejsondata = json.data
          return json.data;
        }
      },
      scrollX: true,
      columns: dtcolumn['DATA_ACTIVITYHD'],
      columnDefs: [
        {
          className:'noVis',
          targets: [0]
        },
        {
          className:'dt-center',
          targets: [3]
        },
        { "orderable": false, "targets": 1 },
        {
          type: 'currency',
          targets: 8
        },
        {
          "visible": false,
          "targets": 0
        },
        // { type: 'de_date', targets: 6 }
        { type: 'th_date', targets: 6 }
      ],
      order: [
        [0,'desc'],
      ],
      dom: 'Bfrtip',
      buttons: [{
                extend: 'colvis',
                text: 'Show/Hide',
                columns: ':not(.noVis)',
                // columnText: function ( dt, idx, title ) {
                // return (idx+1)+': '+title;
                // }
              },
        //  'csv', 
        {
          extend: 'excelHtml5',
          title: 'Data export',
          exportOptions: {
                    columns: [ 2, 3,4,5,6,7,8,9,10 ]
                }
        }
      ],
    
      initComplete: function(settings, json) {
        // $('.loading').hide();

      },
      createdRow: function(row, data, dataIndex) {

      },
      drawCallback: function(settings) {

      },
      rowCallback: function(row, data) {
        // // console.log('rowCallback')
        $(row).on('click', function() {
          if (selectedRow !== null) {
            $(selectedRow).removeClass('table-custom');
          }
          $(this).addClass('table-custom');
          selectedRow = this;

          if (selectedRecno !== data.RECNO) {
            // เช็คว่ามีแถวที่ถูกเลือกอยู่หรือไม่
            selectedRecno = data.RECNO;
            // console.log(data.RECNO);
          }
        });
      },
    });


    $('#table_datahd').on('click', '.edit', function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      console.log(rowData.RECNO);
      // var url = "dataactivity.php?edit&recno=" + rowData.RECNO;
      var url = "dataactivity_mysql.php?edit&recno=" + rowData.RECNO;
      // เปิดหน้าเว็บ dataactivity.php ในหน้าต่างใหม่
      window.open(url, "_blank");
    });

    $(function() {
      $("#datepicker").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        clearBtn: true
      });
    });

    $('#seacrh').click(function() {
      var dateValue = $('#date').val();

      console.log(startd)
      if (dateValue) {
        startd = moment($('#date').val(), 'DD/MM/YYYY').format('DD/MM/YYYY')
      } else {
        startd = '';
      }

      console.log(startd)
      $('#table_datahd').DataTable().column(6).search(startd).draw();
      $('#table_datahd').DataTable().column(3).search($('#status').val()).draw();
      // if (dateValue) {
      //   qid = 'DATESEL_ACTIVITYHD'
      // startd = moment($('#date').val(), 'DD/MM/YYYY').format('MM/DD/YYYY')
      // } else {
      //   qid = 'SEL_ACTIVITYHD';
      //   startd = null;
      // }


      // // recno = 7
      // console.log(dateValue)
      // console.log(startd)

      // table.ajax.reload();
    })

  });
</script>

</html>