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
  </style>

<?php
  include("connect.php"); 
  include("sql.php");
  include("0_fselect.php");
?>
  <section>
    <div class="container pt-3">
      <h2>ตารางนัดหมาย</h2>
      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <input type="radio" id="showAllBtn" name="fav_language" value="all" checked>
          <label for="showAllBtn">แสดงทั้งหมด</label>

        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <input type="radio" id="showApprovedBtn" name="fav_language" value="approved">
          <label for="showApprovedBtn">ทำการอนุมัติแล้ว</label>

        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <input type="radio" id="waitApprovedBtn" name="fav_language" value="wait">
          <label for="waitApprovedBtn">รอทำการอนุมัติ</label>
        </div>

      </div>

      <div class="row mb-3">
        <div class="col-sm-12 col-md-6 col-lg-6">
          <label for="searchInput" class="form-label">ค้นหารายการรหัสลูกค้า แบบกรอง</label>
          <div class="input-group">
            <select class="form-control select2" id="searchInput"></select>
            <button class="btn btn-primary" id="searchClear">ล้าง</button>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-12">
          <h1>ใบเสนอราคา</h1>
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle" width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>แสดงข้อมูล</th>
                <th>เลขที่นัดหมาย</th>
                <th>สถานะ</th>
                <th>รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
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
  $(document).ready(function()
  {
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;

    var encodedURL = encodeURIComponent('ajax_data.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      // ajax: {
      //   url: encodedURL,
      //   data: function(d) {
      //     d.queryId = '0001'; // ส่งค่าเป็นพารามิเตอร์ queryId
      //     d.params = null;
      //   },
      //   dataSrc: function(json) {
      //     tablejsondata = json.data
      //     return json.data;
      //   }
      // },
      scrollX: true,
      // columns: dtcolumn['dataquoud'],
      order: [
        [0, 'desc']
      ],
      columnDefs: [
        { type: 'currency', targets: 8 },
        {
"visible": false,"targets": 0
      }, ],
      initComplete: function(settings, json) {
        $('.loading').hide();

      },
      createdRow: function(row, data, dataIndex) {
        // // ค่าของคอลัมน์ STATUS อยู่ใน data.STATUS
        // let status = data.EMPNAMEAPPROVER !== '' ? 'bg-success' : 'bg-danger';
        // $(row).find('td:eq(2)').addClass(status); // ในที่นี้ คอลัมน์ STATUS มีลำดับที่ 3 (จำนวนคอลัมน์เริ่มต้นที่ 0)
      },
      drawCallback: function(settings) {
      },
      rowCallback: function(row, data) {
        // // console.log('rowCallback')
        // $(row).on('click', function() {
        //   if (selectedRow !== null) {
        //     $(selectedRow).removeClass('selected');
        //   }
        //   $(this).addClass('selected');
        //   selectedRow = this;

        //   if (selectedRecno !== data.RECNO) {
        //     // เช็คว่ามีแถวที่ถูกเลือกอยู่หรือไม่
        //     selectedRecno = data.RECNO;
        //     console.log(data.RECNO);
        //   }
        // });
      },

    });


  });
</script>

</html>