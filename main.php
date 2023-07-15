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
          <div class="col-sm-12 col-md-12 col-lg-3">
            <div class="card" >
            <img class="card-img-top img-thumbnail" src="" alt="Card image cap">
              <div class="card-body">
                <h1 class="card-text">
                <a href="datamanage.php">บริหาร</a>
                </h1>
              </div>
            </div>
          </div>

          <div class="col-sm-12 col-md-12 col-lg-3">
            <div class="card" >
            <img class="card-img-top img-thumbnail" src="" alt="Card image cap">
              <div class="card-body">
              <h1 class="card-text">
                ผลิต
              </h1>
              </div>
            </div>
          </div>

          <div class="col-sm-12 col-md-12 col-lg-3">
            <div class="card" >
            <img class="card-img-top img-thumbnail" src="" alt="Card image cap">
              <div class="card-body">
              <h1 class="card-text">
                <!-- STOCK -->
                <a href="datainvent.php">สโตร์</a>
                <!-- <a href="datainvent.php">สโตร์</a> -->
              </h1>
              </div>
            </div>
          </div>

          <div class="col-sm-12 col-md-12 col-lg-3">
            <div class="card" >
            <img class="card-img-top img-thumbnail" src="" alt="Card image cap">
              <div class="card-body">
              <h1 class="card-text">
                <!-- STOCK -->
                <a href="datastock.php">เบิกสินค้า</a>
              </h1>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
 <hr>

    
    <!-- <div class="section">
      <div class="container">
       
      </div>
    </div>
    <hr> -->


    <?php include("0_footer.php"); ?>
  </body>
  <?php 
  // include("0_footerjs.php"); 
  ?>
</html>