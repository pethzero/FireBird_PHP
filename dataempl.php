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

    .button-container {
      display: flex;
      gap: 10px;
      /* ระยะห่างระหว่างปุ่ม */
    }
  </style>
  <link href="layout/bs5/dashboard.css" rel="stylesheet">
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

          <div class="row mt-2">
            <div class="col-md-12">
              <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                  <section>
                    <div class="main_data">
                      <h2>ผู้ใช้งาน</h2>
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
                                <th>ผู้ใช้งาน</th>
                                <th>รหัส</th>
                                <th>ชื่อ</th>
                                <th>ชื่อเล่น</th>
                                <th>ระดับ</th>
                                <th width='3%'>ลบ</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                      </div>

                    </div>
                  </section>

                  <section>
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
                                      <?php
                                      // ตรวจสอบค่าของ SESSION USERLEVEL และแสดง <option> เพิ่มเติม
                                      if ($_SESSION['USERLEVEL'] == 'S') {
                                        echo '<option value="S">super admin</option>';
                                      }
                                      ?>
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
                                    <span class="input-group-text c_activity">ผู้ใช้งาน:</span>
                                    <input type="text" class="form-control" id="login" placeholder="ชื่อล๊อคอิน" maxlength="128">
                                  </div>

                                  <div class="input-group mb-3" style="display: none;" >
                                    <span class="input-group-text c_activity">รหัสผ่าน:</span>
                                    <input type="pass" class="form-control" id="pass" placeholder="รหัสผ่าน" maxlength="128" autocomplete="current-pass">

                                  </div>
                                </div>
                              </div>
                            </section>
                          </div>

                          <div class="modal-footer">
                            <button id="ok" type="submit" name='savedata' class="btn btn-danger">แก้ไข</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>


                </div>
              </div>
            </div>
          </div>

        </form>
      </main>
    </div>
  </div>
</body>
<?php include("0_footerjs.php"); ?>
<script>
  $(document).ready(function() {
    var userlevel = "<?php echo isset($_SESSION['USERLEVEL']) ? $_SESSION['USERLEVEL'] : ''; ?>";
    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });

    var recno = null;
    var selectedRow = null;
    var selectedRecno = null;
    var datasave = '';
    var recno_edit;
    var dataold = {
      old_empno: '',
      old_login: ''
    };
    var paramhd;
    var viewstatus = 'F';

    $(function() {
      if (userlevel == "F") {
        $("#newmodel").remove();
      }
    });
    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    const customModelRender = (row, istatus) => {
      if (istatus == "T" || istatus == "S") {
        return `<div class="button-container">` + `<button class="btn btn-primary btn-sm view" id="view_table_modal_${row['RECNO']}"><i class="far fa-eye"></i></button>` + `<button class="btn btn-danger btn-sm edit" id="edit_table_modal_${row['RECNO']}"><i class="far fa-edit"></i></button>` + `</div>`;
      } else {
        return `<div class="button-container">` + `<button class="btn btn-primary btn-sm view" id="view_table_modal_${row['RECNO']}"><i class="far fa-eye"></i></button>` + `</div>`;
      }
    };

    const customModelDelete = (row, istatus) => {
      if (istatus == "T" || istatus == "S") {
        return `<div class="button-container">` + `<button class="btn btn-danger btn-sm trash" id="trash_table_modal_${row['RECNO']}"><i class="fa fa-trash"></i></button>` + `</div>`;
      } else {
        return `<div class="button-container">` + `<button class="btn btn-danger btn-sm trash""><i class="fa fa-trash"></i></button>` + `</div>`;
      }
    };

    var detailtable = $('#table_datahd').DataTable({
      scrollX: true,
      columns: [{
          data: 'RECNO'
        },
        {
          data: null,
          render: function(data, type, row) {
            return customModelRender(row, userlevel);
          }
        },
        {
          data: 'LOGIN'
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
        {
          data: null,
          render: function(data, type, row) {
            return customModelDelete(row, userlevel);
          }
        },
      ],
      columnDefs: [{
          className: 'noVis',
          targets: [0]
        },
        {
          "visible": false,
          "targets": 0
        },
        {
          "orderable": false,
          "targets": 1
        },
      ],
      order: [
        [3, 'asc'],
      ],
      dom: 'Bfrtip',
      buttons: [{
          extend: 'colvis',
          text: 'Show/Hide',
          columns: ':not(.noVis)',
        },
        {
          extend: 'excelHtml5',
          title: 'Data export',
          exportOptions: {
            columns: [1, 2]
          }
        }
      ],

      initComplete: function(settings, json) {
        var api = this.api();
        if (userlevel !== "S") {
          api.column(6).visible(false);
        }
      },
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

    // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
    $(".modal .btn-secondary, .modal .btn-close").click(function() {
      $("#myModal").modal("hide"); // ปิดกล่องโมดอล
    });

    $("#newmodel").click(function() {
      recno_edit = -1
      buttontable("new")
    });

    $('#table_datahd').on('click', '.edit', function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      recno_edit = rowData.RECNO;
      buttontable("update")
    });

    $('#table_datahd').on('click', '.trash', function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      recno_edit = rowData.RECNO;
      dataurl = "ajax/fecth_delete_standard.php";
      datasave = "delete";
      AlertSave(dataurl, datasave);
    });

    $('#table_datahd').on('click', '.view', function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      recno_edit = rowData.RECNO;
      buttontable("view")

    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
        console.log(data);
        if (status_sql === 'save' || status_sql === 'update') {
          if (data.status === 'warnning') {
            await alertmessage(data.message, 'กรุณากรอกข้อมูลใหม่', 'error', 'OK');
          } else if (data.status === 'success') {
            const successMessage = status_sql === 'save' ? 'บันทึกแล้ว' : 'แก้ไขแล้ว';
            const successDetail = status_sql === 'save' ? 'ข้อมูลถูกบันทึก' : 'ข้อมูลถูกแก้ไข';
            await database_server();
            await alertmessage(successMessage, successDetail, 'success', 'OK');
            await $("#myModal").modal("hide");
          }
        } else if (status_sql === 'select_id') {
          await search_datalist(data.datamain);
          console.log("select")
        } else if (status_sql === 'delete') {
          if (data.status === "success") {
            await database_server();
            await alertmessage("ข้อมูลถูกลบแล้ว", "ข้อมูลถูกลบเรียบร้อย", 'success', 'OK');
          } else if (data.status === "warning") {
            await database_server();
            Swal.fire({
              title: 'ตรวจพบความขัดข้อง',
              html: '<img src="doc/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>ข้อมูลมีคนลบไปแล้ว</h4>',
              icon: 'warning',
              confirmButtonText: 'OK'
            });
          }
        }

      } catch (error) {
        // จัดการข้อผิดพลาด
        console.error(error);
      }
    };

    function alertmessage(data_title, data_text, data_icon, data_buttons) {
      Swal.fire({
        title: data_title,
        text: data_text,
        icon: data_icon,
        buttons: [data_buttons],
        dangerMode: true,
      });
    }
    ///////////////////////////////////////////////////////////////// SELECT DATA //////////////////////////////////////////////////////////////////////////////////////////
    database_server()
    async function database_server() {
      try {
        // $('.loading').show();
        const jsonResponse = await fetch('ajax/fecth_select_item.php', {
          method: 'POST',
          body: set_formdata('select_all'),
        });

        if (!jsonResponse.ok) {
          $('.loading').hide();
          throw new Error('Error sending data to server');
        }

        const jsonDataMain = await jsonResponse.json();
        datajson = jsonDataMain
        await detailtable.clear().rows.add(datajson.datamain).draw();


        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }


    //////////////////////////////////////////////////////////////// SAVE ///////////////////////////////////////////////////////////////
    $("#idForm").submit(function(e) {
      event.preventDefault();
      var clickedButtonName = e.originalEvent.submitter.name;
      console.log('suub', clickedButtonName)
      if (clickedButtonName == "savedata") {
        if (viewstatus == 'T') {
          if ($('#code').val().trim() === '' || $('#login').val().trim() === '' ) {
            let messagedata;
            if ($('#code').val().trim() === '') {
              messagedata = "กรุณากรอกรหัสประจำตัว"
            }
            else if ($('#login').val().trim() === '') {
              messagedata = "กรุณากรอกรหัสไอดีผู้ใช้งาน"
            }
            // else if ($('#pass').val().trim() === '') {
            //   messagedata = "กรุณากรอกรหัสผ่าน"
            // }
            Swal.fire({
                title: messagedata,
                text: "ข้อมูลไม่สามารถบันทึกหรือแก้ไขได้",
                icon: "error",
                buttons: ["OK"],
                dangerMode: true,
              }

            );
          } else {
            let dataurl;
            if (datasave == "save") {
              dataurl = 'ajax/fecth_insert_exist.php';
            } else if (datasave == "update") {
              dataurl = 'ajax/fecth_update_exist.php';
            }
            AlertSave(dataurl, datasave)
          }
        }
      }
    });

    ////////////////////////////////////////////////////////////// set_formdata //////////////////////////////////////////////////////////////
    function set_formdata(conditionsformdata) {
      var formData = new FormData();
      paramhd = {
        recno: recno_edit,
        empno: $('#code').val().trim(),
        empname: $('#namereal').val().trim(),
        empnick: $('#namenick').val().trim(),
        login: $('#login').val().trim(),
        pass: $('#pass').val().trim(),
        userlevel: $('#userlevel').val().trim(),
        old_empno: dataold['old_empno'],
        old_login: dataold['old_login'],
      };

      const mappingData = {
        select_all: {
          queryIdHD: 'ALL_EMPL_LIST',
          condition: '000'
        }, //
        select_id: {
          queryIdHD: 'ID_EMPL_LIST',
          condition: 'RECNO000'
        }, //
        save: {
          queryIdHD: 'IND_EMPL_HASH',
          condition: 'EMPNOIND',
          checkData: 'CHECK_EMPL_COUNT',
          checkCondition: 'EMPNOCHECK'
        }, //
        update: {
          queryIdHD: 'UPD_EMPL',
          condition: 'EMPNOUPD',
          checkData: 'CHECK_EMPL_COUNT',
          checkCondition: 'EMPNOCHECK'
        }, //
        delete: {
          queryIdHD: 'DLD_EMPL',
          condition: 'RECNO000',
          checkData: 'CHECK_EMPL_RECNO',
          checkCondition: 'RECNO000'
        }, //
      };
      const selectedMapping = mappingData[conditionsformdata] || {};
      const {
        queryIdHD = '',
          condition = '',
          checkData = '',
          checkCondition = '',
      } = selectedMapping;

      formData.append('queryIdHD', queryIdHD);
      formData.append('condition', condition);
      formData.append('checkData', checkData);
      formData.append('checkCondition', checkCondition);
      formData.append('tableData', JSON.stringify([paramhd]));
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
          // $("#myModal").modal("hide");
        } catch (error) {
          console.error('เกิดข้อผิดพลาดใน CRUDSQL:', error);
        }
      }
    }

    function AlertSave(url, status_sql) {
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
          if (status_sql !== '') {
            const crudManager = new CRUDManager(url, status_sql);
            crudManager.performCRUD();
          } else {
            Swal.fire({
              title: 'ลบข้อมูล',
              text: "สิ่งที่ลบไปไม่มีวันกลับมา",
              icon: "error",
              buttons: ["OK"],
              dangerMode: true,
            });
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
    function buttontable(databutton) {
      const resetFields = () => {
        $('#code, #namereal, #namenick, #login, #pass').val('');
        $('#userlevel').val('F');
      };

      const setButtonAttributes = (btnRemove, btnAdd, btnText, bgRevmoe, bgAdd, bgText) => {
        $('#ok').removeClass(`${btnRemove}`).addClass(`${btnAdd}`).text(btnText);
        $('#story').removeClass(`${bgRevmoe}`).addClass(`${bgAdd}`).text(bgText);
      };

      const showData = () => {
        CRUDSQL('ajax/fecth_item_pass.php', 'select_id')
          .then(() => $("#myModal").modal("show"))
          .catch(error => console.error('เกิดข้อผิดพลาดใน CRUDSQL:', error));
      };
      if (databutton === "new") {
        viewstatus = 'T';
        datasave = 'save';
        resetFields();
        setButtonAttributes('btn-danger btn-success', 'btn-primary', 'บันทึก', 'bg-danger bg-success', 'bg-secondary', 'เพิ่ม');
        $("#myModal").modal("show")
      } else if (databutton === "update" || databutton === "view") {
        viewstatus = databutton === "update" ? 'T' : 'F';
        datasave = databutton === "update" ? 'update' : '';
        const btnRemove = databutton === "update" ? 'btn-primary btn-success' : 'btn-primary btn-danger';
        const btnAdd = databutton === "update" ? 'btn-danger' : 'btn-success';
        const btnText = databutton === "update" ? 'บันทึกแก้ไข' : 'ดูรายการ';

        const bgRevmoe = databutton === "update" ? 'bg-secondary bg-success' : 'bg-secondary bg-danger';
        const bgAdd = databutton === "update" ? 'bg-danger' : 'bg-success';
        const bgText = databutton === "update" ? 'แก้ไข' : 'ดูรายการ';
        setButtonAttributes(btnRemove, btnAdd, btnText, bgRevmoe, bgAdd, bgText);
        showData();
      }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function search_datalist(json_searchdatalist) {
      const fieldMappings = {
        code: 'EMPNO',
        namereal: 'EMPNAME',
        namenick: 'EMPNICK',
        login: 'LOGIN',
        // pass: 'PASS',
        userlevel: 'USERLEVEL',
      };

      const data_list = json_searchdatalist[0];
      recno_edit = data_list.RECNO;
      Object.entries(fieldMappings).forEach(([elementId, fieldName]) => {
        // ถ้า data_list[fieldName] เป็น null หรือ undefined ให้กำหนดค่าเป็น ''
        const fieldValue = data_list[fieldName] ?? '';
        if (fieldName === 'USERLEVEL' && fieldValue === '') {
          $(`#${elementId}`).val('F');
        } else {
          $(`#${elementId}`).val(fieldValue);
        }
      });
      dataold['old_empno'] = data_list.EMPNO;
      dataold['old_login'] = data_list.LOGIN;
    }

    ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////
    $('#backhis').click(function() {
      window.location = 'main.php';
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////


  });
</script>

</html>