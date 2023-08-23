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
      width: 110px;
    }

    .h_textarea {
      height: 110px;
    }

    textarea {
      overflow-y: scroll;
    }

    .table-custom {
      --bs-table-color: #000;
      /* --bs-table-bg: #cfe2ff; */
      --bs-table-bg: #98b7ef;
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
      <h2>ส่งข้อความแจ้งเตือนผ่าน LINE Notify</h2>

      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="input-group mb-3">
          <span class="input-group-text c_activity">ทีม:</span>
          <input type="text" class="form-control" id="team" value="<?php echo $_SESSION["EMPNAME"]  ?>" placeholder="ทีม">
        </div>
      </div>

      <div class="row mb-3">
        <div class="input-group">
          <span class="input-group-text c_activity">รายละเอียด:</span>
          <textarea id="message" name="message" rows="10" cols="40" class="form-control h_textarea" aria-label="textarea a"></textarea>
        </div>
      </div>

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='ok' type="button" class="btn btn-primary">ทำการลงทะเบียน</button>
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
    $("#ok").click(function() {

      var message =  $('#team').val().trim() + '\n' +'รายงานเรื่อง:'+ $('#message').val().trim();
      // console.log(message)
      $.ajax({
        url: 'ajax_line.php',
        method: 'POST',
        data: {
          accessToken: 'Hh0ura2RMQuxyHutazonFsR4SdKT5f6ASoAGGEInuXv',
          message: message,
        },
        success: function(response) {
          $('#result').text('ส่งข้อความแจ้งเตือนผ่าน LINE Notify สำเร็จ!');
          $('#message').val(''); // ล้างค่าใน textarea
        },
        error: function(xhr, status, error) {
          $('#result').text('เกิดข้อผิดพลาดในการส่งข้อความแจ้งเตือนผ่าน LINE Notify');
        }
      });
    });
  });
</script>

</html>