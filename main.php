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
  </style>
  <link href="dashboard.css" rel="stylesheet">
</head>

<body>
  <?php include("0_dbheader.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <?php include("0_sidebar.php"); ?>
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
                  <h3>บันทึกงาน</h3>
                </strong>
                <ul>
                  <li><a href="datatable_equipment.php">บักทึกอุปกรณ์</a></li>
                  <li><a href="datatable_warning.php">แจ้งซ่อม</a></li>
                  <li><a href="datargdrawing.php">ออกแบบ</a></li>
                </ul>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img src="images/Maintenance_IMG1.jpg" alt="Thumbnail" width="200" height="250">
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary-emphasis">
                  <h3>การผลิต</h3>
                </strong>
                <ul>
                  <li><a href="summaryproductdailyjob.php">ติดตามผลิต</a></li>
                  <li><a href="summaryproductclosedue.php">ผลิตใกล้ครบกำหนดส่ง</a></li>
                  <li><a href="summaryproductdiscontinue.php">ยังไม่เริ่มการผลิต</a></li>
                  <li><a href="summaryproductoverdue.php">เกินกำหนดส่งมอบ</a></li>
                </ul>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img src="images/product.jpg" alt="Thumbnail" width="200" height="250">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary-emphasis">
                  <h3>สโตร์</h3>
                </strong>
                <ul>
                  <li><a href="summarystocknotify.php">สต๊อกต่ำกว่าเกณฑ์</a></li>
                </ul>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img src="images/Maintenance_IMG1.jpg" alt="Thumbnail" width="200" height="250">
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script src="js/bootstrap-5.3.1.bundle.min.js"></script>
</body>

</html>