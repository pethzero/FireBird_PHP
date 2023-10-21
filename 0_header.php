<nav class="navbar navbar-expand-lg navbar-light bg-custom">
  <a class="navbar-brand text-white" style="margin-left: 15px;">SAN ENGINEERING</a>
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
          <li><a class="dropdown-item" href="appointment_up.php">ตารางหนัดหมาย</a></li>
          <li><a class="dropdown-item" href="datatable_qt.php">อันดับลูกค้าใบเสนอราคา</a></li>
          <li><a class="dropdown-item" href="datatable_invoice.php">สรุปยอดขาย (ใบแจ้งหนี้)</a></li>
          <li><a class="dropdown-item" href="miscellaneous.php">รายงาน</a></li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          ฝ่ายจัดซื้อ
        </a>
        <ul class="dropdown-menu">
          <!-- <li><a class="dropdown-item">coming soon</a></li> -->
          <li><a class="dropdown-item" href="datatable_po.php">อันดับผู้จำหน่ายใบสั่งซื้อ</a></li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          ดูแล
        </a>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="dataequipment.php">เพิ่มอุปกรณ์</a></li>
          <li><a class="dropdown-item" href="dataempl.php">พนักงงาน</a></li>
        </ul>
      </li>


      <li class="nav-item ">
        <a class="nav-link text-white" href="miscellaneous.php">รายงาน</a>
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