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
    <div class="container-fluid pt-3">
      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>

      <h2>แจ้งซ่อม</h2>
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
          <button id='newmodel' type="button" class="btn btn-primary">ทำการแจ้งซ่อม</button>
        </div>
      </div>



      <div class="row">
        <div class="col-12">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ข้อมูล</th>
                <th>เลขที่</th>
                <th>หัวข้อเรื่อง</th>
                <th>ชื่ออุปกรณ์</th>
                <th>บุคคลติดต่อ</th>
                <th>สถานะ</th>
                <th>ความสำคัญ</th>
                <th>วันที่นัด</th>
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
                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">หัวข้อเรื่อง:</span>
                      <input type="text" class="form-control" id="name" placeholder="หัวข้อเรื่อง" maxlength="255">
                    </div>
                  </div>
                </div>



                <div class="row">
                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">ชื่ออุปกรณ์:</span>
                      <select class="form-select" id="equipment">
                      </select>
                    </div>
                  </div>


                  <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="input-group mb-3">
                      <span class="input-group-text c_activity">บุคคล:</span>
                      <input type="text" class="form-control" id="cont" placeholder="ติดต่อบุคคล" maxlength="255">
                    </div>
                  </div>


                  <!-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
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
                </div> -->

                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                      <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                          <div class="input-group mb-3">
                            <span class="input-group-text c_activity">สถานะ:</span>
                            <select class="form-select" id="status">
                              <option value="I" selected>รับแจ้ง</option>
                              <option value="P">ดูแล</option>
                              <option value="R">ซ่อม</option>
                              <option value="A">ปกติ</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                          <div class="input-group mb-3">
                            <span class="input-group-text c_activity">ความสำคัญ:</span>
                            <select class="form-select" id="priority">
                              <option value="N" selected>ทั่วไป</option>
                              <option value="H">เร่งด่วน</option>
                              <option value="D">ฉุกเฉิน</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="input-group">
                        <span class="input-group-text">อาการ:</span>
                        <textarea id="detail" class="form-control h_textarea" rows="3" aria-label="textarea a"></textarea>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text c_activity">ค่าใช้จ่าย:</span>
                          <input id="pcost" type="number" min=0 class="form-control">
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text c_activity">ค่าเบิก:</span>
                          <input id="pwithdraw" type="number" min=0 class="form-control">
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group date mb-3" id="datepicker">
                          <span class="input-group-text c_activity">วันที่นัด:</span>
                          <input type="text" class="form-control" id="date" placeholder="วันที่นัดดูแลอุปกรณ์" />
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
    </div>
</body>
<?php include("0_footerjs_piority.php"); ?>
<script src="js/systemdtcolum.js"></script>
<script src="js/systemzero.js"></script>

<script>
  $(document).ready(function() {
    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });

    var recno = null;
    var startd = null;
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;
    var datasave = '';

    var recno_owner = 0;
    var recno_nowner = "";
    var recno_edit;
    var recno_equipment = 0;

    var onprocess = true;
    database_server()
    async function database_server() {
      try {
        const jsonResponse = await fetch('ajax/fecth_get_allwarning.php', {
          method: 'POST',
          body: set_formdata('select_equpiment'),
        });

        if (!jsonResponse.ok) {
          $('.loading').hide();
          throw new Error('Error sending data to server');
        }

        const jsonDataMain = await jsonResponse.json();
        console.log(jsonDataMain)
        await detailtable.clear().rows.add(jsonDataMain.datamain).draw();

        if (onprocess) {
          empl_list = jsonDataMain.dataempl;
          euqip_list = jsonDataMain.dataeuip;
          const dataProcessor = new DataProcessor();
          const processedDataEmpl = await dataProcessor.process(empl_list, 'RECNO', 'EMPNO', 'EMPNAME');
          const processedDataEquip = await dataProcessor.process(euqip_list, 'RECNO', 'CODE', 'NAME');
          const select2Creator = new Select2Creator();
          await select2Creator.createSelect2('#owner', processedDataEmpl, 'เลือก', true);
          await select2Creator.createSelect2('#equipment', processedDataEquip, 'เลือก', true);
        }
        onprocess = false;
        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }






    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    $('#new').click(function() {
      window.location = 'dataequipment.php';
    });

    var data_array = [];
    var detailtable = $('#table_datahd').DataTable({
      scrollX: true,
      columns: dtcolumn('DATA_NOTIMAINTEN', null),
      columnDefs: [
        // {
        //   className: 'noVis',
        //   targets: [0]
        // },
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
      dom: 'frtip',
      buttons: [
        // {
        //   extend: 'colvis',
        //   text: 'Show/Hide',
        //   columns: ':not(.noVis)',
        //   // columnText: function ( dt, idx, title ) {
        //   // return (idx+1)+': '+title;
        //   // }
        // },
        // //  'csv', 
        // {
        //   extend: 'excelHtml5',
        //   title: 'Data export',
        //   exportOptions: {
        //     // columns: [ 2, 3,4,5,6,7,8,9,10 ]
        //     columns: [1, 2]
        //   }
        // }
      ],

      initComplete: function(settings, json) {},
      createdRow: function(row, data, dataIndex) {},
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
      //
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
      recno_edit = null;

      recno_owner = 0;
      recno_nowner = '';
      recno_equipment = 0;
      $uploadolddb = '';
      $('#name').val('');
      $('#equipment').val(0).trigger('change');
      $('#cont').val('');
      $('#phone').val('');
      $('#email').val('');
      $('#status').val('I');
      $('#priority').val('N');
      $('#pcost').val(0);
      $('#pwithdraw').val(0);
      $('#detail').val('');
      $('#owner').val(0).trigger('change');
      $('#date').val('');

      // $('#fileToUpload').val('');
      $("#myModal").modal("show"); // เปิดกล่องโมดอล
    });

    // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
    $(".modal .btn-secondary, .modal .btn-close").click(function() {
      $("#myModal").modal("hide"); // ปิดกล่องโมดอล
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ///////////////////////////////////////////////////////////////// SELECT DATA //////////////////////////////////////////////////////////////////////////////////////////


    //////////////////////////////////////////////////////////////// CHANGE //////////////////////////////////////////////////////////////// 

    $("#owner").change(function() {
      recno_owner = $(this).select2('data')[0].id;
      if (recno_owner == 0) {
        recno_nowner = '';
      } else {
        recno_nowner = $(this).select2('data')[0].text;
      }
      console.log(recno_owner)
    });

    $("#equipment").change(function() {
      recno_equipment = $(this).select2('data')[0].id;
      if (recno_equipment == 0) {
        recno_equipment = '';
      } else {
        recno_equipment = $(this).select2('data')[0].text;
      }
    });

    //////////////////////////////////////////////////////////////// SAVE ///////////////////////////////////////////////////////////////

    $("#idForm").submit(function(event) {
      event.preventDefault();
      // if ($('#name').val().trim() == '') {
      //   Swal.fire(
      //     'กรุณาเลือกชื่อใส่ชื่ออุปกรณ์',
      //     'ไม่สามารถบันทึกได้',
      //     'error'
      //   )
      //   return false
      // }
      AlertSave()
    });

    var paramhd;
    /////////////////////////////////////////////////////////////// INSERT AND UPDATE ///////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////// SAVE //////////////////////////////////////////////////////////////
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
        console.log(data)
        if (status_sql === 'save') {
          await Swal.fire({
            title: "บันทึกแล้ว",
            text: "ข้อมูลถูกบันทึก",
            icon: "success",
            buttons: ["OK"],
            dangerMode: true,
          });
          await database_server();
        } else if (status_sql === 'select') {
          await search_equipment(data.datamain);
        } else if (status_sql === 'update') {
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
    // ////////////////////////////////////////////////////////////// UPDATE //////////////////////////////////////////////////////////////
    var modify = 'F';
    ////////////////////////////////////////////////////////////// set_formdata //////////////////////////////////////////////////////////////
    function set_formdata(conditionsformdata) {
      var formData = new FormData();
      formData.append('name', $('#name').val());

      /// upload ///
      // var selectedFile = $('#fileToUpload')[0].files[0];
      // if (selectedFile) {
      //   formData.append('fileToUpload', selectedFile);
      //   modify = 'T';
      // } else {
      //   modify = 'F';
      //   formData.append('fileToUpload', undefined);
      // }

      var warningValue = $('#date').val();
      // var purchaseValue = $('#date').val();
      var firstUsageValue = $('#date_first').val();
      var lastUsageValue = $('#date_last').val();

      /// id ,param ///
      paramhd = {
        recno: recno_edit,
        name: $('#name').val(),
        equipment: $('#equipment').val(),
        contname: $('#cont').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),
        status: $('#status').val(),
        priority: $('#priority').val(),
        pricecost: $('#pcost').val(),
        pricepwithdraw: $('#pwithdraw').val(),
        details: $('#detail').val(),
        warningdate: warningValue ? moment(warningValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
        recorderno: recno_owner,
        recordername: recno_nowner,
      };

      if (conditionsformdata == "select_equpiment") {
        formData.append('queryId001', 'SEL_NOTIMAINTEN');
        formData.append('queryId002', 'SEL_EQUIPMENT_DR');
        formData.append('queryId003', 'EMPL_LIST');
        formData.append('condition', '000');
        formData.append('tableData', JSON.stringify([]));
      } else if (conditionsformdata == "save") {
        formData.append('queryId001', 'IND_NOTIMAINTEN');
        formData.append('condition', '003_INNOTIMATANCE');
        formData.append('tableData', JSON.stringify([paramhd]));
      } else if (conditionsformdata == "select") {
        formData.append('queryIdHD', 'EDSEL_NOTIMAINTEN');
        formData.append('condition', 'RECNO000');
        formData.append('tableData', JSON.stringify([paramhd]));
      } else if (conditionsformdata == "update") {
        formData.append('queryIdHD', 'UPD_NOTIMAINTEN');
        formData.append('condition', '003_UPNOTIMATANCE');
        // formData.append('modify', modify);
        formData.append('tableData', JSON.stringify([paramhd]));
        // formData.append('uploadolddb', uploadolddb);
      } else {
        formData.append('queryIdHD', 'UPD_NOTIMAINTEN');
      }


      // formData.append('queryIdDT', '');
      // formData.append('condition', 'I_ID');
      // formData.append('uploadnamedb', 'notimainten');
      // formData.append('uploadolddb', $uploadolddb);
      // formData.append('modify', modify);

      // formData.append('paramhd', JSON.stringify(paramhd));
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
        },
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          const crudManager = new CRUDManager(
            datasave === "save" ? 'ajax/fecth_post_innotimainten.php' : 'ajax/fecth_post_upnotimainten.php', datasave === "save" ? 'save' : 'update'
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
      // console.log(json_equipment)
      recno_edit = json_equipment[0].RECNO;
      $('#name').val(json_equipment[0].NAME);
      $('#cust').val(json_equipment[0].CUSTNAME);
      $('#cont').val(json_equipment[0].CONTNAME);
      $('#phone').val(json_equipment[0].PHONE);
      $('#email').val(json_equipment[0].EMAIL);
      $('#status').val(json_equipment[0].STATUS);
      $('#priority').val(json_equipment[0].PRIORITY);
      $('#pcost').val(json_equipment[0].PRICECOST);
      $('#pwithdraw').val(json_equipment[0].PRICEPWITHDRAW);
      $('#detail').val(json_equipment[0].DETAILS);
      $('#owner').val(json_equipment[0].RECORDERNO).trigger('change');
      $('#equipment').val(json_equipment[0].EQUIPMENT).trigger('change');
      $('#date').val(moment(json_equipment[0].WARNINGDATE).format('DD/MM/YYYY') !== 'Invalid date' ? moment(json_equipment[0].WARNINGDATE).format('DD/MM/YYYY') : '');
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