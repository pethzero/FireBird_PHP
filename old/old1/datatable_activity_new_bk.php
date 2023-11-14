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

    /* body .select2-container--bootstrap-5 {
    z-index: 9999 !important;
} */
    .select2-close-mask {
      z-index: 2099;
    }

    .select2-dropdown {
      z-index: 3051;
    }
  </style>

  <?php
  include("connect_sql.php");
  ?>

  <section>
    <div class="container-fluid pt-3">

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>

      <h2>ตารางนัดหมาย</h2>
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

        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <button id='newmodel' type="button" class="btn btn-primary">ตารางนัดหมาย</button>
        </div>
      </div>




      <div class="row">
        <div class="col-12">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ข้อมูล</th>
                <th>เลขที่นัดหมาย</th>
                <th>สถานะ</th>
                <th>บริษัท</th>
                <th>ผู้ติดต่อ</th>
                <th>วันที่นัดหมาย</th>
                <th>ความสำคัญ</th>
                <th>ราคาเบิก</th>
                <th>ราคาจ่าย</th>
                <th>ผู้นัดหมาย</th>

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

  <form id="idForm" method="POST">
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm modal-md modal-lg modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">บันทึกแจ้งซ่อม <span id='story' class="badge"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <section>
              <div class="container-fluid">
                <h2 id="dataactivity">ตารางนัดหมาย <span id='story' class="badge"></span></h2>
                <hr>
                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">บริษัท:</span>
                      <select class="form-select" id="cust">
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <select class="form-select cont" id="cont">
                      </select>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">ลูกค้า:</span>
                      <input type="text" class="form-control" id="contname" placeholder="ลูกค้า">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">อ้างอิง:</span>
                      <input type="text" class="form-control" id="ref" placeholder="อ้างอิง">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">โทรศัทพ์:</span>
                      <input type="text" class="form-control" id="phone" placeholder="โทรศัทพ์">
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">อีเมล:</span>
                      <input type="text" class="form-control" id="email" placeholder="อีเมล">
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">

                    <div class="input-group ">
                      <span class="input-group-text">ตำแหน่งนัดหมาย</span>
                      <textarea id="addr" class="form-control h_textarea" rows="3" aria-label="With textarea"></textarea>
                    </div>

                    <div class="mt-2">
                      <label class="form-label">สถานที่ติดต่อ</label>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="location" id="location1" value='I' checked>
                        <label class="form-check-label" for="location1">
                          นอกสถานที่
                        </label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="location" id="locatio2" value='O'>
                        <label class="form-check-label" for="locatio2">
                          ภายในบริษัท
                        </label>
                      </div>
                    </div>
                  </div>
                </div>


                <div class="row mb-3">
                  <div class="input-group">
                    <span class="input-group-text c_activity">เรื่อง:</span>
                    <input type="text" class="form-control" id="subject" placeholder="หัวข้อที่นัดหมาย">
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="input-group">
                    <span class="input-group-text">รายละเอียด:</span>
                    <textarea id="detail" class="form-control h_textarea" rows="3" aria-label="textarea a"></textarea>
                  </div>
                </div>




                <div class="row ">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="row">
                      <div class="input-group mb-3">
                        <span class="input-group-text c_activity">สถานะ:</span>
                        <select class="form-select" id="status">
                          <option value="A" selected>ยังไม่เริ่มดำเนินการ</option>
                          <option value="I">อยู่ระหว่างดำเนินการ</option>
                          <option value="W">รอดำเนินการ</option>
                          <option value="D">ถูกเลื่อนออกไป</option>
                          <option value="F">เสร็จสิ้น</option>
                        </select>
                      </div>

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

                    <div class="row">
                      <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="input-group mb-3">
                          <label class="form-label mt-2">ระยะเวลา</label>
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">วัน:</span>
                          <input type="number" class="form-control" min=0 value=0 id="timed" placeholder="">
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">ชม:</span>
                          <input type="number" class="form-control" min=0 value=0 id="timeh" placeholder="">
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">น.:</span>
                          <input type="number" class="form-control" min=0 value=0 id="timem" placeholder="">
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">ค่าใช้จ่าย:</span>
                      <input id="pcost" type="number" min=0 class="form-control">
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">ค่าเบิก:</span>
                      <input id="pwithdraw" type="number" min=0 class="form-control">
                    </div>

                    <div class="input-group mb-3">
                      <span class="input-group-text ">เจ้าของนัดหมาย:</span>
                      <select class="form-select " id="owner">
                      </select>
                    </div>

                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group date mb-3" id="datepicker">
                      <span class="input-group-text c_activity">วันที่นัด:</span>
                      <input type="text" class="form-control" id="date" />
                      <span class="input-group-append">
                        <span class="input-group-text bg-light d-block">
                          <i class="fa fa-calendar"></i>
                        </span>
                      </span>
                    </div>
                  </div>

                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group date mb-3" id="datepicker_warn">
                      <span class="input-group-text ">วันที่แจ้งเตือน:</span>
                      <input type="text" class="form-control" id="datewarn" />
                      <span class="input-group-append">
                        <span class="input-group-text bg-light d-block">
                          <i class="fa fa-calendar"></i>
                        </span>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="row mb-3">
                  <div class="input-group">
                    <span class="input-group-text">หมายเหตุ:</span>
                    <textarea id="remark" class="form-control h_textarea" rows="3" aria-label="textarea a"></textarea>
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
  </form>
  <!-- <div class="loading"> -->

</body>
<?php include("0_footerjs.php"); ?>
<!-- <script src="js/dtcolumn.js"></script> -->

<script>
  $(document).ready(function() {
    // // รับ element input จาก DOM
    // var fileInput = document.getElementById('fileToUpload');

    // // เพิ่ม event listener เมื่อมีการเลือกไฟล์
    // fileInput.addEventListener('change', function(event) {
    //   var file = event.target.files[0]; // ไฟล์ที่ถูกเลือก

    //   // ตรวจสอบขนาดไฟล์ (10MB)
    //   if (file.size > 10 * 1024 * 1024) {
    //     alert('ไฟล์ขนาดเกิน 10MB ไม่ได้รับอนุญาต');
    //     fileInput.value = ''; // ล้างค่า input ให้สามารถเลือกไฟล์ใหม่ได้
    //     return;
    //   }

    //   // ตรวจสอบประเภทไฟล์ (pdf, png)
    //   var allowedTypes = ['application/pdf', 'image/jpg', 'image/png', 'image/jpeg', 'image/gif'];
    //   if (!allowedTypes.includes(file.type)) {
    //     alert('รูปแบบไฟล์ไม่ได้รับอนุญาต (รองรับเฉพาะ PDF , JPG, PNG , และ GIF)');
    //     fileInput.value = ''; // ล้างค่า input ให้สามารถเลือกไฟล์ใหม่ได้
    //     return;
    //   }
    //   // ทำสิ่งที่ต้องการเมื่อไฟล์ผ่านการตรวจสอบ
    //   // ตัวอย่างเช่น ส่งไฟล์ไปยังเซิร์ฟเวอร์ หรือประมวลผล
    // });

    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });

    var recno = null;
    var qid = 'SEL_ACTIVITYHD';
    var startd = null;
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;
    var datasave = '';

    var recno_owner = 0;
    var recno_nowner = "";

    var recno_cust = 0;
    var recno_namecust = "";

    var recno_cont = 0;
    var recno_namecont = "";

    var recno_edit;
    var recno_equipment = 0;
    var encodedURL_Select = encodeURIComponent('ajax_select_sql_mysql.php');
    var encodedURL_Insert = 'ajax/ajaxinsertnew.php';
    var encodedURL_Update = 'ajax/ajaxupdatenew.php';


    $(function() {

      select2_owner_list();
      select2_cust_list();

      var currentDate = new Date();
      currentDate.setYear(currentDate.getFullYear() + 543);

      $("#date_search").datepicker({
        format: "dd/mm/yyyy",
        language: "th",
        clearBtn: true,
        todayHighlight: true,
        autoclose: true
      });

    });


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

    const customButtonEdit = (data, type, row, idclass, idname) => {
      // return `<button class="btn btn-danger btn-sm ${idclass}" id="${row['RECNO']}">${idname}</button>`;
      return `<button class="btn btn-danger btn-sm ${idclass}" id="${row['RECNO']}"><i class="far fa-edit"></i></button>`;
      // return '';
    };


    const formatDate = (data) => {
      if (!data || data === '0000-00-00') {
        return '00/00/0000'; // ถ้าค่าว่างหรือไม่ถูกต้อง ส่งค่าว่างกลับไป
      }

      const dateObj = new Date(data);
      const day = dateObj.getDate();
      const month = dateObj.getMonth() + 1;
      const year = dateObj.getFullYear();
      // const formattedDate = `${(day < 10 ? '0' + day : day)}.${(month < 10 ? '0' + month : month)}.${year}`;
      const formattedDate = `${(day < 10 ? '0' + day : day)}/${(month < 10 ? '0' + month : month)}/${year}`;
      return formattedDate;
    };

    const formatCurrency = (amount) => {
      if (amount === '') {
        return '';
      }
      let formattedAmount = parseFloat(amount).toFixed(2);
      formattedAmount = formattedAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      formattedAmount += '฿';
      return formattedAmount;
    };

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
          tablejsondata = json.data;
          return json.data;
        }
      },
      scrollX: true,
      columns:
        // dtcolumn['DATA_ACTIVITYHD'],
        [{
            data: 'RECNO'
          },
          // {data: null,render: function(data, type, row){return "";}},
          {
            data: null,
            render: function(data, type, row) {
              return customButtonEdit(data, type, row, 'edit', 'แก้ไข');
            }
          },
          {
            data: 'DOCNO'
          },
          // {data: 'STATUS'},
          {
            data: null,
            render: function(data) {
              // return getStatusTextOther(data.STATUS, 'TABLEACTIVITYHD_STATUS');
              if (data.STATUS == 'A') {
                return '<h5><span class="badge bg-secondary mt-2">ยังไม่เริ่มดำเนินการ</span></h5>'
              } else if (data.STATUS == 'I') {
                return '<h5><span class="badge bg-info mt-2 text-dark">อยู่ระหว่างดำเนินการ</span></h5>';
              } else if (data.STATUS == 'W') {
                return '<h5><span class="badge bg-warning mt-2 text-dark">รอดำเนินการ</span></h5>';
              } else if (data.STATUS == 'D') {
                return '<h5><span class="badge bg-danger mt-2">ถูกเลื่อนออกไป</span></h5>';
              } else if (data.STATUS == 'F') {
                return '<h5><span class="badge bg-success mt-2">เสร็จสิ้น</span></h5>'
              } else {
                return '';
              }
            }
          },
          {
            data: 'CUSTNAME'
          },
          {
            data: 'CONTNAME'
          },
          // {data: 'STARTD',render: formatDate},
          {
            data: 'STARTD',
            render: formatDate
          },
          // {data: 'STARTD',render: formatDate,"sType": "date-uk"},
          // {data: 'PRIORITY'},
          {
            data: null,
            render: function(data) {
              // return getStatusTextOther(data.PRIORITY, 'TABLEACTIVITYHD_PRIORITY');
              if (data.PRIORITY == 'H') {
                return 'สูง';
              } else if (data.PRIORITY == 'N') {
                return 'ปกติ';
              } else if (data.PRIORITY == 'L') {
                return 'ต่ำ';
              } else {
                return '-';
              }
            }
          },
          {
            data: 'PRICECOST',
            render: formatCurrency
          },
          {
            data: 'PRICEPWITHDRAW',
            render: formatCurrency
          },
          {
            data: 'OWNERNAME'
          },
        ],
      columnDefs: [{
          className: 'noVis',
          targets: [0]
        },
        {
          className: 'dt-center',
          targets: [3]
        },
        {
          className: 'dt-right',
          targets: [8, 9]
        },
        {
          "orderable": false,
          "targets": 1
        },
        {
          type: 'currency',
          targets: 8
        },
        {
          "visible": false,
          "targets": [0, 2]
        },
        // { type: 'de_date', targets: 6 }
        {
          type: 'th_date',
          targets: 6
        }
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
        var api = this.api();
        api.rows().every(function(rowIdx, tableLoop, rowLoop) {
          var data = this.data();
          var variableT = data.STATUS; // แทน yourVariable ด้วยชื่อตัวแปรที่คุณต้องการตรวจสอบ

          if (variableT === 'T') {
            var row = api.row(rowIdx).node();
            $(row).addClass('table-secondary'); // แทน your-class ด้วยชื่อคลาสที่คุณต้องการเพิ่มให้กับแถว
          }
        });
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
      search_datalist(rowData.RECNO);
      $("#myModal").modal("show");

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

    $("#datepicker_warn").datepicker({
      format: "dd/mm/yyyy",
      clearBtn: true,
      todayHighlight: true,
      autoclose: true
    });



    $('#seacrh').click(function() {
      var dateValue = $('#date_search').val();

      if (dateValue) {
        startd = moment($('#date_search').val(), 'DD/MM/YYYY').format('DD/MM/YYYY')
      } else {
        startd = '';
      }

      // console.log(startd)


      $('#table_datahd').DataTable().column(6).search(startd).draw();
      $('#table_datahd').DataTable().column(3).search($('#statusseacrh').val()).draw();
    })

    $("#newmodel").click(function() {
      $('#ok').removeClass('btn-danger').addClass('btn-primary').text('บันทึก');
      $('#story').removeClass('bg-danger').addClass('bg-secondary').text('เพิ่ม');
      // <button id="ok" type="submit" class="btn btn-primary">บันทึก</button>



      datasave = 'save';
      recno_owner = 0;
      recno_nowner = '';
      recno_equipment = 0;

      recno_cust = 0;
      recno_namecust = "";
      recno_cont = 0;
      recno_namecont = "";

      $uploadolddb = '';

      $('#custname').val('');
      $('#name').val('');
      $('#contname').val('');

      $('#addr').val('')
      $('#ref').val('')
      $('#phone').val('');
      $('#email').val('');
      $('#subject').val('')

      $('#timed').val(0)
      $('#timeh').val(0)
      $('#timem').val(0)

      $('#status').val('A');
      $('#priority').val('0');
      $('#pcost').val(0);
      $('#pwithdraw').val(0);
      $('#detail').val('');
      $('#remark').val('');

      $('#date').val('');
      $('#datewarn').val('');
      // $('#custname').val('');
      process_select_cust = 0;
      search_cont = 0;
      $('#cust').val(0).trigger('change');
      $('#cont').empty().trigger("change");
      $('#owner').val(0).trigger('change');


      $("#myModal").modal("show"); // เปิดกล่องโมดอล
    });

    // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
    $(".modal .btn-secondary, .modal .btn-close").click(function() {
      $("#myModal").modal("hide"); // ปิดกล่องโมดอล
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
          owner_list = JSON.parse(response).data;
          data_owner_name = data_json(owner_list, 'RECNO', 'EMPNO', 'EMPNAME', 'เลือกชื่อผู้รับผิดชอบงาน...'); // กำหนดค่าใหม่ให้กับ data_owner_name
          createSelect2('#owner', data_owner_name, 'เลือกชื่อผู้รับผิดชอบงาน...')
          owner_process = 1;
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    function select2_cust_list() {
      $.ajax({
        url: encodedURL_Select,
        data: {
          queryId: 'CUST_LIST',
          params: null,
          condition: 'mix',
        },
        dataSrc: '',
        success: function(response) {
          cust_list = JSON.parse(response).data;
          data_cust_name = data_json(cust_list, 'RECNO', 'CODE', 'NAME', 'เลือกชื่อบริษัท...'); // กำหนดค่าใหม่ให้กับ data_owner_name
          createSelect2('#cust', data_cust_name, 'เลือกชื่อบริษัท...')
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    var process_select_cust;

    function select2_contact_list(recno_data) {
      $.ajax({
        // url: 'ajax_data_select.php',
        url: encodedURL_Select,
        data: {
          queryId: 'CUSTCONT_LIST',
          params: {
            CUST: recno_data
          },
          condition: 'mix',
        },
        dataSrc: '',
        success: function(response) {
          cont_list = JSON.parse(response).data;
          if (cont_list.length > 0) {
            process_select_cust = 1
          }
          data_cont_name = data_json(cont_list, 'RECNO', 'RECNO', 'CONTNAME', 'เลือกชื่อลูกค้า...'); // กำหนดค่าใหม่ให้กับ data_owner_name
          createSelect2('#cont', data_cont_name, 'เลือกชื่อลูกค้า...')
          if (search_cont === 1) {
            $('#cont').val(recno_cont).trigger('change');
            search_cont = 0;
          }

        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    ///////////////////////////////
    function createSelect2(selector, data, gettextselect) {
      return $(selector).select2({
        data: data,
        theme: 'bootstrap-5',
        dropdownParent: $('#myModal .modal-content'),
        // dropdownParent: $(this).parent(),
        matcher: matchCustom_ajax,
        templateSelection: function(selected) {
          if (selected.id !== '') {
            if (selected.id == 0) {
              return gettextselect;
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
            $result.text(gettextselect);
            return $result;
          } else {
            return $result;
          }
        }
      });
    }

    function data_json(data_list, recno_key, code_key, name_key, gettextselect) {
      var target_list = [{
        "id": 0,
        "text": gettextselect,
        "value": "0",
        "title": ""
      }];
      var existingCodes = {};
      for (var i = 0; i < data_list.length; i++) {
        var select2_recno = data_list[i][recno_key];
        var select2_code = data_list[i][code_key];
        var select2_name = data_list[i][name_key];
        if (select2_code === null) {
          select2_code = '';
        }
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
      if (recno_owner == 0) {
        recno_nowner = '';
      } else {
        recno_nowner = $(this).select2('data')[0].text;
      }
    });


    $("#cust").change(function() {
      recno_cust = $(this).select2('data')[0].value;
      if (recno_cust == 0) {
        recno_namecust = '';
        // $('#custname').val('');
      } else {
        recno_namecust = $(this).select2('data')[0].text;
        // $('#custname').val($(this).select2('data')[0].text);
        if (datasave == 'save') {
          // $('#cont').empty().trigger("change");
          process_select_cust = 0;
          $('#cont').empty().trigger("change");
          select2_contact_list($(this).select2('data')[0].value)
        } else {
          process_select_cust = 0;
          if (frist_search_cont == 1) {
            frist_search_cont = 0;
            process_select_cust = 0;
            search_cont = 1;
            $('#cont').empty().trigger("change");
            select2_contact_list(recno_cust)
          } else {
            $('#cont').empty().trigger("change");
            select2_contact_list($(this).select2('data')[0].value)
          }

        }
      }
    });

    $("#cont").change(function() {
      if (process_select_cust == 1) {
        // console.log('change contact')
        recno_cont = $(this).select2('data')[0].value;
        if (recno_cont == 0) {
          recno_namecont = '';
        } else {
          if (frist_name_cont == 1) {
            // recno_namecont = $(this).select2('data')[0].text;
            $('#contname').val(recno_namecont)
            frist_name_cont = 0;
          } else {
            recno_namecont = $(this).select2('data')[0].text;
            $('#contname').val(recno_namecont)
          }

        }
      }
      // else{
      //    console.log('init')
      // }
    });


    //////////////////////////////////////////////////////////////// SAVE ///////////////////////////////////////////////////////////////

    $("#idForm").submit(function(event) {
      event.preventDefault();
      if (recno_cust == 0) {
        Swal.fire(
          'กรุณาเลือกชื่อบริษัท',
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
          save_json = JSON.parse(response);
          table.ajax.reload();
          if (save_json.status == 'success') {
            Swal.fire({
              title: "บันทึกแล้ว",
              text: "ข้อความที่คุณต้องการแสดง",
              icon: "success",
              buttons: ["OK"],
              dangerMode: true,
            }).then(function(willRedirect) {
              if (willRedirect) {
                $('#myModal').modal('hide');
              }
            });
            setTimeout(function() {
              swal.close(); // ปิด SweetAlert
              $('#myModal').modal('hide');
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
          save_json = JSON.parse(response);
          if (save_json.status == 'success') {
            table.ajax.reload();
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
                $('#myModal').modal('hide');
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

      formData.append('fileToUpload', '');
      $uploadolddb = '';

      /////////////

      var dateValue = $('#date').val();

      console.log()
      /// id ,param ///
      paramhd = {
        RECNO: recno_edit,
        STATUS: $('#status').val(),
        CUSTNAME: recno_namecust,
        // CUSTNAME: $('#custname').val(),
        CONTNAME: $('#contname').val(),
        CUST: recno_cust,
        CONT: recno_cont,
        TEL: $('#phone').val(),
        EMAIL: $('#email').val(),
        ADDR: $('#addr').val(),
        LOCATION: $("input[name='location']:checked").val(),
        SUBJECT: $('#subject').val(),
        DETAIL: $('#detail').val(),
        REMARK: $('#remark').val(),
        REF: $('#ref').val(),
        PRIORITY: $('#priority').val(),
        TIMED: $('#timed').val(),
        TIMEH: $('#timeh').val(),
        TIMEM: $('#timem').val(),
        STARTD: dateValue ? moment(dateValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
        WARND: $('#datewarn').val() ? moment($('#datewarn').val(), 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
        PRICECOST: $('#pcost').val(),
        PRICEPWITHDRAW: $('#pwithdraw').val(),
        OWNERNAMESTR: recno_nowner,
        OWNERNUM: recno_owner,

      };
      // var paramhd = null;
      // เพิ่มอาร์เรย์ paramhd เข้าไปใน FormData และแปลงเป็น JSON ก่อน

      if (conditionsformdata == "save") {
        // ประมวลผลเพิ่มข้อมูล
        // process to insert data
        formData.append('queryIdHD', 'IND_ACTIVITYHD');

      } else if (conditionsformdata == "delete") {
        // ประมวลผลลบข้อมูล
        // process to delete data
      } else {
        formData.append('queryIdHD', 'UPD_ACTIVITYHD');
        // กรณีอื่น ๆ
        // other cases
      }
      formData.append('queryIdDT', '');
      formData.append('condition', 'I_DOC');
      formData.append('uploadnamedb', 'activityhd');
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
    var search_cont = 0;
    var frist_search_cont = 0;
    var frist_name_cont = 0;

    function search_datalist(search_senddata) {
      $.ajax({
        url: encodedURL_Select,
        data: {
          queryId: 'EDSEL_ACTIVITYHD',
          params: {
            RECNO: search_senddata
          },
          condition: 'mix',
        },
        dataSrc: '',
        success: function(response) {
          json_searchdatalist = JSON.parse(response).data;

          recno_edit = json_searchdatalist[0].RECNO;
          recno_cust = json_searchdatalist[0].CUST;
          recno_cont = json_searchdatalist[0].CONT;
          recno_owner = json_searchdatalist[0].OWNER;
          recno_namecont = json_searchdatalist[0].CONTNAME;
          recno_nowner = json_searchdatalist[0].OWNERNAME;

          frist_search_cont = 1;
          frist_name_cont = 1;
          $('#cust').val(json_searchdatalist[0].CUST).trigger('change');

          // console.log(recno_owner)
          $('#owner').val(recno_owner).trigger('change');

          // $('#cont').empty().trigger("change");
          // process_select_cust = 0;
          // search_cont = 1
          // select2_contact_list(recno_cust)

          $('#contname').val(json_searchdatalist[0].CONTNAME)
          $('#phone').val(json_searchdatalist[0].TEL)
          $('#email').val(json_searchdatalist[0].EMAIL)
          $('#addr').val(json_searchdatalist[0].ADDR)
          $('#subject').val(json_searchdatalist[0].SUBJECT)
          $('#detail').val(json_searchdatalist[0].DETAIL)
          $('#remark').val(json_searchdatalist[0].REMARK)
          $('#ref').val(json_searchdatalist[0].REF)
          $('#status').val(json_searchdatalist[0].STATUS)
          $('#priority').val(json_searchdatalist[0].PRIORITY)
          $('#timed').val(json_searchdatalist[0].TIMED)
          $('#timeh').val(json_searchdatalist[0].TIMEH)
          $('#timem').val(json_searchdatalist[0].TIMEM)
          $('#pcost').val(json_searchdatalist[0].PRICECOST)
          $('#pwithdraw').val(json_searchdatalist[0].PRICEPWITHDRAW)
          $('input[name="location"]').filter('[value="' + json_searchdatalist[0].LOCATION + '"]').prop('checked', true);

          $('#date').val(moment(json_searchdatalist[0].STARTD).format('DD/MM/YYYY') !== 'Invalid date' ? moment(json_searchdatalist[0].STARTD).format('DD/MM/YYYY') : '');
          $('#datewarn').val(moment(json_searchdatalist[0].WARND).format('DD/MM/YYYY') !== 'Invalid date' ? moment(json_searchdatalist[0].WARND).format('DD/MM/YYYY') : '');
          // $('#date').val(moment(new Date(json_searchdatalist[0].STARTD)).format('DD/MM/YYYY'));

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