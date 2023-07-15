<!DOCTYPE html>
<html lang="en">
  <head>
    <?php 
    include("0_headcss.php"); 
    ?>
    <!-- <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/bootstrap-5.3.0.min.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/mypcu.css"> -->
  </head>
  <body>
  <style>
    .btn-custom {
    background: linear-gradient(to right, #e8e8e8, #f1f1f1);
    color: #000000;
  }
</style>

  <?php 
      session_start(); 
      if (!isset($_SESSION["RECNO"])) 
        {
          header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
          exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
        } 
      include("0_header.php"); 
      include("0_breadcrumb.php"); 
  ?>
    
<div class="section">
  <div class="container pt-2">
    <div class="row">
      <div class="col-md-12 mb-4">
        <a href="datahistrevenue.php" class="btn btn-custom">รายงานเปรียบเทียบรายได้ย้อนหลัง</a>
      </div>
      <div class="col-md-12 mb-4">
        <a href="ลิงก์ของคุณ" class="btn btn-custom">ข้อความที่คุณต้องการให้แสดงบนปุ่ม</a>
      </div>
      <div class="col-md-12 mb-4">
        <a href="ลิงก์ของคุณ" class="btn btn-custom">ข้อความที่คุณต้องการให้แสดงบนปุ่ม</a>
      </div>
      <div class="col-md-12 mb-4">
        <a href="ลิงก์ของคุณ" class="btn btn-custom">ข้อความที่คุณต้องการให้แสดงบนปุ่ม</a>
      </div>
    </div>
  </div>
</div>

 <hr>

    <?php include("0_footer.php"); ?>
  </body>
  <?php 
  ?>
</html>