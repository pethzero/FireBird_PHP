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
  <!-- <link rel="preload" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"> -->
  <link rel="preload" href="css/fixedColumns.dataTables.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">


  <style>
    .offcanvas-body {
      max-height: 100vh;
      /* ให้สูงสุดเท่ากับความสูงของหน้าจอ */
      overflow-y: auto;
      /* เพิ่มการสกอลล์เมื่อเนื้อหาเกิน */
    }

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

        <form id="idForm" method="POST">

          <section>

            <div class="row pt-2 mb-2">
              <div class="col-md-12">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                  <div class="col p-4 d-flex flex-column position-static">


                    <div class="row">
                      <h3>รายงานใบสั่งผลิตเกินกำหนดส่งมอบ</h3>
                    </div>


                    <div class="row">
                      <div class="col-12">
                        <table id="table_datahd" class="nowrap table table-striped table-bordered    align-middle " width='100%'>
                          <thead class="thead-light">
                            <tr>
                              <th>ลำดับ</th>
                              <th>เลขที่ใบสั่งผลิต</th>
                              <th>วันที่สั่งผลิต</th>
                              <th>กำหนดเสร็จ</th>
                              <th>ผลิตครั้งล่าสุด</th>
                              <th>เกินเวลา (วัน)</th>
                              <th>ผู้ผลิต</th>
                              <th>ลูกค้า</th>
                              <th>สินค้าผลิต</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>




                  </div>
                </div>
              </div>
            </div>
    </div>
    </section>
    <div class="loading" style="display: none;"></div>
    </form>

    </main>
  </div>
  </div>

</body>
<?php include("0_footerjs_piority.php"); ?>
<script src="js/systemdtcolum.js"></script>
<script src="js/dataTables.fixedColumns.min.js"></script>
<script>
  $(document).ready(function() {

    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });
    $('.loading').show();

    var qid = 'JOBOVERDUE'; //
    var condotion_id = '000'; //
    var datasave = '';


    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    var tabledatahd = $('#table_datahd').DataTable({
      // scrollCollapse: true,
      scrollX: true,
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + 1;
          }
        },
        {
          data: 'DOCNO',
        },
        {
          data: 'DOCDATE',
          render: function(data, type, row) {
            return formatDate(data);
          }
        },
        {
          data: 'COMPDATE',
          render: function(data, type, row) {
            return formatDate(data);
          }
        },
        {
          data: 'STEPSTART',
          render: function(data, type, row) {
            return formatDate(data);
          }
        },
        {
          data: 'DAYOVER',
        },
        {
          data: 'EMPNAME',
        },
        {
          data: 'CUSTNAME',
        },
        {
          data: 'PRODNAME',
        },
      ],
      columnDefs: [

        {
          "visible": false,
          "targets": [0]
        },

      ],
      // order: [
      //   [3, 'desc'],
      // ],
    });

    var fecthdata;
    fecth_databased();
    async function fecth_databased() {
      Param = [];
      Param.push({
        dateperiod: 3
        // datebegin: data_begin,
        // dateend: date_end
      })
      var formData = new FormData();
      try {
        // ดึงข้อมูล Excel จากเซิร์ฟเวอร์
        const jsonResponse = await fetch('ajax/post_fb_select_qt.php', {
          method: 'POST',
          body: set_formdata('select'),
        });

        if (!jsonResponse.ok) {
          $('.loading').hide();
          throw new Error('Error sending data to server');
        }
        jsonPush = []
        const jsonDataHD = await jsonResponse.json();
        fecthdata = jsonDataHD.datasql
        // console.log(jsonDataHD.datasql)
        // console.log(jsonDataHD)
        tabledatahd.clear().rows.add(fecthdata).draw();
        console.log(ProcesssMatchData(fecthdata))

        // await allsum(jsonDataHD.datasql)
        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }
    var Param;


    function set_formdata(conditionsformdata) {
      var formData = new FormData();
      if (conditionsformdata == "select") {
        formData.append('queryIdHD', qid);
        formData.append('condition', condotion_id);
      } else {}
      formData.append('Param', JSON.stringify(Param));
      ////////////////
      return formData;
    }

    $('#idForm').on('submit', function(e) {
      e.preventDefault(); // ป้องกันการส่ง form ไปยังหน้าอื่น
      // ตรวจสอบว่าปุ่มที่ถูกคลิกคือ "save" หรือ "edit"
      let url = "";
      let status_sql = "";
      var clickedButtonName = e.originalEvent.submitter.name;
    });


    function ProcesssMatchData(data) {
      const mappedData = data.map((item) => {
        return {
          docno: item.DOCNO,
        };
      });
      return mappedData;
    }


    ////////////////////////////////////////////////// CHART  //////////////////////////////////////////////////
    $('#backhis').click(function() {
      window.location = 'main.php';
    });

    $('#detailhis').click(function() {
      window.location = 'datatable_invoice.php';
    });


    /////////////////////////////////////////////////////////////////////////////////////////////////////////


  });
</script>



</html>