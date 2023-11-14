<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="assets/js/color-modes.js"></script>

  <?php
  session_start();
  if (!isset($_SESSION["RECNO"])) {
    header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
  }
  include("0_headcss.php");
  ?>
  <style>
  /* Media query สำหรับโทรศัพท์ (หน้าจอขนาดเล็ก) */
  @media (min-width: 768px) {
      .sidebar {
        height: 94.2vh;
        overflow-y: auto;
      }
    }

  </style>
  <link href="dashboard.css" rel="stylesheet">
</head>

<body>
  <?php include("0_dbheader.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <!-- SIDE -->
      <?php include("0_sidebar.php"); ?>
      <!-- CONTENT -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">SAN ENGINEERING</h1>
        </div>
        <div class="row mb-2">
          <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary-emphasis">
                  <h3>ฝ่ายขาย</h3>
                </strong>
                <ul>
                  <li><a href="appointment_up.php">ตารางนัดหมาย</a></li>
                  <li><a href="datatable_qt.php">อันดับลูกค้าใบเสนอราคา</a></li>
                  <li><a href="datatable_invoice.php">สรุปยอดขาย (ใบแจ้งหนี้)</a></li>
                  <li><a href="summaryinvoiceqt.php">สรุปยอดขายลูกค้า</a></li>
                  <li><a href="miscellaneous.php">รายงาน</a></li>
                </ul>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img src="images/QT_IMG1.jpg" alt="Thumbnail" width="200" height="250">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary-emphasis">
                  <h3>จัดซื้อ</h3>
                </strong>
                <ul>
                  <li><a href="datatable_po.php">อันดับผู้จำหน่ายใบสั่งซื้อ</a></li>
                  <li><a href="detailpo.php">สรุปแจงซื้อ (ใบแจ้งหนี้แบบรายละเอียด)</a></li>
                  <li><a href="summaryinvoicepo.php">สรุปยอดซื้อผู้จำหน่าย</a></li>
                  <li><a href="dataquancontrol.php">ประเมินคุณภาพสินค้า</a></li>
                </ul>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img src="images/PO_IMG1.jpg" alt="Thumbnail" width="200" height="250">
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary-emphasis">
                  <h3>ซ่อมบำรุง</h3>
                </strong>
                <ul>
                  <li><a href="datatable_equipment.php">บักทึกอุปกรณ์</a></li>
                  <li><a href="datatable_warning.php">แจ้งซ่อม</a></li>
                </ul>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img src="images/Maintenance_IMG1.jpg" alt="Thumbnail" width="200" height="250">
              </div>
            </div>
          </div>

        </div>
        <!-- END -->
        <!-- <hr> -->
        <!-- <h3>รอการทดสอบ</h3>
        <div class="row">
          <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
            <button class="btn btn-primary" onclick="window.location='summaryinvoicepo.php';">สรุปยอดผู้จำหน่าย</button>
          </div>
          <div class="d-grid col-sm-12 col-md-4 col-lg-2 pt-3">
            <button class="btn btn-primary" onclick="window.location='summaryinvoicepo_old.php';">สรุปยอดผู้จำหน่าย (เก่า)</button>
          </div>
        </div> -->
      </main>
    </div>
  </div>
  <script src="js/bootstrap-5.3.1.bundle.min.js"></script>
</body>

</html>