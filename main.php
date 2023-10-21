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

    /* @keyframes rainbow {
      0% {
        background: linear-gradient(45deg, red, orange, yellow, green, blue, indigo, violet, red);
      }

      100% {
        background: linear-gradient(45deg, violet, indigo, blue, green, yellow, orange, red, violet);
      }
    }

    .blinking-rainbow-button {
      animation: rainbow 5s linear infinite;
      color: white;
      border: none;
      cursor: pointer;
    } */
    @keyframes blink {
      0% {
        background-color: green;
      }

      50% {
        background-color: greenyellow;
        color: black;
      }

      100% {
        background-color: green;
      }
    }

    .blinking-button {
      animation: blink 1s infinite;
      /* ใช้ keyframes green-blink ที่สร้างขึ้นในขั้นที่ 1 */
      color: white;
      /* สีของข้อความบนปุ่ม */
      border: none;
      /* ลบเส้นขอบ */
      cursor: pointer;
      /* เมื่อนำเมาส์มาอยู่บนปุ่มจะเป็นเคอร์เซอร์ประเภท */
    }
    .custom-img {
    width: 100%; /* ทำให้ภาพขยายเต็มกว้างของ Carousel */
    height: 300px; /* ครอบครองสัดส่วนเพื่อป้องกันการเพี้ยนรูปภาพ */
  }
  </style>
  <?php
  include("0_header.php");
  // include("0_breadcrumb.php"); 
  ?>

  <div class="section">
    <div class="container-fluid">
      <div class="row d-flex justify-content-center">
        <div class="col-sm-12 col-md-6 col-lg-6">
          <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <!-- <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button> -->
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active" data-bs-interval="10000">
                <img src="doc/22829.jpg" class="custom-img" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h1> 3 ก๊วน </h1>
                  <p >คาปู ลาเต้ ซูโม่</p>
                </div>
              </div>
              <div class="carousel-item" data-bs-interval="2000">
                <img src="doc/banner_intermecrh.jpg" class="custom-img" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <!-- <h5>Second slide label</h5>
                  <p>Some representative placeholder content for the second slide.</p> -->
                </div>
              </div>
              <!-- <div class="carousel-item">
                <img src="doc/22829.jpg" class="custom-img" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5>Third slide label</h5>
                  <p>Some representative placeholder content for the third slide.</p>
                </div>
              </div> -->
            </div>
            <button class="carousel-control-prev btn-white" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next btn-white" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>

        </div>

      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
          <div class="card">
            <img class="card-img-top img-thumbnail" src="doc/pr.jpg" alt="Card image cap">
            <div class="card-body">
              <h2 class="card-title">ฝ่ายขาย</h2>
              <p class="card-text">
              <ul>
                <li><a href="appointment_up.php">ตารางนัดหมาย</a></li>
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
                <li><a href="datatable_po.php">อันดับผู้จำหน่ายใบสั่งซื้อ</a></li>
                <li><a href="detailpo.php">สรุปแจงซื้อ ใบแจ้งหนี้</a></li>
              </ul>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
  <hr>
  <div class="section">
    <div class="container pt-2 ">
      <h1> FEATURE ใช้งาน</h1>
      <div class="row">

        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-success blinking-button" onclick="window.location='appointment_up.php';">ตารางนัดหมาย (NEW)</button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-secondary" onclick="window.location='appointment.php';">ตารางนัดหมาย (OLD)</button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='datatable_qt.php';">ดูอันดับใบเสนอราคา</button>
        </div>
        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='datatable_invoice.php';">ใบแจ้งหนี้(ขาย)</button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='detailpo.php';">ดูอันดับใบสั่งซื้อ</button>
        </div>
        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='detailpo.php';">ดูสรุปแจงสั่งซื้อ(ซื้อ)</button>
        </div>

        <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
          <button class="btn btn-primary" onclick="window.location='summaryinvoice.php';">สรุปยอดขายลูกค้า</button>
        </div>


        <!-- <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
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
        </div> -->

      </div>

      <h1>รอการทดสอบ</h1>
      <div class="row">
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



      </div>

      <div class="row pt-3">
        <!-- <div class="d-grid col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-primary" onclick="window.location='datatable_invoice.php';">ดู Invoice</button>
        </div>
        <div class="d-grid col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-primary" onclick="window.location='datatable_qt.php';">ดูอันดับใบเสนอราคา</button>
        </div>
        <div class="d-grid col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-primary" onclick="window.location='detailpo.php';">ดูสรุปแจงสั่งซื้อ</button>
        </div> -->
      </div>

      <!-- <div class="row pt-3">
       
      </div> -->

      <h1>แอดมิน</h1>
      <div class="row">
        <div class="d-grid col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-primary" onclick="window.location='dataempl.php';">พนักงงาน </button>
        </div>
        <?php
        if (isset($_SESSION['USERLEVEL']) && $_SESSION['USERLEVEL'] == 'S') {
        ?>
          <div class="d-grid col-sm-12 col-md-4 col-lg-2">
            <button class="btn btn-primary" onclick="window.location='appointment_create.php';">ทดสอบ</button>
          </div>

          <div class="d-grid col-sm-12 col-md-4 col-lg-2">
            <button class="btn btn-primary" onclick="window.location='appointment_up.php';">ทดสอบ</button>
          </div>
        <?php
        }
        ?>
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