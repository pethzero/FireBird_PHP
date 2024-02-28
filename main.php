<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="assets/js/color-modes.js"></script>
  <script src="js/system_main.js"></script>

  <?php
  session_start();
  if (!isset($_SESSION["RECNO"])) {
    header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
  }
  include("0_headcss.php");
  ?>
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }
  </style>
  <link href="layout/bs5/dashboard.css" rel="stylesheet">
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

        <!-- <button type="button" id="test">TEST</button> -->
        <div class="row mb-2" id="head">
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
                <img src="images/main/marketing.png"  onerror="imageFailed(event)" alt="Thumbnail" width="200" height="250">
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
                <img src="images/main/slae.png"  onerror="imageFailed(event)" alt="Thumbnail" width="200" height="250">
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
                <img src="images/main/takenote.png"  onerror="imageFailed(event)" alt="Thumbnail" width="200" height="250">
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
                <img src="images/main/i_production.jpg"  onerror="imageFailed(event)" alt="Thumbnail" width="200" height="250">
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
                <img src="images/main/i_store.jpg"  onerror="imageFailed(event)" alt="Thumbnail" width="200" height="250">
              </div>
            </div>
          </div>


          <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                <strong class="d-inline-block mb-2 text-primary-emphasis">
                  <h3>บุคคล</h3>
                </strong>
                <ul>
                  <?php
                  if ($_SESSION['USERLEVEL'] === 'S') {
                  ?>
                    <li><a href="dataempl.php">บุคคล</a></li>
                  <?php
                  }
                  ?>
                  <li><a href="dataempl_stop.php">ประวัติการลา</a></li>
                  <li><a href="datacustomer.php">ใบวางบิลลูกค้า</a></li>
                </ul>
              </div>
              <div class="col-auto d-none d-lg-block">
                <img src="images/main/i_humanresource.png" onerror="imageFailed(event)" alt="Thumbnail" width="200" height="250">
                <!-- <img src="" onerror="imageFailed(event)" alt="Thumbnail" width="200" height="250"> -->
              </div>
            </div>
          </div>


        </div>

        <div class="row mb-2" id="detail">

        </div>

      </main>
    </div>
  </div>
  <script src="js/bootstrap-5.3.1.bundle.min.js"></script>
</body>
<script>
 var dataArray = [
    {
      id: 1,
      code: "M",
      head: "สโตร์",
      list: [{ link: "summarystocknotify.php", text: "สต๊อกต่ำกว่าเกณฑ์" }],
      img: "images/Maintenance_IMG1.jpg"
    },
    {
      id: 2,
      code: "L",
      head: "A2",
      list: [{ link: "A2", text: "A2" }],
      img: "images/Maintenance_IMG1.jpg"
    }
  ];

  // สร้าง div ตามข้อมูลใน Array
  // dataArray.forEach(item => {
  //   var div = document.createElement("div");
  //   div.className = "col-md-6";

  //   var innerHTML = `
  //     <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
  //       <div class="col p-4 d-flex flex-column position-static">
  //         <strong class="d-inline-block mb-2 text-primary-emphasis">
  //           <h3>${item.head}</h3>
  //         </strong>
  //         <ul>
  //   `;

  //   // เพิ่ม list items
  //   item.list.forEach(listItem => {
  //     innerHTML += `<li><a href="${listItem.link}">${listItem.text}</a></li>`;
  //   });

  //   innerHTML += `
  //         </ul>
  //       </div>
  //       <div class="col-auto d-none d-lg-block">
  //         <img src="${item.img}" alt="Thumbnail" width="200" height="250">
  //       </div>
  //     </div>
  //   `;

  //   div.innerHTML = innerHTML;

  //   document.getElementById("detail").appendChild(div);
  // });
</script>

</html>