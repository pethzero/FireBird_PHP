<nav class="navbar navbar-expand-lg navbar-light bg-custom">
  <a class="navbar-brand text-white" >SAN ENGINEERING</a>
  <!-- <button class="navbar-toggler navbar-toggler-light bg-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> -->
  <button class="navbar-toggler navbar-light" style="background-color:white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- Navbar items on the left -->
      <li class="nav-item active">
        <a class="nav-link text-white" href="index.php">Home</a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link text-white" href="#">Link</a>
      </li> -->
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ฝ่ายขาย
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="dataqoud.php">ใบเสนอราคา</a></li>
            <li><a class="dropdown-item" href="datatable_activity.php">ตารางหนัดหมาย</a></li>
            <li><a class="dropdown-item" href="dataactivity.php">เพิ่มตารางหนัดหมาย</a></li>
            <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li> -->
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
      <!-- <li class="nav-item">
        <a class="nav-link disabled text-white" href="#">Disabled</a>
      </li> -->
    </ul>

    <!-- Navbar items on the right -->
    <ul class="navbar-nav ms-auto">
      <li class="nav-item d-flex align-items-center">
        <span class="nav-link text-white"><?php echo $_SESSION["EMPNAME"] ?></span>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" data-bs-haspopup="true" data-bs-expanded="false">
          <?php  
              include('connect.php');
              $sql = "SELECT USERIMG FROM EMPL WHERE RECNO=:RECNO";
              $query = $pdo->prepare($sql);
              $query->execute(array($_SESSION["RECNO"]));
              $row = $query->fetch();
              $base64Data = base64_encode($row["USERIMG"]);
              if ($base64Data) {
                echo '<img src="data:image/jpeg;base64,' . $base64Data . '" width="40" height="40" class="rounded-circle">';
              } else {
                echo '<img src="images/fox.jpg" width="40" height="40" class="rounded-circle">';
              }
            ?>

          <!-- <img src="images/fox.jpg" width="40" height="40" class="rounded-circle"> -->
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
          <li><a class="dropdown-item" href="logout.php">Log Out</a></li>
        </ul>
      </li>
    </ul>
    
  </div>
</nav>


<section>
        <div class="text-center" style="background:linear-gradient(to right, #000000, #808080, #000000); background-repeat: no-repeat; background-size: cover;">
        <div class="container">
          <div class="row pt-5 pb-5">
            <div class="col-12" align="center">
              <!-- <h1><img src="images/mypcu_academy_logo_tp.png"  alt=""/></h1> -->
              <h1 style="color:white">
                      SAN ENGINEERING
              </h1>
            </div>
          </div>
        </div>
      </div>
</section>


