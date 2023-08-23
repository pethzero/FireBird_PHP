<!DOCTYPE html>
<html lang="en">
  <head>
    <?php 
          session_start(); 
          if (!isset($_SESSION["RECNO"])) 
            {
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
    <link href="css/bootstarp-sidebars.css" rel="stylesheet">
  </head>
  <body>
  <style>
    .btn-custom {
    background: linear-gradient(to right, #e8e8e8, #f1f1f1);
    color: #000000;
  }
  .card-img-top {
    height: 200px; /* Adjust the height to your desired value */
    object-fit: cover; /* This ensures the image fills the entire space while maintaining aspect ratio */
  }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-custom">
  <a class="navbar-brand text-white" >SAN ENGINEERING</a>
  <button class="navbar-toggler navbar-light" style="background-color:white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- Navbar items on the left -->
      <li class="nav-item active">
        <a class="nav-link text-white" href="index.php">Home</a>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ฝ่ายขาย
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="dataqoud.php">ใบเสนอราคา</a></li>
            <li><a class="dropdown-item" href="datatable_activity.php">ตารางหนัดหมาย</a></li>
            <li><a class="dropdown-item" href="dataactivity.php">เพิ่มตารางหนัดหมาย</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ฝ่ายจัดซื้อ
          </a>
          <ul class="dropdown-menu">
          <li><a class="dropdown-item"  href="datapurc.php" >ใบสั่งขาย</a></li> 
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           ผลิต
          </a>
          <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="datatablemachine.php">เครื่องจักร(กำลังพัฒนา)</a></li> 
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            สโตร์
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="datainvent.php">ดูสินค้า</a></li> 
            <li><a class="dropdown-item" href="datastock.php">ใบเบิกสินค้า</a></li> 
          </ul>
        </li>
    </ul>

    <!-- Navbar items on the right -->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item d-flex align-items-center">
        <span class="nav-link text-white"><?php echo $_SESSION["EMPNAME"] ?></span>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" data-bs-haspopup="true" data-bs-expanded="false">
          <?php  
              echo $_SESSION["IMAGEEMPL"];
            ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
          <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
        </ul>
      </li>
    </ul>
    
  </div>
</nav>


<div class="main-app">
        <!-- Sidebar -->
        
        <div class="sidebar">
            <div class="card">
                <!-- Sidebar content goes here -->
                
                
            </div>
        </div>

        <!-- Main content area -->
        <div class="content">
            <div class="section">
                <div class="container">
                    <!-- Rest of your content goes here -->
                </div>
            </div>
            <div class="section">
                <div class="container pt-2">
                    <!-- New feature buttons or content -->
                </div>
            </div>
        </div>
    </div>

    



    <?php 
    include("0_footer.php"); 
    ?>
  </body>
  <?php 
  include("0_footerjs.php"); 
  ?>
   <script src="js/bootstarp-sidebars.js"></script>

<script>
    $(document).ready(function() {

    });
  </script>

</html>
