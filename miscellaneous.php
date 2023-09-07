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
  </style>
  <?php
  include("0_header.php");
  // include("0_breadcrumb.php"); 
  ?>

<!-- <button id="runButton">รันข้อมูล</button>
    <a id="downloadLink" style="display: none;">ดาวน์โหลดไฟล์ Excel</a> -->
  <div class="section">
    <div class="container-fluid">
      <div class="row  pt-3">
        <h1>ดาวโหลดส่วนเสริม</h1>
      </div>
      <div class="row  pt-3">

        <div class="col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-primary" id="downloadExcel">excel ฝ่ายขาย</button>
        </div>
        <div id="result"></div>
      </div>
    </div>
    <div class="loading" style="display: none;"></div>
  </div>
  <!-- <hr> -->

  <!-- <hr> -->


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
            $("#downloadExcel").click(function() {
                // ข้อมูลที่ต้องการส่งไปยัง PHP
                // ส่งข้อมูลไปยัง PHP โดยใช้ AJAX
                $('.loading').show();
                console.log('wow')
                $.ajax({
                    type: "POST",
                    url: "export/excelsql.php", // แก้ไขเป็น URL ของไฟล์ PHP ที่คุณสร้างขึ้น
                    data: { data: 'customersale' ,},
                    success: function(response) {
                        data_json = JSON.parse(response).download;
                        console.log(data_json)
                        window.location.href = "export/"+data_json;
                        $('.loading').hide();
                    }
                });
            });
  });
      

</script>

</html>