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

      .button-container {
        display: flex;
        gap: 10px;
        /* ระยะห่างระหว่างปุ่ม */
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

        <h2>เพิ่มผู้ใช้งาน</h2>
        <!-- <div class="row">
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
        </div> -->




        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
            <button id='seacrh' type="button" class="btn btn-primary">ค้นหา</button>
          </div>
        </div>

        <hr>

        <div class="row pb-3">

          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
            <button id='newmodel' type="button" class="btn btn-primary">เพิ่มพนักงาน</button>
          </div>
        </div>




        <div class="row">
          <div class="col-12">
            <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
              <thead class="thead-light">
                <tr>
                  <th>ลำดับ</th>
                  <th>ข้อมูล</th>
                  <th>รหัส</th>
                  <th>ชื่อ</th>
                  <th>ชื่อเล่น</th>
                  <th>ระดับ</th>
                  <!-- <th>ผู้ติดต่อ</th>
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
      <div class="modal fade" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-md modal-lg modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel">บันทึกแจ้งซ่อม <span id='story' class="badge"></span></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <!-- ส่วนที่เพิ่มเนื้อหาภายในกล่องโมดอลได้ที่นี่ -->
              <section>
                <div class="container-fluid">
                  <h2 id="dataactivity">ตารางนัดหมาย <span id='story' class="badge"></span></h2>
                  <hr>
                  <div class="row">

                      <div class="input-group mb-3">
                        <span class="input-group-text ">รหัสประจำตัว:</span>
                        <input type="text" class="form-control" id="code" placeholder="กรอกรหัสประจำตัว" maxlength="16">
                      </div>

                      <div class="input-group mb-3">
                        <span class="input-group-text c_activity">ระดับ:</span>
                        <select class="form-select" id="userlevel">
                          <option value="F" selected>ผู้ใช้งาน</option>
                          <option value="T">แอดมิน</option>
                          <!-- <option value="N">ปกติ</option>
                          <option value="L">ต่ำ</option> -->
                        </select>
                      </div>

                      <div class="input-group mb-3">
                        <span class="input-group-text c_activity">ชื่อจริง:</span>
                        <input type="text" class="form-control" id="namereal" placeholder="ชื่อจริง" maxlength="80">
                      </div>

                      <div class="input-group mb-3">
                        <span class="input-group-text c_activity">ชื่อเล่น:</span>
                        <input type="text" class="form-control" id="namenick" placeholder="ชื่อเล่น" maxlength="80">
                      </div>

                      <div class="input-group mb-3">
                        <span class="input-group-text c_activity">Login:</span>
                        <input type="text" class="form-control" id="login" placeholder="ชื่อล๊อคอิน" maxlength="128">
                      </div>

                      <div class="input-group mb-3">
                        <span class="input-group-text c_activity">Password:</span>
                        <input type="password" class="form-control" id="password" placeholder="รหัสผ่าน" maxlength="128">
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
  <script>
    $(document).ready(function()
    {
      var userlevel = "<?php echo isset($_SESSION['USERLEVEL']) ? $_SESSION['USERLEVEL'] : ''; ?>";
      
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
      var qid = 'ALL_EMPL_LIST';
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
        // select2_owner_list();
        // select2_cust_list();
        // select2_equipment_list()
        // console.log(userlevel)
        if (userlevel == "T"){
          console.log('admin')
        }

        $("#date_search").datepicker({
          format: "dd/mm/yyyy",
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
      console.log(userlevel)
      const customModelRender = (row, istatus) => {
        if (istatus == "T") {
          return `<div class="button-container">` + `<button class="btn btn-primary btn-sm view" id="view_table_modal_${row['RECNO']}"><i class="far fa-eye"></i></button>` + `<button class="btn btn-danger btn-sm edit" id="edit_table_modal_${row['RECNO']}"><i class="far fa-edit"></i></button>` + `</div>`;
        } else {
          return `<div class="button-container">` + `<button class="btn btn-primary btn-sm view" id="view_table_modal_${row['RECNO']}"><i class="far fa-eye"></i></button>` + `</div>`;
        }
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
        columns: [{
            data: 'RECNO'
          },
          {
            data: null,
            render: function(data, type, row) {
              // return `<div class="button-container">` + `<button class="btn btn-primary btn-sm view" id="view_table_modal_${row['RECNO']}"><i class="far fa-eye"></i></button>` + `<button class="btn btn-danger btn-sm edit" id="edit_table_modal_${row['RECNO']}"><i class="far fa-edit"></i></button>` + `</div>`;
              // return `<button class="btn btn-primary btn-sm edt" data-bs-toggle="modal" data-bs-target="#edt" data-bs-row-id="${row['RECNO']}"><i class="fa fa-edit"></i></button>`;
              return customModelRender(row,userlevel);
            }
          },
          {
            data: 'EMPNO'
          },
          {
            data: 'EMPNAME'
          },
          {
            data: 'EMPNICK'
          },
          {
            data: 'USERLEVEL'
          },
        ],
        // columnDefs: [{
        //     className: 'noVis',
        //     targets: [0]
        //   },
        //   {
        //     className: 'dt-center',
        //     targets: [3]
        //   },
        //   {
        //     className: 'dt-right',
        //     targets: [8, 9]
        //   },
        //   {
        //     "orderable": false,
        //     "targets": 1
        //   },
        //   {
        //     type: 'currency',
        //     targets: 8
        //   },
        //   {
        //     "visible": false,
        //     "targets": 0
        //   },
        //   // { type: 'de_date', targets: 6 }
        //   {
        //     type: 'th_date',
        //     targets: 6
        //   }
        // ],
        // order: [
        //   [0, 'desc'],
        // ],
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
        datasave = 'update';
        search_datalist(rowData.RECNO);
        $("#myModal").modal("show");
      });


      $('#table_datahd').on('click', '.view', function() {
        var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
        $('#ok').removeClass('btn-primary').addClass('btn-danger').text('บันทึกแก้ไข');
        $('#story').removeClass('bg-secondary').addClass('bg-danger').text('แก้ไข');
        // recno_edit = rowData.RECNO;
        // datasave = 'edit';
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



      $('#seacrh').click(function() {
        // var dateValue = $('#date_search').val();
        // $('#date_search').val('');
        // $('#date').val('');
        // $('#date_first').val('');
        // $('#date_last').val('');
      })



      $('#date_search').val(moment(new Date()).format('DD/MM/YYYY'));

      $("#newmodel").click(function() {

        $('#ok').removeClass('btn-danger').addClass('btn-primary').text('บันทึก');
        $('#story').removeClass('bg-danger').addClass('bg-secondary').text('เพิ่ม');
        datasave = 'save';
        $uploadolddb = '';

        viewstatus = 'T';
        // $('#name').val('');
        // $('#contname').val('');

        // $('#addr').val('')
        // $('#ref').val('')
        // $('#phone').val('');
        // $('#email').val('');
        // $('#subject').val('')
        $("#myModal").modal("show"); // เปิดกล่องโมดอล
      });

      // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
      $(".modal .btn-secondary, .modal .btn-close").click(function() {
        $("#myModal").modal("hide"); // ปิดกล่องโมดอล
      });

      /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



      ///////////////////////////////////////////////////////////////// SELECT DATA //////////////////////////////////////////////////////////////////////////////////////////
      var process_select_cust;
      ///////////////////////////////
      function createSelect2(selector, data, gettextselect) {
        return $(selector).select2({
          data: data,
          theme: 'bootstrap-5',
          dropdownParent: $('#myModal'),
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
   


      //////////////////////////////////////////////////////////////// CHANGE //////////////////////////////////////////////////////////////// 
      var owner_process = 0;

      //////////////////////////////////////////////////////////////// SAVE ///////////////////////////////////////////////////////////////

      var viewstatus = 'F';
      $("#idForm").submit(function(event) {
        event.preventDefault();
        if (viewstatus == 'T')
        {
          AlertSave();
        }
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
            console.log(save_json)
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
        console.log('xx')
        $.ajax({
          url: encodedURL_Update,
          type: "POST",
          data: set_formdata('update'),
          dataSrc: '',
          contentType: false,
          processData: false,
          cache: false,
          beforeSend: function() {},
          complete: function() {},
          success: function(response) {
            save_json = JSON.parse(response);
            if (save_json.status == 'success') {
              console.log(save_json)
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
        /// upload ///

        formData.append('fileToUpload', '');
        $uploadolddb = '';

        /////////////

        var dateValue = $('#date').val();
        console.log('')
        /// id ,param ///
        paramhd = {
          RECNO: recno_edit,
          EMPNO: $('#code').val(),
          EMPNAME: $('#namereal').val(),
          EMPNICK: $('#namenick').val(),
          LOGIN: $('#login').val(),
          PASS: $('#password').val(),
          USERLEVEL: $('#userlevel').val(),
        };
        // var paramhd = null;
        // เพิ่มอาร์เรย์ paramhd เข้าไปใน FormData และแปลงเป็น JSON ก่อน

        if (conditionsformdata == "save") {
          // ประมวลผลเพิ่มข้อมูล
          // process to insert data
          formData.append('queryIdHD', 'IND_EMPL');

        } else if (conditionsformdata == "delete") {
          // ประมวลผลลบข้อมูล
          // process to delete data
          formData.append('queryIdHD', 'XXXXX');
        } else if (conditionsformdata == "update") {
          // ประมวลผลอัพเดทข้อมูล
          // process to update data
          formData.append('queryIdHD', 'UPD_EMPL');
        } else {
          // กรณีอื่น ๆ
          // other cases
        }
        formData.append('queryIdDT', '');
        formData.append('condition', 'I_IMG');
        formData.append('uploadnamedb', 'empl');
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
              SaveData();
            } else if (datasave == "update") {
              UpdateData();
            } else if (datasave == "delete") {
              DeleteData();
            } else {
              // Handle other cases or show an error message
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

      function search_datalist(search_senddata) {
        $.ajax({
          url: encodedURL_Select,
          data: {
            queryId: 'EDSEL_EMP',
            params: {
              RECNO: search_senddata
            },
            condition: 'mix',
          },
          dataSrc: '',
          success: function(response) {
            json_searchdatalist = JSON.parse(response).data;
            // console.log(json_searchdatalist)
            recno_edit = json_searchdatalist[0].RECNO
            $('#code').val(json_searchdatalist[0].EMPNO)
            $('#namereal').val(json_searchdatalist[0].EMPNAME)
            $('#namenick').val(json_searchdatalist[0].EMPNICK)
            $('#login').val(json_searchdatalist[0].LOGIN)
            $('#password').val(json_searchdatalist[0].PASS)
          
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