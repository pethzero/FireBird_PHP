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
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <style>
    .c_activity {
      width: 100px;
    }

    .h_textarea {
      height: 110px;
    }

    textarea {
      overflow-y: scroll;
    }

    .datepicker td,
    th {
      text-align: center;
      padding: 8px 12px;
      font-size: 14px;
    }

    .datepicker {
      border: 1px solid black;
    }

    @media (min-width: 768px) {
      .custom-input-pc {
        width: 450px;
      }

      .btn-input {
        width: 120px;
      }

      .date-input {
        width: 140px;
      }
    }

    @media (max-width: 767px) {
      .custom-input-phone {
        width: 300px;
      }

      .company-input {
        width: 250px;
      }

      .detail-input {
        width: 300px;
      }

      .remark-input {
        width: 200px;
      }

      .date-input {
        width: 120px;
      }
    }

    .table-custom {
      --bs-table-color: #000;
      --bs-table-bg: #4caf50;
      --bs-table-border-color: #bacbe6;
    }

    .table-postpone {
      --bs-table-color: #000;
      --bs-table-bg: #ff980099;
      --bs-table-border-color: #bacbe6;
    }

    .bg-postpone {
      background-color: #ff6600;
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
      <div class="loading" style="display: none;"></div>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <form id="idForm" method="POST">
          <!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">ดาวโหลดส่วนเสริม</h1>
        </div> -->
          <div class="section">
            <div class="container-fluid">

              <!-- <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div> -->

              <div class="row mt-2">
                <div class="col-md-6">
                  <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                      <h3 class="mb-0">Test</h3>



                      <div class="row pt-3">
                        <div class="input-group ">
                          <span class="input-group-text">ชื่อไฟล์</span>
                          <input type="text" class="form-control" id="yourInputId" value="" maxlength="125" placeholder="ใส่ชื่อ">
                        </div>
                      </div>

                      <div class="row pt-3">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                          <button class="btn btn-success" id="save">save</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>



            </div>
          </div>
        </form>
      </main>
    </div>
  </div>
</body>
<?php include("0_footerjs_piority.php"); ?>
<script>
  $(document).ready(function() {
    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });

    // URL ที่ต้องการดึงข้อมูล JSON
    var jsonUrl = 'json/setting.json';

    // ใช้ Fetch API เพื่อดึงข้อมูล JSON
    fetch(jsonUrl)
      .then(response => response.json())
      .then(data => {
        // แสดงข้อมูล JSON ใน console
        console.log('ข้อมูล JSON:', data);

        // นำข้อมูลไปแสดงใน input
        $('#yourInputId').val(data.datasetting);
      })
      .catch(error => console.error('เกิดข้อผิดพลาดในการดึงข้อมูล:', error));


    // เมื่อมีการคลิกปุ่มบันทึก
    $('#save').on('click', function() {
      // ดึงค่าที่ต้องการบันทึกจาก input
      var newSettingValue = $('#yourInputId').val();
      console.log(newSettingValue)
      fetch(jsonUrl, {
        method: 'PUT', // หรือ 'POST' ตามที่เหมาะสม
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          datasetting: newSettingValue
        }),
      })


      // // ใช้ Fetch API เพื่อบันทึกข้อมูล JSON
      // fetch(jsonUrl, {
      //     method: 'PUT', // หรือ 'POST' ตามที่เหมาะสม
      //     headers: {
      //       'Content-Type': 'application/json',
      //     },
      //     body: JSON.stringify({
      //       datasetting: newSettingValue
      //     }),
      //   })
      //   .then(response => response.json())
      //   .then(data => console.log('บันทึกข้อมูลเรียบร้อย:', data))
      //   .catch(error => console.error('เกิดข้อผิดพลาดในการบันทึกข้อมูล:', error));
    });


    $('#idForm').on('submit', function(e) {
      e.preventDefault(); // ป้องกันการส่ง form ไปยังหน้าอื่น
      // ตรวจสอบว่าปุ่มที่ถูกคลิกคือ "save" หรือ "edit"
      let url = "";
      let status_sql = "";
      var clickedButtonName = e.originalEvent.submitter.name;
    });


    $('#backhis').click(function() {
      window.location = 'main.php';
    });


  });
</script>



</html>