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
      <h2>ลงทะเบียน Drawing</h2>
      <div class="row pb-3">
     
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
           <!-- <button id='new' type="button" class="btn btn-primary">เพิ่มตารางหนัดหมาย</button> -->
        </div>
        <!-- <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <input type="radio" id="showApprovedBtn" name="fav_language" value="approved">
          <label for="showApprovedBtn">ทำการอนุมัติแล้ว</label>

        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <input type="radio" id="waitApprovedBtn" name="fav_language" value="wait">
          <label for="waitApprovedBtn">รอทำการอนุมัติ</label>
        </div> -->

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
                <th>แสดงข้อมูล</th>
                <th>Customer</th>
                <th>Drawing Number</th>
                <!-- <th>รหัสลูกค้า</th> -->
                <th>Rev No.</th>
                <th>Part Name</th>
                <th>Date</th>
                <th>Remark</th>
                <!-- <th>ราคาเบิก</th>
                <th>ราคาจ่าย</th>
                <th>ผู้นัดหมาย</th> -->
              
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
    // console.log('wx')
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;

    $('#new').click(function() {
       window.location='dataactivity.php';
      });

    var encodedURL = encodeURIComponent('ajax_select_sql.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      // ajax: {
      //   url: encodedURL,
      //   data: function(d) {
      //     d.queryId = 'SEL_ACTIVITYHD'; // ส่งค่าเป็นพารามิเตอร์ queryId
      //     d.params = null;
      //   },
      //   dataSrc: function(json) {
      //     console.log(json)
      //     tablejsondata = json.data
      //     return json.data;
      //   }
      // },
      scrollX: true,
      // columns: 
      // dtcolumn['DATA_ACTIVITYHD'],
      order: [ [0, 'desc']],
      dom: 'Bfrtip',
      buttons: ['colvis',
      //  'csv', 
         {
                extend: 'excelHtml5',
                title: 'Data export'
            }],
      columnDefs: [
        // { type: 'currency', targets: 8 },
        {
"visible": false,"targets": 0
      }, ],
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
            $(selectedRow).removeClass('selected');
          }
          $(this).addClass('selected');
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
      var url = "dataactivity.php?edit&recno=" + rowData.RECNO;
      // เปิดหน้าเว็บ dataactivity.php ในหน้าต่างใหม่
      window.open(url, "_blank");
    });


  });
</script>

</html>