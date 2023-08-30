<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  session_start();
  //  echo $_SESSION["RECNO"];
  if (!isset($_SESSION["RECNO"])) {
    header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
  }
  include("0_headcss.php");
  $csrfToken = bin2hex(random_bytes(32)); // สร้าง token สุ่ม
  $_SESSION['csrf_token'] = $csrfToken;
  // $_SESSION['csrf_token'] = keyse();
  ?>
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
</head>

<body>
  <?php
  include("0_header.php");
  include("0_breadcrumb.php");

  ?>
  <link rel="stylesheet" href="css/mycustomize.css">
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
  </style>

  <?php
  include("connect_sql.php");
  ?>

  <section>
    <div class="container pt-3">

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>

      <h2>อุปกรณ์และเครื่องจักร</h2>
      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <div class="input-group date mb-3" id="datepicker_search">
            <span class="input-group-append">
              <span class="input-group-text bg-light d-block">
                <i class="fa fa-calendar"></i>
              </span>
            </span>
            <input type="text" class="form-control" id="date_search" readonly />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <div class="input-group mb-3">
            <span class="input-group-text c_activity">สถานะ:</span>
            <select class="form-select" id="statusseacrh">
              <option value="" selected>เลือก...</option>
              <option value="ยังไม่เริ่มดำเนินการ">ยังไม่เริ่มดำเนินการ</option>
              <option value="อยู่ระหว่างดำเนินการ">อยู่ระหว่างดำเนินการ</option>
              <option value="รอดำเนินการ">รอดำเนินการ</option>
              <option value="ถูกเลื่อนออกไป">ถูกเลื่อนออกไป</option>
              <option value="เสร็จสิ้น">เสร็จสิ้น</option>
            </select>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='seacrh' type="button" class="btn btn-primary">ค้นหา</button>
        </div>
      </div>

      <hr>

      <div class="row pb-3">
        <!-- <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='new' type="button" class="btn btn-primary">เพิ่มอุปกรณ์</button>
        </div> -->
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <button id='newmodel' type="button" class="btn btn-primary">เพิ่มอุปกรณ์และเครื่องจักร</button>
        </div>
      </div>

      <!-- <div class="row mb-3">
        <div class="col-sm-12 col-md-6 col-lg-6">
          <label for="searchInput" class="form-label">ค้นหารายการรหัสลูกค้า แบบกรอง</label>
          <div class="input-group">
            <select class="form-control select2" id="searchInput"></select>
            <button class="btn btn-primary" id="searchClear">ล้าง</button>
          </div>
        </div>
      </div> -->


      <div class="row">
        <div class="col-12">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle" width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ข้อมูล</th>
                <th>เลขที่</th>
                <!-- <th>สถานะ</th>
                <th>บริษัท</th>
                <th>ผู้ติดต่อ</th>
                <th>วันที่นัดหมาย</th>
                <th>ความสำคัญ</th>
                <th>ราคาเบิก</th>
                <th>ราคาจ่าย</th>
                <th>ผู้นัดหมาย</th> -->

              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>




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
  //  include("0_footer.php");
  ?>
  <form id="idForm" method="POST">
    <div class="modal fade" id="hq" aria-labelledby="hqLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-md modal-lg modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="hqLabel">อุปกรณ์ <span id='story' class="badge"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <!-- ส่วนที่เพิ่มเนื้อหาภายในกล่องโมดอลได้ที่นี่ -->
            <section>
              <div class="container-fluid">
                <!-- <div class="row pb-3">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                  <button id='backhis' type="button" class="btn btn-primary">กลับดูอุปกรณ์</button>
                </div>
              </div> -->

                <!-- <h2 id="dataoffset">อุปกรณ์ <span id='story' class="badge"></span></h2>
              <hr> -->
                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">ชื่ออุปกรณ์:</span>
                      <input type="text" class="form-control" id="name" placeholder="ชื่ออุปกรณ์" maxlength="255">

                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">ประเภท:</span>
                      <input type="text" class="form-control" id="type" placeholder="ประเภท" maxlength="255">
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">รหัส:</span>
                      <input type="text" class="form-control" id="code" placeholder="รหัส" maxlength="50">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">ยี่ห้อ:</span>
                      <input type="text" class="form-control" id="model" placeholder="ยี่ห้อ" maxlength="50">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">บริษัท:</span>
                      <input type="text" class="form-control" id="cust" placeholder="ซื้อกับบริษัท" maxlength="255">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">บุคคล:</span>
                      <input type="text" class="form-control" id="cont" placeholder="ติดต่อบุคคล" maxlength="255">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">โทรศัทพ์:</span>
                      <input type="text" class="form-control" id="phone" placeholder="โทรศัทพ์" maxlength="150">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">อีเมล:</span>
                      <input type="text" class="form-control" id="email" placeholder="อีเมล" maxlength="150">
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">พื้นที่:</span>
                      <input type="text" class="form-control" id="area" placeholder="พื้นที่" maxlength="255">
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">คู่มือ:</span>
                      <input type="text" class="form-control" id="docno" placeholder="คู่มือ" maxlength="255">
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="row">
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text c_activity">สถานะ:</span>
                          <select class="form-select" id="status">
                            <option value="A" selected>ปกติ</option>
                            <option value="P">ดูแล</option>
                            <option value="E">เสียหาย</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text c_activity">ความสำคัญ:</span>
                          <select class="form-select" id="priority">
                            <option value="0" selected>เลือก...</option>
                            <option value="H">สูง</option>
                            <option value="N">ปกติ</option>
                            <option value="L">ต่ำ</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="row">
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text c_activity">ประกัน:</span>
                          <input type="number" class="form-control" id="warranty" min=0 placeholder="อายุประกัน" step="1">
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text c_activity">การบำรุง:</span>
                          <input type="number" class="form-control" id="maintenance" min=0 placeholder="จำนวนการบำรุง" step="1">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="input-group">
                    <span class="input-group-text">รายละเอียด:</span>
                    <textarea id="detail" class="form-control h_textarea" rows="3" aria-label="textarea a"></textarea>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group date mb-3" id="datepicker">
                      <span class="input-group-text c_activity">วันที่ซื้อ:</span>
                      <input type="text" class="form-control" id="date" placeholder="วันที่ซื้อสินค้า" />
                      <span class="input-group-append">
                        <span class="input-group-text bg-light d-block">
                          <i class="fa fa-calendar"></i>
                        </span>
                      </span>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group date mb-3" id="datepicker_first">
                      <span class="input-group-text c_activity">วันที่เริ่มต้น:</span>
                      <input type="text" class="form-control" id="date_first" placeholder="วันที่เริ่มต้น" />
                      <span class="input-group-append">
                        <span class="input-group-text bg-light d-block">
                          <i class="fa fa-calendar"></i>
                        </span>
                      </span>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group date mb-3" id="datepicker_last">
                      <span class="input-group-text c_activity">ดูแลล่าสุด:</span>
                      <input type="text" class="form-control" id="date_last" placeholder="วันที่ดูแลล่าสุด" />
                      <span class="input-group-append">
                        <span class="input-group-text bg-light d-block">
                          <i class="fa fa-calendar"></i>
                        </span>
                      </span>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text ">ผู้บันทึก:</span>
                      <select class="form-select" id="owner">
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3">
                    <label for="formFile" class="form-label">แนบเอกสาร</label>
                    <input class="form-control" type="file" id="fileToUpload">
                  </div>
                </div>

                <div class="row">
                  <div class="">
                    <label for="fileLabel" class="form-label" id="fileLabel"> </label>
                    <!-- <label for="formFile" class="form-label">แนบเอกสาร</label>
                    <input class="form-control" type="file" id="fileToUpload"> -->
                  </div>
                </div>

              </div>
            </section>
          </div>

          <div class="modal-footer">
            <button id="ok" type="submit" class="btn btn-primary">บันทึก</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
          </div>
        </div>
      </div>
    </div>
    </div>

    <!-- <div class="loading"> -->

</body>
<?php include("0_footerjs.php"); ?>
<script src="js/dtcolumn.js"></script>


<script>
  $(document).ready(function() {

    // รับ element input จาก DOM
    var fileInput = document.getElementById('fileToUpload');

    // เพิ่ม event listener เมื่อมีการเลือกไฟล์
    fileInput.addEventListener('change', function(event) {
      var file = event.target.files[0]; // ไฟล์ที่ถูกเลือก

      // ตรวจสอบขนาดไฟล์ (10MB)
      if (file.size > 10 * 1024 * 1024) {
        alert('ไฟล์ขนาดเกิน 10MB ไม่ได้รับอนุญาต');
        fileInput.value = ''; // ล้างค่า input ให้สามารถเลือกไฟล์ใหม่ได้
        return;
      }

      // ตรวจสอบประเภทไฟล์ (pdf, png)
      var allowedTypes = ['application/pdf', 'image/jpg', 'image/png', 'image/jpeg', 'image/gif'];
      if (!allowedTypes.includes(file.type)) {
        alert('รูปแบบไฟล์ไม่ได้รับอนุญาต (รองรับเฉพาะ PDF , JPG, PNG , และ GIF)');
        fileInput.value = ''; // ล้างค่า input ให้สามารถเลือกไฟล์ใหม่ได้
        return;
      }
      // ทำสิ่งที่ต้องการเมื่อไฟล์ผ่านการตรวจสอบ
      // ตัวอย่างเช่น ส่งไฟล์ไปยังเซิร์ฟเวอร์ หรือประมวลผล
    });

    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });

    var recno = null;
    var qid = 'SEL_EQUIPMENT';
    var startd = null;
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;
    var datasave = '';

    var recno_owner = 0;
    var recno_nowner = "";
    var recno_edit;

    var encodedURL_Select = encodeURIComponent('ajax_select_sql_mysql.php');
    var encodedURL_Insert = 'ajax/ajaxinsertnew.php';
    var encodedURL_Update = 'ajax/ajaxupdatenew.php';


    $(function() {
      select2_owner_list();


      $("#date_search").datepicker({
        format: "dd/mm/yyyy",
        clearBtn: true,
        todayHighlight: true,
        autoclose: true
      });
    });

    // function Operation(optdata) {
    //   select2_owner_list()
    // }

    function matchCustom_ajax(params, data) {
      if ($.trim(params.term) === '') {
        return data;
      }
      var inputText = params.term.toLowerCase().replace(/\s/g, '');
      var optionText = data.text.toLowerCase().replace(/\s/g, '');

      var optionTitle = data.title.toLowerCase().replace(/\s/g, '');
      if (typeof data.value === 'string') {
        // ทำสิ่งที่คุณต้องการเมื่อ data.value เป็น string
        var optionValue = data.value.toLowerCase().replace(/\s/g, '');
        if (optionText.indexOf(inputText) > -1 || optionValue.indexOf(inputText) > -1 || optionTitle.indexOf(inputText) > -1) {
          return data;
        }
      } else {
        if (optionText.indexOf(inputText) > -1 || optionTitle.indexOf(inputText) > -1) {
          return data;
        }
        // ทำสิ่งที่คุณต้องการเมื่อ data.value ไม่ใช่ string
      }
      return null;
    }

    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    $('#new').click(function() {
      // window.location = 'dataactivity.php';
      window.location = 'dataequipment.php';
    });

    // var encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');
    var encodeData = "<?php echo $csrfToken; ?>";

    function secertkey() {
      return encodeData;
    }

    var encodedURL = encodeURIComponent('ajax_select_sql_mysql.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      ajax: {
        url: encodedURL,
        data: function(d) {
          d.queryId = qid; // ส่งค่าเป็นพารามิเตอร์ queryId
          d.params = null;
          // d.params = {
          //   // RECNO:recno,
          //   STARTD: startd,
          // };
          d.condition = '';
          d.sqlprotect = encodeData;
        },
        dataSrc: function(json) {
          // console.log(json)
          tablejsondata = json.data;
          return json.data;
        }
      },
      scrollX: true,
      columns: dtcolumn['DATA_EQUIPMENT'],
      columnDefs: [{
          className: 'noVis',
          targets: [0]
        },
        // {
        //   className:'dt-center',
        //   targets: [2]
        // },
        // {
        //   "visible": false,
        //   "targets": 0
        // },
      ],
      order: [
        [0, 'desc'],
      ],
      dom: 'Bfrtip',
      buttons: [{
          extend: 'colvis',
          text: 'Show/Hide',
          columns: ':not(.noVis)',
          // columnText: function ( dt, idx, title ) {
          // return (idx+1)+': '+title;
          // }
        },
        //  'csv', 
        {
          extend: 'excelHtml5',
          title: 'Data export',
          exportOptions: {
            // columns: [ 2, 3,4,5,6,7,8,9,10 ]
            columns: [1, 2]
          }
        }
      ],

      initComplete: function(settings, json) {
        // $('.loading').hide();
      },
      createdRow: function(row, data, dataIndex) {

      },
      drawCallback: function(settings) {

      },
      rowCallback: function(row, data) {
        $(row).on('click', function() {
          if (selectedRow !== null) {
            $(selectedRow).removeClass('table-custom');
          }
          $(this).addClass('table-custom');
          selectedRow = this;

          if (selectedRecno !== data.RECNO) {
            // เช็คว่ามีแถวที่ถูกเลือกอยู่หรือไม่
            selectedRecno = data.RECNO;
          }
        });
      },
    });


    $('#table_datahd').on('click', '.edit', function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      $('#ok').removeClass('btn-primary').addClass('btn-danger').text('บันทึกแก้ไข');
      $('#story').removeClass('bg-secondary').addClass('bg-danger').text('แก้ไข');
      // recno_edit = rowData.RECNO;
      datasave = 'edit';
      search_equipment(rowData.RECNO);
      $("#hq").modal("show");

    });



    $("#datepicker").datepicker({
      format: "dd/mm/yyyy",
      clearBtn: true,
      todayHighlight: true,
      autoclose: true
    });

    $("#datepicker_first").datepicker({
      format: "dd/mm/yyyy",
      clearBtn: true,
      todayHighlight: true,
      autoclose: true
    });

    $("#datepicker_last").datepicker({
      format: "dd/mm/yyyy",
      clearBtn: true,
      todayHighlight: true,
      autoclose: true
    });



    $('#seacrh').click(function() {
      // var dateValue = $('#date_search').val();
      $('#date_search').val('');
      // $('#date').val('');
      // $('#date_first').val('');
      // $('#date_last').val('');
    })



    $('#date_search').val(moment(new Date()).format('DD/MM/YYYY'));

    $("#newmodel").click(function() {
      $('#ok').removeClass('btn-danger').addClass('btn-primary').text('บันทึก');
      $('#story').removeClass('bg-danger').addClass('bg-secondary').text('เพิ่ม');
      // <button id="ok" type="submit" class="btn btn-primary">บันทึก</button>

      datasave = 'save';
      recno_owner = 0;
      $uploadolddb = '';
      $('#name').val('');
      $('#type').val('');
      $('#code').val('');
      $('#model').val('');
      $('#cust').val('');
      $('#cont').val('');
      $('#phone').val('');
      $('#email').val('');
      $('#area').val('');
      $('#docno').val('');
      $('#status').val('A');
      $('#priority').val('0');
      $('#warranty').val(0);
      $('#maintenance').val(0);
      $('#detail').val('');
      $('#owner').val(0).trigger('change');
      $('#date').val('');
      $('#date_first').val('');
      $('#date_last').val('');
      $('#fileToUpload').val('');
      $("#hq").modal("show"); // เปิดกล่องโมดอล
    });

    // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
    $(".modal .btn-secondary, .modal .btn-close").click(function() {
      $("#hq").modal("hide"); // ปิดกล่องโมดอล
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ///////////////////////////////////////////////////////////////// SELECT DATA //////////////////////////////////////////////////////////////////////////////////////////
    function select2_owner_list() {
      $.ajax({
        url: encodedURL_Select,
        data: {
          queryId: 'EMPL_LIST',
          params: null,
          condition: 'mix',
        },
        dataSrc: '',
        success: function(response) {
          // console.log(response)
          owner_list = JSON.parse(response).data;
          data_owner_name = data_json(owner_list, 'RECNO', 'EMPNO', 'EMPNAME'); // กำหนดค่าใหม่ให้กับ data_owner_name
          createSelect_owner('#owner', data_owner_name)
          owner_process = 1;
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    function createSelect_owner(selector, data) {
      return $(selector).select2({
        data: data,
        theme: 'bootstrap-5',
        matcher: matchCustom_ajax,
        templateSelection: function(selected) {
          if (selected.id !== '') {
            if (selected.id == 0) {
              return 'เลือกชื่อผู้รับผิดชอบงาน...';
            }
            return selected.text;
          }
          return '';
        },
        templateResult: function(result) {
          if (!result.id) {
            return result.text;
          }
          var $result = $('<span></span>');
          $result.text("รหัส" + result.title + ":" + result.text);
          if (result.id == 0) {
            $result.text('เลือกชื่อผู้รับผิดชอบงาน...');
            return $result;
          } else {
            return $result;
          }
        }
      });
    }

    function data_json(data_list, recno_key, code_key, name_key) {
      var target_list = [{
        "id": 0,
        "text": "เลือกชื่อผู้รับผิดชอบงาน...",
        "value": "0",
        "title": ""
      }];
      var existingCodes = {};
      for (var i = 0; i < data_list.length; i++) {
        var select2_recno = data_list[i][recno_key];
        var select2_code = data_list[i][code_key];
        var select2_name = data_list[i][name_key];
        if (select2_name != '') {
          if (!existingCodes[select2_code]) {
            target_list.push({
              "id": parseInt(select2_recno),
              "text": select2_name,
              "value": select2_recno,
              "title": select2_code,
            });
            existingCodes[select2_code] = true;
          }
        }
      }
      return target_list; // คืนค่า target_list กลับไป
    }

    //////////////////////////////////////////////////////////////// CHANGE //////////////////////////////////////////////////////////////// 
    var owner_process = 0;
    $("#owner").change(function() {
      recno_owner = $(this).select2('data')[0].value;
      if (recno_owner == -1) {
        recno_nowner = '';
      } else {
        recno_nowner = $(this).select2('data')[0].text;
      }
    });

    //////////////////////////////////////////////////////////////// SAVE ///////////////////////////////////////////////////////////////

    $("#idForm").submit(function(event) {
      event.preventDefault();
      if ($('#name').val().trim() == '') {
        Swal.fire(
          'กรุณาเลือกชื่อใส่ชื่ออุปกรณ์',
          'ไม่สามารถบันทึกได้',
          'error'
        )
        return false
      }
      AlertSave()
    });

    var paramhd;
    /////////////////////////////////////////////////////////////// INSERT AND UPDATE ///////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// SAVE //////////////////////////////////////////////////////////////
    function SaveData() {
      $.ajax({
        url: encodedURL_Insert,
        type: "POST",
        data: set_formdata('save'),
        dataSrc: '',
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {},
        complete: function() {},
        success: function(response) {
          // console.log(response);
          // save_json = JSON.parse(response);
          save_json = JSON.parse(response);
          // console.log(save_json);
          if (save_json.status == 'success') {
            Swal.fire({
              title: "บันทึกแล้ว",
              text: "ข้อความที่คุณต้องการแสดง",
              icon: "success",
              buttons: ["OK"],
              dangerMode: true,
            }).then(function(willRedirect) {
              // willRedirect คือค่า boolean ที่บอกว่าผู้ใช้เลือก OK (true) หรือยกเลิก (false)
              var newData = {
                RECNO: save_json.autoIncrementValue, // หรือค่า recno ที่คุณต้องการกำหน
                ID: String((new Date().getFullYear() + 543) % 100) + '/' + String(save_json.autoIncrementValue).padStart(4, '0')
              }
              table.row.add(newData).draw(); // เพิ่มแถวใหม่ใน DataTable และวาดใหม่
              // ซ่อน Modal หลังจากบันทึก
              if (willRedirect) {
                $('#hq').modal('hide');
              }
            });
            setTimeout(function() {
              swal.close(); // ปิด SweetAlert
              $('#hq').modal('hide');
            }, 2000);
            /////////////////////////////////
          } else {
            Swal.fire(
              'เกิดปัญหาในการบันทึก',
              JSON.parse(response).message,
              'error'
            )
          }
        },
        error: function(xhr, status, error) {
          console.log('error')
          console.error(error);
        }
      });
    }
    ////////////////////////////////////////////////////////////// UPDATE //////////////////////////////////////////////////////////////

    function UpdateData() {
      $.ajax({
        url: encodedURL_Update,
        type: "POST",
        data: set_formdata('edit'),
        dataSrc: '',
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function() {},
        complete: function() {},
        success: function(response) {
          // console.log(response);
          // save_json = JSON.parse(response);
          save_json = JSON.parse(response);
          console.log(save_json);
          if (save_json.status == 'success') {
            // console.log(paramhd)
            table.ajax.reload();
            console.log('success')

            Swal.fire({
              title: "บันทึกแล้ว",
              text: "ข้อความที่คุณต้องการแสดง",
              icon: "success",
              buttons: ["OK"],
              dangerMode: true,
            }).then(function(willRedirect) {
              // willRedirect คือค่า boolean ที่บอกว่าผู้ใช้เลือก OK (true) หรือยกเลิก (false)
              if (willRedirect) {
                // ถ้าผู้ใช้เลือก OK ให้เปลี่ยนหน้าไปยัง "datatable_activity.php"
                $('#hq').modal('hide');
              }
            });
            /////////////////////////////////
          } else {
            Swal.fire(
              'เกิดปัญหาในการบันทึก',
              // response.message,
              JSON.parse(response).message,
              'error'
            )
          }
        },
        error: function(xhr, status, error) {
          console.log('error')
          console.error(error);
        }
      });
    }

    var modify = 'F';
    ////////////////////////////////////////////////////////////// set_formdata //////////////////////////////////////////////////////////////
    function set_formdata(conditionsformdata) {
      var formData = new FormData();
      formData.append('name', $('#name').val());

      /// upload ///
      var selectedFile = $('#fileToUpload')[0].files[0];
      if (selectedFile) {
        formData.append('fileToUpload', selectedFile);
        modify = 'T';
      } else {
        modify = 'F';
      }
      // else
      // {
      // }
      /////////////

      var purchaseValue = $('#date').val();
      var firstUsageValue = $('#date_first').val();
      var lastUsageValue = $('#date_last').val();

      /// id ,param ///
      paramhd = {
        RECNO: recno_edit,
        // IDEDIT: '5555',
        NAME: $('#name').val(),
        TYPE: $('#type').val(),
        CODE: $('#code').val(),
        MODEL: $('#model').val(),
        CUSTNAME: $('#cust').val(),
        CONTNAME: $('#cont').val(),
        PHONE: $('#phone').val(),
        EMAIL: $('#email').val(),
        AREA: $('#area').val(),
        DOCINFO: $('#docno').val(),
        STATUS: $('#status').val(),
        PRIORITY: $('#priority').val(),
        WARRANTY: $('#warranty').val(),
        MAINTENANCETIMES: $('#maintenance').val(),
        BROKENTIMES: '',
        DETAILS: $('#detail').val(),
        PURCHASEDATE: purchaseValue ? moment(purchaseValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
        FIRSTUSAGE: firstUsageValue ? moment(firstUsageValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
        LASTUSAGE: lastUsageValue ? moment(lastUsageValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
        // FIRSTUSAGE: moment($('#date_first').val(), 'DD/MM/YYYY').format('YYYY-MM-DD'),
        RECORDERNO: recno_owner,
        RECORDERNAME: recno_nowner,
      };
      // console.log(paramhd);
      // var paramhd = null;
      // เพิ่มอาร์เรย์ paramhd เข้าไปใน FormData และแปลงเป็น JSON ก่อน

      if (conditionsformdata == "save") {
        // ประมวลผลเพิ่มข้อมูล
        // process to insert data
        formData.append('queryIdHD', 'EQUIPMENT');

      } else if (conditionsformdata == "delete") {
        // ประมวลผลลบข้อมูล
        // process to delete data
      } else {
        formData.append('queryIdHD', 'UPD_EQUIPMENT');
        // กรณีอื่น ๆ
        // other cases
      }
      formData.append('queryIdDT', '');
      formData.append('condition', 'IHD');
      formData.append('uploadnamedb', 'equipment');
      formData.append('uploadolddb', $uploadolddb);
      formData.append('modify', modify);

      formData.append('paramhd', JSON.stringify(paramhd));
      ////////////////
      return formData;
    }

    ////////////////////////////////////////////////////////////// UPDATE //////////////////////////////////////////////////////////////
    function AlertSave() {
      Swal.fire({
        title: 'คุณแน่ใจแล้วใช่ไหม',
        text: "คุณจะเปลี่ยนกลับไม่ได้!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ตกลงบันทึก',
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        customClass: {
          confirmButton: 'ok',
          cancelButton: 'cancel'
        },
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          if (datasave == "save") {
            SaveData()
            // console.log('save')
          } else {
            UpdateData()
          }

        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          Swal.fire(
            'ยกเลิก',
            'ยังไม่มีการบันทึก',
            'error'
          )
        }
      })
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function search_equipment(data_equipment) {
      $.ajax({
        url: encodedURL_Select,
        data: {
          queryId: 'EDSEL_EQUIPMENT',
          params: {
            RECNO: data_equipment
          },
          condition: 'mix',
        },
        dataSrc: '',
        success: function(response) {
          // console.log(response)
          json_equipment = JSON.parse(response).data;
          // console.log(json_equipment)
          // console.log(json_equipment[0].NAME)
          recno_edit = json_equipment[0].RECNO;
          $('#name').val(json_equipment[0].NAME);
          $('#type').val(json_equipment[0].TYPE);
          $('#code').val(json_equipment[0].CODE);
          $('#model').val(json_equipment[0].MODEL);
          $('#cust').val(json_equipment[0].CUSTNAME);
          $('#cont').val(json_equipment[0].CONTNAME);
          $('#phone').val(json_equipment[0].PHONE);
          $('#email').val(json_equipment[0].EMAIL);
          $('#area').val(json_equipment[0].AREA);
          $('#docno').val(json_equipment[0].DOCINFO);
          $('#status').val(json_equipment[0].STATUS);
          $('#priority').val(json_equipment[0].PRIORITY);
          $('#warranty').val(json_equipment[0].WARRANTY);
          $('#maintenance').val(json_equipment[0].MAINTENANCETIMES);
          $('#detail').val(json_equipment[0].DETAILS);
          $('#owner').val(json_equipment[0].RECORDERNO).trigger('change');
          $('#fileToUpload').val('');
          $('#date').val(moment(json_equipment[0].PURCHASEDATE).format('DD/MM/YYYY') !== 'Invalid date' ? moment(json_equipment[0].PURCHASEDATE).format('DD/MM/YYYY') : '');
          $('#date_first').val(moment(json_equipment[0].FIRSTUSAGE).format('DD/MM/YYYY') !== 'Invalid date' ? moment(json_equipment[0].FIRSTUSAGE).format('DD/MM/YYYY') : '');
          $('#date_last').val(moment(json_equipment[0].LASTUSAGE).format('DD/MM/YYYY') !== 'Invalid date' ? moment(json_equipment[0].LASTUSAGE).format('DD/MM/YYYY') : '');


          owner_process = 1;
          if (json_equipment[0].UPLOAD) {
            $uploadolddb = json_equipment[0].UPLOAD;
            $("#fileLabel").html('โหลดไฟล์แนบเอกสาร: <a id="downloadLink" href="uploads/' + json_equipment[0].UPLOAD + '" download>Download Here</a>');
          } else {
            $uploadolddb = '';
            $("#fileLabel").html('โหลดไฟล์แนบเอกสาร: ไม่มี');
          }

        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }


       ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////
      //  $('html, body').animate({
      //       scrollTop: $('#dataoffset').offset().top
      //   }, 100); // ค่าความเร็วในการเลื่อน (มิลลิวินาที)

        $('#backhis').click(function() {
            window.location = 'main.php';
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////


  });
</script>

</html>