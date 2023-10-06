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

  <div class="section">
    <div class="container-fluid">
      <div class="row d-flex justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
          <div class="card">
            <img class="card-img-top img-thumbnail" src="doc/pr.jpg" alt="Card image cap">
            <div class="card-body">
              <h2 class="card-title">ฝ่ายขาย</h2>
              <p class="card-text">
              <ul>
                <li><a href="appointment.php">ตารางนัดหมาย</a></li>
                <li><a href="datatable_qt.php">อันดับลูกค้าใบเสนอราคา</a></li>
                <li><a href="datatable_invoice.php">สรุปยอดขาย (ใบแจ้งหนี้)</a></li>
                <li><a href="miscellaneous.php">รายงาน</a></li>
              </ul>
              </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
          <div class="card">
            <img class="card-img-top img-thumbnail" src="doc/pr.jpg" alt="Card image cap">
            <div class="card-body">
              <h2 class="card-title">ฝ่ายจัดซื้อ</h2>
              <p class="card-text">
              <ul>
                <li><a href="datatable_po.php">อันดับลูกค้าใบสั่งซื้อ</a></li>
              </ul>
              </p>
            </div>
          </div>
        </div>

        <!-- <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
          <div class="card">
            <img class="card-img-top img-thumbnail" src="doc/pr.jpg" alt="Card image cap">
            <div class="card-body">
              <h2 class="card-title">ฝ่ายจัดซื้อ</h2>
              <p class="card-text">
              <ul>
                <li><a href="datapurc.php">ใบสั่งซื้อ</a></li>
              </ul>
              </p>
            </div>
          </div>
        </div> -->


        
      </div>
    </div>
  </div>
  <hr>
  <div class="section">
    <div class="container pt-2">
      <h1> NEW FEATURE</h1>
      <h1>ผู้ใช้งาน</h1>
      <div class="row" >
        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='appointment.php';">ดูตารางนัดหมาย</button>
        </div>
        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='dataline.php';">แจ้งเตือน LINE</button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
             <button class="btn btn-primary" onclick="window.location='datatable_equipment.php';">ดูอุปรณ์</button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='datatable_warning.php';">ดูตารางแจ้งซ่อม</button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='datargdrawing.php';">ลงทะเบียน DRAWING</button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='datatable_qt.php';">ดูอันดับใบเสนอราคา</button>
        </div>
      </div>


      <div class="row pt-3">
        <div class="d-grid col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-primary" onclick="window.location='datatable_invoice.php';">ดู Invoice</button>
        </div>
      </div>

      <h1>แอดมิน</h1>
      <div class="row" >
        <div class="d-grid col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-primary" onclick="window.location='dataempl.php';">พนักงงาน </button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-primary" onclick="window.location='appointment.php';">ทดสอบ </button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-primary" onclick="window.location='company.php';">ทดสอบ </button>
        </div>

    
      </div>
    </div>
  </div>
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
  // include("0_footer.php");
   ?>
</body>
<?php
include("0_footerjs.php");
?>


<script>
  $(document).ready(function() {
   
  });
</script>

</html>