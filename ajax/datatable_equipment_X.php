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

 
    <div class="loading" style="display: block;"></div>

  <section>
    <div class="container-fluid pt-3">

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>

      <h2>อุปกรณ์และเครื่องจักร</h2>
      <hr>

      <div class="row pb-3">
   
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <button id='newmodel' type="button" class="btn btn-primary">เพิ่มอุปกรณ์และเครื่องจักร</button>
        </div>
      </div>


      <div class="row">
        <div class="col-12">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle" width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ข้อมูล</th>
                <th>เลขที่</th>
                <th>ชื่อ</th>
                <th>ประเภท</th>
                <th>รหัส</th>
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
            <h5 class="modal-title" id="myModalLabel">อุปกรณ์ <span id='story' class="badge"></span></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <!-- ส่วนที่เพิ่มเนื้อหาภายในกล่องโมดอลได้ที่นี่ -->
            <section>
              <div class="container-fluid">
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
                            <option value="R">ซ่อม</option>
                            <option value="E">เสียหาย</option>
                            <option value="C">ยกเลิก</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text c_activity">การใช้งาน:</span>
                          <select class="form-select" id="priority">
                            <option value="N" selected>ปกติ</option>
                            <option value="H">เร่งด่วน</option>
                            <option value="D">ฉุกเฉิน</option>
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
                    <input class="form-control" type="file" id="fileToUpload" accept=".jpg, .jpeg, .png">
                  </div>
                </div>

                <div class="row">
                  <div class="">
                    <label for="fileLabel" class="form-label" id="fileLabel"> </label>
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
</body>
<?php 
include("0_footerjs_piority.php");
?>

<script src="js/systemdtcolum.js"></script>


<script>
  $(document).ready(function() {

    // รับ element input จาก DOM
    var fileInput = document.getElementById('fileToUpload');

    // เพิ่ม event listener เมื่อมีการเลือกไฟล์
    fileInput.addEventListener('change', function(event) {
      var file = event.target.files[0]; // ไฟล์ที่ถูกเลือก

      if(file !== undefined)
      {
        if (file.size > 10 * 1024 * 1024) {
          alert('ไฟล์ขนาดเกิน 10MB ไม่ได้รับอนุญาต');
          fileInput.value = ''; // ล้างค่า input ให้สามารถเลือกไฟล์ใหม่ได้
          return;
        }

        // var allowedTypes = ['application/pdf', 'image/jpg', 'image/png', 'image/jpeg', 'image/gif'];
        var allowedTypes = ['image/jpg', 'image/png', 'image/jpeg'];
        if (!allowedTypes.includes(file.type)) {

        Swal.fire(
              'รูปแบบไฟล์ไม่ได้รับอนุญาต',
              'รองรับเฉพาะ JPG และ PNG',
              'error'
            )

          // alert('รูปแบบไฟล์ไม่ได้รับอนุญาต (รองรับเฉพาะ JPG และ PNG )');
          fileInput.value = ''; // ล้างค่า input ให้สามารถเลือกไฟล์ใหม่ได้
          return;
        }
      }

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
    var  uploadolddb = '';

    var startd = null;
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;
    var datasave = '';

    var recno_owner = 0;
    var recno_nowner = "";
    var recno_edit;



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
    var detailtable = $('#table_datahd').DataTable({
      scrollX: true,
      columns:  dtcolumn('DATA_EQUIPMENT', null) ,
      columnDefs: [
        // {
        //   className:'dt-center',
        //   targets: [2]
        // },
        {
          "visible": false,
          "targets": 0
        },
      ],
      order: [
        [0, 'desc'],
      ],
      dom: 'frtip',
      createdRow: function(row, data, dataIndex) {},
      drawCallback: function(settings) {},
      rowCallback: function(row, data) {
        $(row).on('click', function() {
          if (selectedRow !== null) {
            $(selectedRow).removeClass('table-custom');
          }
          $(this).addClass('table-custom');
          selectedRow = this;
          if (selectedRecno !== data.RECNO) {
            selectedRecno = data.RECNO;
          }
        });
      },
    });

    var onprocess = true;
    $('#newmodel').prop('disabled', true);

    database_server()
    async function database_server() {
      try {
        const jsonResponse = await fetch('ajax/fecth_get_allequiment.php', {
          method: 'POST',
          body: set_formdata('select_all') ,
        });

        if (!jsonResponse.ok) {
          $('.loading').hide();
          throw new Error('Error sending data to server');
        }

        const jsonDataMain = await jsonResponse.json();
        console.log(jsonDataMain)
        await detailtable.clear().rows.add(jsonDataMain.datamain).draw();

        if(onprocess){
          owner_list = jsonDataMain.dataowner;
           data_owner_name = await data_json(owner_list, 'RECNO', 'EMPNO', 'EMPNAME'); // กำหนดค่าใหม่ให้กับ data_owner_name
          await createSelect_owner('#owner', data_owner_name)
          await $('#newmodel').prop('disabled', false);

        }
        onprocess = false;
        // console.log('GetData')
        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }


    $("#newmodel").click(function() {
      $('#ok').removeClass('btn-danger').addClass('btn-primary').text('บันทึก');
      $('#story').removeClass('bg-danger').addClass('bg-secondary').text('เพิ่ม');
    
      datasave = 'save';
      recno_edit = null;
      recno_owner = 0;
      recno_nowner = '';
      uploadolddb = '';

      $("#fileLabel").html('');
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
      $('#priority').val('N');
      $('#warranty').val(0);
      $('#maintenance').val(0);
      $('#detail').val('');
      $('#owner').val(0).trigger('change');
      $('#date').val('');
      $('#date_first').val('');
      $('#date_last').val('');
      $('#fileToUpload').val('');
      $("#myModal").modal("show"); // เปิดกล่องโมดอล
    });

    $('#table_datahd').on('click', '.edit', function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      $('#ok').removeClass('btn-primary').addClass('btn-danger').text('บันทึกแก้ไข');
      $('#story').removeClass('bg-secondary').addClass('bg-danger').text('แก้ไข');

      datasave = 'update';
      recno_edit = rowData.RECNO;
      CRUDSQL('ajax/fecth_item.php', 'select')
      .then(() => {
           console.log('end')
           $("#myModal").modal("show");
          })
          .catch(error => {
            console.error('เกิดข้อผิดพลาดใน CRUDSQL:', error);
          });
    });


    // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
    $(".modal .btn-secondary, .modal .btn-close").click(function() {
      $("#myModal").modal("hide"); // ปิดกล่องโมดอล
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ///////////////////////////////////////////////////////////////// SELECT DATA //////////////////////////////////////////////////////////////////////////////////////////
    function createSelect_owner(selector, data) {
      return $(selector).select2({
        data: data,
        theme: 'bootstrap-5',
        dropdownParent: $('#myModal .modal-content'),
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
    $("#owner").change(function() {
      recno_owner = $(this).select2('data')[0].value;
      if (recno_owner == 0) {
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
      //////////////////////////////////////////////////////////// CRUDSQL ////////////////////////////////////////////////////////////
      const CRUDSQL = async (url, status_sql) => {
        const apiUrl = url;
        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                body: set_formdata(status_sql), // ใช้ FormData เป็นข้อมูลที่จะส่ง
            });

            if (!response.ok) {
                throw new Error('เกิดข้อผิดพลาดในการส่งข้อมูล');
            }

            const data = await response.json();

            if (status_sql === 'save') {
                await Swal.fire({
                    title: "บันทึกแล้ว",
                    text: "ข้อมูลถูกบันทึก",
                    icon: "success",
                    buttons: ["OK"],
                    dangerMode: true,
                });
                await database_server();
            }
            else if(status_sql === 'select'){
              await search_equipment(data.datamain);
            }
            else if(status_sql === 'update'){
              await Swal.fire({
                    title: "แก้ไขแล้ว",
                    text: "ข้อมูลถูกแก้ไข",
                    icon: "success",
                    buttons: ["OK"],
                    dangerMode: true,
                });
              await database_server();
            }
        } catch (error) {
            // จัดการข้อผิดพลาด
            console.error(error);
        }
    };

    ////////////////////////////////////////////////////////////// SAVE //////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// UPDATE /////////////////////////////////////////////////////////////
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
        formData.append('fileToUpload', undefined);
      }
   
      var purchaseValue = $('#date').val();
      var firstUsageValue = $('#date_first').val();
      var lastUsageValue = $('#date_last').val();

      /// id ,param ///
      paramhd = {
        recno: recno_edit,
        name: $('#name').val(),
        type: $('#type').val(),
        code: $('#code').val(),
        model: $('#model').val(),
        custname: $('#cust').val(),
        contname: $('#cont').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),
        area: $('#area').val(),
        docinfo: $('#docno').val(),
        status: $('#status').val(),
        priority: $('#priority').val(),
        warranty: $('#warranty').val(),
        maintenancetimes: $('#maintenance').val(),
        brokentimes: '',
        details: $('#detail').val(),
        purchasedate: purchaseValue ? moment(purchaseValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
        firstusage: firstUsageValue ? moment(firstUsageValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
        lastusage: lastUsageValue ? moment(lastUsageValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
        recorderno: recno_owner,
        recordername: recno_nowner,
      };

      // console.log(uploadolddb)
      // console.log(modify)
      if (conditionsformdata == "select_all") {
        formData.append('queryIdHD', 'SEL_EQUIPMENT');
        formData.append('queryIdOwner', 'EMPL_LIST');
        formData.append('condition', '000');
        formData.append('tableData', JSON.stringify([]));
      }
      else if (conditionsformdata == "select") {
        formData.append('queryIdHD', 'IDSEL_EQUIPMENT');
        formData.append('condition', 'RECNO000');
        formData.append('tableData', JSON.stringify([paramhd]));
      }
      else if (conditionsformdata == "save") {
        formData.append('queryIdHD', 'IND_EQUIPMENT');
        formData.append('condition', '003_INEEQUIP');
        formData.append('tableData', JSON.stringify([paramhd]));
      } else if (conditionsformdata == "delete") {
      } else if (conditionsformdata == "update") {
        formData.append('queryIdHD', 'UPD_EQUIPMENT');
        formData.append('condition', '003_UPDEQUIP');
        formData.append('modify', modify);
        formData.append('tableData', JSON.stringify([paramhd]));
        formData.append('uploadolddb', uploadolddb);
      }
      formData.append('paramhd', JSON.stringify(paramhd));
      ////////////////
      return formData;
    }

    ////////////////////////////////////////////////////////////// UPDATE //////////////////////////////////////////////////////////////
    class CRUDManager {
      constructor(url, action) {
        this.url = url;
        this.action = action;
      }

      async performCRUD() {
        try {
          await CRUDSQL(this.url, this.action);
          $("#myModal").modal("hide");
        } catch (error) {
          console.error('เกิดข้อผิดพลาดใน CRUDSQL:', error);
        }
      }
    }

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
    },reverseButtons: true
  }).then((result) => {
    if (result.isConfirmed) {
      const crudManager = new CRUDManager(
        datasave === "save"? 'ajax/fecth_post_inequiment.php': 'ajax/fecth_post_upequiment.php',datasave === "save" ? 'save' : 'update'
      );
      crudManager.performCRUD();
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire(
        'ยกเลิก',
        'ยังไม่มีการบันทึก',
        'error'
      );
    }
  });
}
 
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function search_equipment(json_equipment) {
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

          if (json_equipment[0].UPLOAD) {
            uploadolddb = json_equipment[0].UPLOAD;
            $("#fileLabel").html('โหลดไฟล์แนบเอกสาร: <a id="downloadLink" href="uploads/' + json_equipment[0].UPLOAD + '" download>Download Here</a>');
          } else {
            uploadolddb = '';
            $("#fileLabel").html('โหลดไฟล์แนบเอกสาร: ไม่มี');
          }
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